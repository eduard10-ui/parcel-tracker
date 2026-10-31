<!DOCTYPE html>
<html lang="en">

<!-- ==================== HEAD SECTION ==================== -->
<head>

    <!-- ==================== META TAGS ==================== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ==================== PAGE TITLE ==================== -->
    <title>Register Parcel</title>

</head>

<!-- ==================== BODY SECTION ==================== -->
<body>

<!-- ==================== NAVIGATION MENU ==================== -->
<div id="nav">
    <button onclick="user()">USER VIEW</button>
    <button onclick="register()">REGISTER PARCEL</button>
    <button onclick="parcel()">PARCEL DASHBOARD</button>
    <button onclick="rider()">RIDER DASHBOARD</button>
    <button onclick="account()">ACCOUNT DASHBOARD</button>
    <button onclick="logout()">LOGOUT</button>
</div>

<!-- ==================== LOGO AND HEADER ==================== -->
<h1 class="logo_name">PARCEL TRACKER</h1>
<p id="logo_subname">PARCEL TRACKING SYSTEM</p>

<!-- ==================== MAIN FORM SECTION ==================== -->
<main>

    <!-- ==================== FORM CONTAINER ==================== -->
    <div id="dash">

        <!-- ==================== REGISTRATION FORM ==================== -->
        <form action="REGISTER-SQL.PHP" method="post" id="dash_box">

            <h2>REGISTER PARCEL</h2>

            <!-- ==================== RIDER / RECEIVER INFO ==================== -->
            <section>
                <div id="rider" style="margin-bottom: 20px">

                    <div class="form-group">
                        <label>RIDER NAME</label>
                        <input type="text" name="rider_name" placeholder="Name" autocomplete="on" required>
                    </div>

                    <div class="form-group">
                        <label>RIDER CONTACT</label>
                        <input type="text" name="rider_contact" placeholder="Number" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>RECEIVER NAME</label>
                        <input type="text" name="receiver_name" placeholder="Name" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>RECEIVER CONTACT</label>
                        <input type="text" name="receiver_contact" placeholder="Number" autocomplete="off" required>
                    </div>

                </div>
            </section>

            <!-- ==================== DELIVERY DETAILS ==================== -->
            <section>

                <div class="form-grid" style="margin-bottom: 15px">

                    <div class="form-group">
                        <label>DELIVERY ADDRESS</label>
                        <input type="text" name="address" placeholder="Full destination address" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>PRICE</label>
                        <input type="text" name="price" id="price" placeholder="0.00" autocomplete="off" required>
                    </div>

                </div>

                <!-- ==================== PARCEL SIZE ==================== -->
                <div class="form-size" style="margin-bottom: 15px">

                    <div class="form-group">
                        <label>WEIGHT (kg)</label>
                        <input type="text" name="weight" id="weight" placeholder="0.00" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>LENGTH (cm)</label>
                        <input type="text" name="length" id="length" placeholder="0.00" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>WIDTH (cm)</label>
                        <input type="text" name="width" id="width" placeholder="0.00" autocomplete="off" required>
                    </div>

                </div>

                <!-- ==================== LOCATION / STATUS ==================== -->
                <div class="form-grid">

                    <div class="form-group">
                        <label>CURRENT LOCATION</label>
                        <input type="text" name="location" placeholder="Warehouse A" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label>STATUS</label>
                        <input type="text" name="status" value="Registered" readonly required>
                    </div>

                </div>

            </section>

            <!-- ==================== SUBMIT BUTTON ==================== -->
            <button type="submit" name="register_btn" id="register">
                Register Parcel
            </button>

        </form>

    </div>

</main>

<!-- ==================== JAVASCRIPT FILE ==================== -->
<script src="../NAV-BUTTON.JS"></script>

</body>

<!-- ==================== CSS SECTION ==================== -->
<style>

/* ==================== NAVIGATION MENU ==================== */
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
    content: "☰";
    color: white;
    font-size: 30px;
    position: absolute;
    transition: 0.3s;
}

#nav:hover::before {
    opacity: 0;
    transform: rotate(90deg);
}

/* ==================== GLOBAL RESET ==================== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", sans-serif;
    color: white;
    letter-spacing: 1px;
}

/* ==================== BODY ==================== */
body {
    background: #001a02;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ==================== MAIN ==================== */
main {
    background: #011f08;
    height: 100vh;
    width: 100vw;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ==================== DASH CONTAINER ==================== */
#dash {
    padding: 5px;
    width: 700px;
    overflow-y: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: -100px;
}

/* ==================== FORM BOX ==================== */
#dash_box {
    background: linear-gradient(126deg, #4fe058, #000a01);
    width: 100%;
    max-width: 1200px;
    padding: 20px 30px;
    border-radius: 30px;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

/* ==================== HEADINGS ==================== */
h2 {
    font-size: 1.9rem;
    text-shadow: 3px 3px 7px black;
    margin: 3px;
}

h4 {
    color: #aaa;
    border-bottom: 1px solid #444;
    padding-bottom: 3px;
    font-weight: 700;
}

/* ==================== GRID LAYOUT ==================== */
#rider {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-size {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

/* ==================== INPUT ==================== */
input {
    padding: 7px;
    padding-left: 20px;
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.5);
    background: rgba(225, 225, 225, 0.9);
    box-shadow: inset 3px 3px 7px rgb(31, 37, 34, 0.8);
    color: rgba(8, 70, 6, 0.8);
    font-weight: bolder;
    font-size: 15px;
    width: 100%;
}

input::placeholder {
    color: rgba(8, 70, 6, 0.5);
    font-weight: bold;
}

input:focus {
    outline: 2px solid #888;
}

/* ==================== LABEL ==================== */
label {
    font-weight: bolder;
    letter-spacing: 1px;
    text-shadow: 1px 1px 5px black;
}

/* ==================== REGISTER BUTTON ==================== */
#register {
    padding: 12px;
    border-radius: 10px;
    margin: 10px 0 10px 0;
    background: linear-gradient(270deg, #0b4622, #08941f, #15d835);
    box-shadow: 8px 8px 12px black;
    border: none;
    cursor: pointer;
    text-transform: uppercase;
    font-weight: bolder;
    font-size: 1.2rem;
    text-shadow: 2px 2px 5px black;
}

/* ==================== LOGO TEXT ==================== */
.logo_name {
    position: absolute;
    left: 90px;
    top: 25px;
    z-index: 10;
    pointer-events: none;
    opacity: 0.9;
    color: white;
    font-weight: bolder;
    background: transparent;
    font-size: 25px;
    letter-spacing: normal;
}

#logo_subname {
    position: absolute;
    width: 230px;
    height: 20px;
    left: 90px;
    top: 52px;
    z-index: 10;
    pointer-events: none;
    opacity: 0.9;
    color: rgb(139, 204, 131);
    font-weight: 700;
    letter-spacing: normal;
}

</style>

</html>

<?php

// ==================== DATABASE CONNECTION ====================
include "../DB.PHP";

// ==================== REGISTER PARCEL ====================
if (isset($_POST['register_btn'])) {

    // ==================== GENERATE TRACKING CODE ====================
    $tracking_code = "FT-" . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

    // ==================== FORM DATA ====================
    $rider_name       = $_POST['rider_name'];
    $rider_contact    = $_POST['rider_contact'];
    $receiver_name    = $_POST['receiver_name'];
    $receiver_contact = $_POST['receiver_contact'];
    $address          = $_POST['address'];

    // ==================== PRICE DATA ====================
    $original_input = $_POST['price'];
    $fixed_shipping = 20;

    // ==================== SIZE DATA ====================
    $weight = $_POST['weight'];
    $length = $_POST['length'];
    $width  = $_POST['width'];

    // ==================== PRICE COMPUTATION ====================
    $base_floor = $original_input + $fixed_shipping;
    $weight_fee = $weight * 5;
    $area_fee   = ($length * $width) / 5000;

    $calculated_total = $base_floor + $weight_fee + $area_fee;

    // ==================== FINAL PRICE ====================
    $price = max($base_floor, $calculated_total);

    // ==================== EXTRA DATA ====================
    $location = $_POST['location'];
    $status   = $_POST['status'];

    // ==================== INSERT QUERY ====================
    $sql = "INSERT INTO parcel (
                tracking_code,
                rider_name,
                rider_contact,
                receiver_name,
                receiver_contact,
                address,
                price,
                weight,
                length,
                width,
                location,
                status
            )
            VALUES (
                '$tracking_code',
                '$rider_name',
                '$rider_contact',
                '$receiver_name',
                '$receiver_contact',
                '$address',
                '$price',
                '$weight',
                '$length',
                '$width',
                '$location',
                '$status'
            )";

    // ==================== EXECUTE QUERY ====================
    mysqli_query($conn, $sql);

    // ==================== REDIRECT ====================
    header("Location: PARCEL.HTML");
}

?>