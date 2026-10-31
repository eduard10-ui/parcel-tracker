<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dashboard</title>
</head>
<body>
<!-- ==================== LOGO AND HEADER ==================== -->
<p id='logo_name'>PARCEL TRACKER</p>
<p id="logo_subname">PARCEL TRACKING SYSTEM</p>

<!-- ==================== NAVIGATION MENU ==================== -->
<div id="nav">
    <button onclick="user()">USER VIEW</button>
    <button onclick="register()">REGISTER PARCEL</button>
    <button onclick="parcel()">PARCEL DASHBOARD</button>
    <button onclick="rider()">RIDER DASHBOARD</button>
    <button onclick="account()">ACCOUNT DASHBOARD</button>
    <button onclick="logout()">LOGOUT</button>
</div>

<!-- ==================== EXTERNAL JAVASCRIPT ==================== -->
<script src='../NAV-BUTTON.JS'></script>

<!-- ========== PHP: DATABASE CONNECTION & LOGIC ============= -->
<?php
// ==================== INCLUDE DATABASE CONNECTION ====================
include '../DB.PHP';

// ==================== REGISTRATION LOGIC ====================
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status   = $_POST['status'];
    $sql = "INSERT INTO accounts (username, password, status) VALUES ('$username','$password', 'active')";
    mysqli_query($conn, $sql);
}

// ==================== FETCH ACCOUNTS LOGIC ====================
if (isset($_POST['search_btn'])) {
    $search = $_POST['search'];
    $result = mysqli_query($conn, "SELECT * FROM accounts WHERE username LIKE '%$search%' OR status LIKE '%$search%'");
} else {
    $result = mysqli_query($conn, "SELECT * FROM accounts");
}

// ==================== TOGGLE STATUS LOGIC (ACTIVE / DISABLED) ====================
if (isset($_POST['toggle_status'])) {
    $id      = $_POST['user_id'];
    $current = $_POST['current_status'];

    // Switch between active and disabled
    $new_status = ($current == 'active') ? 'disabled' : 'active';

    // Update the database
    mysqli_query($conn, "UPDATE accounts SET status = '$new_status' WHERE id = '$id'");

    // Refresh the page to show the change
    header("Location: ACCOUNT-DASHBOARD.PHP");
    exit();
}

// ==================== PAGE HEADING ====================
echo "<h1>USER ACCOUNTS</h1>";

// ==================== SEARCH FORM ====================
echo "<form method='POST' id='search-form'>";
echo "      <input type='text' name='search' id='search' placeholder='Search users...' autocomplete='off'>";
echo "      <button type='submit' name='search_btn' id='search_btn'>Search</button>";
echo "</form>";

// ==================== ACCOUNTS TABLE ====================
echo "<table cellpadding=5 border='1'>";
echo "  <tr>";
echo "      <th style='width: 15%;'>ID</th>";
echo "      <th style='width: 15%;'>USERNAME</th>";
echo "      <th>PASSWORD</th>";
echo "      <th style='width: 15%;'>STATUS</th>";
echo "  </tr>";

// ==================== LOOP THROUGH RESULTS ====================
while ($row = mysqli_fetch_assoc($result)) {
    // Set button color based on status
    $button_color = ($row['status'] == 'active') ? '#11380c' : '#8b0000';
    
    echo "<tr>";
    echo "      <td>" . $row['id'] . "</td>";
    echo "      <td>" . $row['username'] . "</td>";
    echo "      <td>" . $row['password'] . "</td>";
    echo "      <td>
                    <form method='POST' style='margin:0;'>
                        <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                        <input type='hidden' name='current_status' value='" . $row['status'] . "'>
                        <button type='submit' name='toggle_status' id='status' style='background: $button_color;'>
                        " . strtoupper($row['status']) . "
                        </button>
                    </form>
                </td>";
    echo "</tr>";
}
echo "</table>";
?>

<!-- ==================== ANIMATION ASSETS ==================== -->
<img class='dash-style' src="../IMAGES/TRACKER.PNG">
<img class='logo-style' src="../IMAGES/LOGO.PNG">

</body>

<!-- ==================== STYLES ==================== -->
<style>
/* ==================== GLOBAL RESET ==================== */
* {
    font-family: "Segoe UI", sans-serif;
}

/* ==================== BODY STYLES ==================== */
body {
    background: #03220a;
    display: flex;
    align-items: center;
    flex-direction: column;
    height: 100vh;
}

/* ==================== HEADING STYLES ==================== */
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
    margin-bottom: 20px;
}

/* ==================== TABLE STYLES ==================== */
table {
    display: block;
    max-height: 400px;
    overflow-y: auto;
    width: 75%;
    margin: 0 auto;
    z-index: 2;
    position: absolute;
    top: 37%;
    border-collapse: collapse;
    
}
/* ==================== TABLE HEADER STYLES ==================== */
th {
    position: sticky;
    top: 0;
    z-index: 3;
    background: linear-gradient(126deg, #58f863, #000a01);
    letter-spacing: 2px !important;
    color: white;
    padding: 10px;
    border: 1px solid black;
    font-weight: 900 !important;
}

/* ==================== TABLE ROW STYLES ==================== */
tr {
    font-size: 13px;
}

tr:hover {
    background: #7dcc90;
}

/* ==================== TABLE CELL STYLES ==================== */
td {
    background: linear-gradient(309deg, #78ce97, #3ec760);
    font-weight: bolder;
    letter-spacing: 1px;
    border: 1px solid black;
    text-align: center;
    font-weight: 800 !important;
}

/* ==================== BUTTON STYLES ==================== */
button {
    border: none;
    margin: 1px;
}

/* ==================== LINK STYLES ==================== */
a {
    border-radius: 5px;
    padding: 1px 4px 4px 4px;
    color: white;
    text-decoration: none;
    margin: 2px;
    text-align: center;
}

/* ==================== STATUS BUTTON STYLES ==================== */
#status {
    color: white;
    width: 80px;
    padding: 5px;
    border-radius: 10px;
    font-weight: 900 !important;
    letter-spacing: 1px;
    cursor: pointer;
}

#status:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

/* ==================== SEARCH FORM STYLES ==================== */
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
    margin-top: -10px;
}

/* ==================== INPUT STYLES ==================== */
input {
    background: transparent;
}

input:focus {
    outline: none;
}

/* ==================== SEARCH INPUT STYLES ==================== */
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
    margin-right: 115px;
}

/* ==================== SEARCH BUTTON STYLES ==================== */
#search_btn {
    background: transparent;
    color: white;
    margin-right: 20px !important;
    cursor: pointer;
}

/* ==================== ANIMATION / IMAGE STYLES ==================== */
.dash-style {
    position: absolute;
    top: 37px;
    left: 200px;
    height: 200px;
    width: 100px;
    z-index: 1;
    width: 300px;
}

.logo-style {
    position: absolute;
    width: 80px;
    height: 80px;
    left: 10px;
    top: 6px;
    z-index: 10;
    pointer-events: none;
    opacity: 0.8;
}

/* ==================== LOGO TEXT STYLES ==================== */
#logo_name {
    position: absolute;
    left: 90px;
    top: 0px;
    color: white !important;
    font-size: 25px;
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

/* ==================== NAVIGATION MENU STYLES ==================== */
#nav {
    background: #0c7e29;
    height: 55px;
    width: 55px;
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

/* ==================== BASE BUTTON STYLE ==================== */
#nav button {
    opacity: 0;
    visibility: hidden;
    height: 0;
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

/* ==================== CONTAINER EXPANSION ==================== */
#nav:hover {
    height: 320px;
    width: 240px;
    background: rgba(12, 107, 28, 0.9);
    backdrop-filter: blur(10px);
    padding: 20px 0;
}

/* ==================== BUTTON VISIBILITY ON HOVER ==================== */
#nav:hover button {
    opacity: 1;
    visibility: visible;
    height: 50px;
    padding: 10px;
    text-align: left;
}

/* ==================== INDIVIDUAL BUTTON HOVER EFFECT ==================== */
#nav button:hover {
    background: #e0d357;
    color: #03220a;
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

/* ==================== MENU ICON WHEN CLOSED ==================== */
#nav::before {
    content: '☰';
    color: white;
    font-size: 30px;
    position: absolute;
    transition: 0.3s;
}

#nav:hover::before {
    opacity: 0;
    transform: rotate(90deg);
}

</style>

</html>