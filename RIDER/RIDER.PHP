<!-- ==================== PAGE TITLE ==================== -->
<title>Rider Dashboard</title>

<!-- ==================== LOGO AND HEADER ==================== -->
<p id="logo_name">PARCEL TRACKER</p>
<p id="logo_subname">PARCEL TRACKING SYSTEM</p>
<!-- ==================== NAVIGATION MENU ==================== -->
<div id="nav_box">
    <button onclick="user()">USER VIEW</button>
    <button onclick="rider()">RIDER DASHBOARD</button>
    <button onclick="logout()">LOGOUT</button>
</div>
<!-- ==================== NAVIGATION SCRIPT ==================== -->
<script src="../NAV-BUTTON.JS"></script>
    
<?php
// ==================== DATABASE CONNECTION ====================
include '../DB.PHP';
// ==================== START SESSION ====================
session_start();
// ==================== SEARCH FUNCTION ====================
if (isset($_POST['search_btn'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT * FROM parcel
            WHERE tracking_code LIKE '%$search%'
            OR receiver_name LIKE '%$search%'
            OR rider_name LIKE '%$search%'
            OR address LIKE '%$search%'
            OR price LIKE '%$search%'
            OR location LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
    // ==================== SEARCH ERROR ====================
    if (!$result) {
        echo "<script>alert('Search error! Showing all parcels instead.');</script>";
        $result = mysqli_query($conn, "SELECT * FROM parcel");
    }
} else {
    $result = mysqli_query($conn, "SELECT * FROM parcel");
    if (!$result) {
        echo "<script>alert('Unable to load parcels! Please refresh the page.');</script>";
        $result = false;
    }
}
// ==================== PAGE TITLE ====================
echo "<h1>RIDER DASHBOARD</h1>";
// ==================== SUCCESS MESSAGE ====================
if (isset($_GET['msg'])) {
    echo "<script>alert('Update Successful!');</script>";
}
// ==================== SEARCH FORM ====================
echo "<form method='POST' id='search-form'>";
echo "<input id='search' type='text' name='search' placeholder='Search any info here...' autocomplete='off'>";
echo "<button id='search_btn' type='submit' name='search_btn'>Search</button>";
echo "</form>";
// ==================== TABLE HEADER ====================
echo "<table cellpadding=5>";
echo "<tr>";
echo "<th>TRACKING CODE</th>";
echo "<th>ADDRESS</th>";
echo "<th>PRICE</th>";
echo "<th>LOCATION</th>";
echo "<th>STATUS</th>";
echo "</tr>";
// ==================== TABLE DATA ====================
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $row_id = $row['id'];
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['tracking_code']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['price']) . "</td>";
        // ==================== LOCATION COLUMN ====================
        echo "<td>";
        echo "<div style='display:flex; justify-content:space-between; align-items:center; gap:5px;'>";
        echo "<span>" . htmlspecialchars($row['location']) . "</span>";
        echo "</div>";
        echo "</td>";
        // ==================== STATUS COLUMN ====================
        echo "<td>";
        echo "<form method='POST' action='update-status.php' style='margin:0;'>";
        echo "<input type='hidden' name='parcel_id' value='$row_id'>";
        echo "<input type='hidden' name='track_code' value='" . htmlspecialchars($row['tracking_code']) . "'>";
        echo "<input type='hidden' name='new_location' value='" . htmlspecialchars($row['location']) . "'>";
        echo "<select id='new_status' name='new_status' onchange='this.form.submit()'>";

        // ==================== STATUS OPTIONS ====================
        $status_options = [
            "Order has been placed",
            "Seller is preparing to ship your parcel",
            "Parcel has been picked up by logistics partner",
            "Parcel has arrived at sorting facility",
            "Parcel has departed from sorting facility",
            "Parcel has arrived at the delivery hub",
            "Parcel is out for delivery",
            "Parcel has been delivered"
        ];
        foreach ($status_options as $opt) {
            $selected = ($row['status'] == $opt) ? "selected" : "";
            echo "<option value='$opt' $selected> $opt </option>";
        }
        echo "</select>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align:center'>No parcels found</td></tr>";
}
echo "</table>";
?>

<style>

/* ==================== GLOBAL STYLE ==================== */
* {
    font-family: "Segoe UI", sans-serif;
}

/* ==================== BODY ==================== */
body {
    background: #03220a;
    display: flex;
    align-items: center;
    flex-direction: column;
    height: 100vh;
}

/* ==================== LOGO TEXT ==================== */
#logo_name {
    position: absolute;
    left: 90px;
    top: 0px;
    color: white !important;
    font-size: 25px !important;
    letter-spacing: 0px;
    font-weight: bolder;
}

#logo_subname {
    position: absolute;
    width: 230px;
    height: 20px;
    left: 90px;
    top: 36px;
    z-index: 10;
    pointer-events: none;
    opacity: 0.9;
    color: rgb(139, 204, 131);
    font-weight: 700;
}

/* ==================== NAVIGATION ==================== */
#nav_box {
    background: #0c7e29;
    height: 50px;
    width: 53px;
    position: absolute;
    right: 30px;
    top: 20px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    z-index: 2000;
}

/* ==================== NAV BUTTON HIDDEN ==================== */
#nav_box button {
    opacity: 0;
    visibility: hidden;
    height: 0;
}

/* ==================== NAV BUTTON STYLE ==================== */
#nav_box button {
    width: 200px;
    margin: 5px 0;
    padding: 0;
    border-radius: 12px;
    border: none;
    background: #63d676;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* ==================== NAV HOVER ==================== */
#nav_box:hover {
    height: 170px;
    width: 240px;
    background: rgba(12, 107, 28, 0.9);
    backdrop-filter: blur(10px);
    padding: 20px 0;
}

#nav_box:hover button {
    opacity: 1;
    visibility: visible;
    height: 50px;
    padding: 10px;
    text-align: left;
}

#nav_box button:hover {
    background: #e0d357;
    color: #03220a;
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

#nav_box::before {
    content: '☰';
    color: white;
    font-size: 30px;
    font-weight: bolder;
    position: absolute;
    transition: 0.3s;
}

#nav_box:hover::before {
    opacity: 0;
    transform: rotate(90deg);
}

/* ==================== PAGE TITLE ==================== */
h1 {
    letter-spacing: 1px;
    margin-top: 110px;
    background: linear-gradient(135deg, #43fc4f, #b9f8ba);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    color: transparent;
    font-weight: bolder;
    font-size: 35px;
    margin-bottom: 5px;
}

/* ==================== TABLE ==================== */
table {
    display: block;
    height: 380px;
    overflow-y: auto;
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    border-collapse: collapse;

}

/* ==================== TABLE HEADER ==================== */
th {
    position: sticky;
    top: 0;
    z-index: 3;
    background: linear-gradient(126deg, #58f863, #000a01);
    letter-spacing: 2px !important;
    color: white;
    padding: 10px;
    border: 1px solid black;
    font-weight: bolder;
    font-size: 15px;
}

/* ==================== TABLE ROW ==================== */
tr {
    font-size: 13px;
}

tr:hover {
    background: #7dcc90;
}

/* ==================== TABLE DATA ==================== */
td {
    background: linear-gradient(309deg, #78ce97, #3ec760);
    font-weight: bolder !important;
    font-size: 15px;
    letter-spacing: 1px;
    border: 1px solid black;
}

/* ==================== BUTTONS ==================== */
button {
    border: none;
    margin: 1px;
}

/* ==================== LINKS ==================== */
a {
    border-radius: 5px;
    padding: 1px 4px 4px 4px;
    color: white;
    text-decoration: none;
    margin: 2px;
    text-align: center;
}

/* ==================== DROPDOWN ==================== */
select,
option {
    font-weight: bolder;
    font-size: 16px;
    letter-spacing: 1px;
}

/* ==================== SEARCH FORM ==================== */
#search-form {
    display: flex;
    align-items: left;
    justify-content: left;
    color: #ffffff;
    padding: 5px;
    margin: 3px;
    border: 2px solid rgba(225, 225, 225, 0.8);
    border-radius: 20px;
    width: 400px;
    margin-bottom: 20px;
}

/* ==================== INPUT ==================== */
input {
    background: transparent;
}

input:focus {
    outline: none;
}

/* ==================== SEARCH INPUT ==================== */
#search {
    padding: 5px 5px 5px 25px;
    width: 200px;
    border: none;
    display: flex;
    text-align: left;
    align-items: center;
    justify-content: center;
    margin: 0;
    color: white;
    margin-right: 125px;
}

/* ==================== SEARCH BUTTON ==================== */
#search_btn {
    background: transparent;
    color: white;
    margin-right: -60px;
}

/* ==================== SUBTITLE ==================== */
h4 {
    border-radius: 20px 0 0 10px;
    text-align: left;
    margin: 0;
}

/* ==================== STATUS SELECT ==================== */
#new_status {
    padding: 8px;
    border-radius: 5px;
    background: #04490b;
    color: white;
    border: 1px solid #c3f8a6;
    cursor: pointer;
}

</style>
