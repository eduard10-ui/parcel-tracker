<!DOCTYPE html>
<html lang="en">

<!-- ==================== HEAD SECTION ==================== -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Dashboard</title>
</head>

<!-- ==================== BODY SECTION ==================== -->
<body>

<!-- ==================== LOGO AND HEADER ==================== -->
<p id="logo_name">PARCEL TRACKER</p>
<p id="logo_subname">PARCEL TRACKING SYSTEM</p>

<img class="logo-style" src="../IMAGES/LOGO.PNG">
<img class="dash-style" src="../IMAGES/TRACKER.PNG">

<!-- ==================== NAVIGATION MENU ==================== -->
<div id="nav">
    <button onclick="user()">USER VIEW</button>
    <button onclick="register()">REGISTER PARCEL</button>
    <button onclick="parcel()">PARCEL DASHBOARD</button>
    <button onclick="rider()">RIDER DASHBOARD</button>
    <button onclick="account()">ACCOUNT DASHBOARD</button>
    <button onclick="logout()">LOGOUT</button>
</div>

<!-- ==================== JAVASCRIPT FILE ==================== -->
<script src="../nav-button.js"></script>

<!-- ==================== PHP SECTION ==================== -->
<?php

// ==================== DATABASE CONNECTION ====================
include '../db.php';

// ==================== SEARCH FUNCTION ====================
if (isset($_POST['search_btn'])) {

    $search = $_POST['search'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM parcel
        WHERE tracking_code LIKE '%$search%'
        OR receiver_name LIKE '%$search%'
        OR rider_name LIKE '%$search%'
        OR location LIKE '%$search%'
        OR address LIKE '%$search%'
        OR price LIKE '%$search%'"
    );

} else {

    $result = mysqli_query($conn, "SELECT * FROM parcel");

}

// ==================== PAGE HEADING ====================
echo "<h1>MAIN DASHBOARD</h1>";

// ==================== SEARCH FORM ====================
echo "<form method='POST' id='search-form'>";
echo "<input type='text' name='search' id='search' placeholder='Search any info here...'>";
echo "<button type='submit' name='search_btn' id='search_btn'>Search</button>";
echo "</form>";

// ==================== TABLE START ====================
echo "<table border=1 cellpadding=5>";

echo "<tr>";
echo "<th>CODE</th>";
echo "<th>RIDER NAME</th>";
echo "<th>RIDER CONTACT</th>";
echo "<th>RECEIVER NAME</th>";
echo "<th>RECEIVER CONTACT</th>";
echo "<th>DELIVERY ADDRESS</th>";
echo "<th>PRICE</th>";
echo "<th>WEIGHT</th>";
echo "<th>LENGTH</th>";
echo "<th>WIDTH</th>";
echo "<th>LOCATION</th>";
echo "<th>STATUS</th>";
echo "<th>ACTION</th>";
echo "</tr>";

// ==================== DISPLAY TABLE DATA ====================
while ($row = mysqli_fetch_assoc($result)) {

    echo "<tr>";

    echo "<td>" . $row['tracking_code'] . "</td>";
    echo "<td>" . $row['rider_name'] . "</td>";
    echo "<td>" . $row['rider_contact'] . "</td>";
    echo "<td>" . $row['receiver_name'] . "</td>";
    echo "<td>" . $row['receiver_contact'] . "</td>";
    echo "<td>" . $row['address'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    echo "<td>" . $row['weight'] . "</td>";
    echo "<td>" . $row['length'] . "</td>";
    echo "<td>" . $row['width'] . "</td>";
    echo "<td>" . $row['location'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";

    echo "<td>";
    echo "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Delete this parcel?\")'>DELETE</a>";
    echo "</td>";

    echo "</tr>";
}

echo "</table>";

?>

</body>

<!-- ==================== INTERNAL CSS ==================== -->
<style>

* {
    font-family: "Segoe UI", sans-serif;
}

body {
    background: #03220a;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
}

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

table {
    display: block;
    height: 380px;
    overflow-y: auto;
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    border-collapse: collapse;
}

th {
    position: sticky;
    top: 0;
    z-index: 3;
    background: linear-gradient(126deg, #58f863, #000a01);
    color: white;
    padding: 10px;
    border: 1px solid black;
    font-weight: bolder;
    font-size: 12px;
}

td {
    background: linear-gradient(309deg, #78ce97, #3ec760);
    text-align: center;
    font-weight: 700 !important;
    padding: 8px 2px;
    border: 1px solid black;
}

tr {
    font-size: 14px;
}

tr:hover {
    background: #7dcc90;
}

button {
    border: none;
    margin: 1px;
}

a {
    border-radius: 5px;
    padding: 1px 4px 4px 4px;
    color: white;
    text-decoration: none;
    margin: 2px;
    text-align: center;
}

a[href*="DELETE"] {
    background: #660a0a;
    padding: 5px;
    font-size: 12px;
}

#search-form {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    padding: 5px;
    margin: 3px;
    border: 1px solid rgba(225, 225, 225, 0.5);
    border-radius: 20px;
    width: 400px;
    margin-bottom: 20px;
}

input {
    background: transparent;
    border: none;
    color: white;
}

input:focus {
    outline: none;
}

#search {
    padding: 5px 5px 5px 0px;
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

#search_btn {
    background: transparent;
    color: white;
    margin-right: -0px;
}

h4 {
    border-radius: 20px 0 0 10px;
    text-align: left;
    margin: 0;
}

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

#nav:hover {
    height: 320px;
    width: 240px;
    background: rgba(12, 107, 28, 0.9);
    backdrop-filter: blur(10px);
    padding: 20px 0;
}

#nav:hover button {
    opacity: 1;
    visibility: visible;
    height: 50px;
    padding: 10px;
    text-align: left;
}

#nav button:hover {
    background: #e0d357;
    color: #03220a;
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

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

/* ==================== DASH IMAGE ==================== */
.dash-style {
    position: absolute;
    top: 25px;
    left: 200px;
    height: 200px;
    width: 120px;
    z-index: 1;
    width: 300px;
}

/* ==================== LOGO STYLE ==================== */
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

</style>

</html>