<?php
// ==================== FILE: REGISTER.PHP ====================
// PURPOSE: Handles user registration and account creation

include "../DB.PHP";

// ==================== REGISTER REQUEST HANDLER ====================
if(isset($_POST['register'])){

    // ==================== INPUT VALIDATION ====================

    if(empty($_POST['username'])) {
        echo "<script>alert('Username is required!'); window.location.href='REGISTER.PHP';</script>";
        exit();
    }
    
    if(empty($_POST['password'])) {
        echo "<script>alert('Password is required!'); window.location.href='REGISTER.PHP';</script>";
        exit();
    }
    
    // ==================== INPUT SANITIZATION ====================
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ==================== CHECK EXISTING USER ====================
    $check = mysqli_query($conn, "SELECT * FROM accounts WHERE username = '$username'");
    
    if(!$check) {
        echo "<script>alert('Database error! Please try again.'); window.location.href='REGISTER.PHP';</script>";
        exit();
    }
    
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Username already exists!'); window.location.href='REGISTER.PHP';</script>";
    } else {

        $sql = "INSERT INTO accounts (username, password, status, failed_attempts) 
                VALUES ('$username', '$hashed_password', 'active', 0)";
        
        if(mysqli_query($conn, $sql)){
            echo "<script>alert('Registration Successful!'); window.location.href='LOGIN.PHP';</script>";
        } else {
            echo "<script>alert('Registration failed! Please try again.'); window.location.href='REGISTER.PHP';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
</head>

<img class='logo-style' src="../IMAGES/LOGO.PNG">

<body>

    <!-- ==================== HEADER SECTION ==================== -->
    <p id='logo_name'>PARCEL TRACKER</p>
    <p id="logo_subname">PARCEL TRACKING SYSTEM</p>

    <!-- ==================== DECORATIVE IMAGE ==================== -->
    <img class='registry-style' src="../IMAGES/REGISTRY.PNG">
    
    <p id='developer'>DEVELOPED BY EDUARD R. MENDOZA</p>

    <div id="title">
        <p id="reg">REGISTER HERE!</p>
    </div>
    
    <div id="main">
        <form method="POST" id="form" action="REGISTER.PHP">
            <fieldset>
                <legend>USERNAME</legend>
                <input type="text" name="username" placeholder="Enter your username here.." autocomplete="off" required>
            </fieldset>
            
            <fieldset>
                <legend>PASSWORD</legend>
                <input type="text" name="password" placeholder="Enter your password here.." autocomplete="off" required>
            </fieldset>
            
            <input type="hidden" name="status">
            <button name="register">REGISTER</button>
        </form>
        
        <div id="login">
            <p>Have an account already?</p>
            <a href="LOGIN.PHP">Login here...</a> 
        </div>

    </div>

    <!-- ==================== ABOUT BUTTON ==================== -->
    <button id='about' onclick="about()">?</button>
    
    <!-- ==================== ABOUT MODAL ==================== -->
    <div id="about_box" style="display: none;">

        <div id="about_box1">

            <h2>About Parcel Tracker</h2>
            <hr>

            <p>
                <b>Parcel Tracker</b> is a user-friendly parcel tracking system that gives you 
                full visibility of your package's journey from the seller to your doorstep.
            </p>

            <p>
                <b>What you can do:</b><br>
                • Track your parcel using a unique tracking code<br>
                • View real-time status updates (8 delivery stages)<br>
                • See the current location of your package<br>
                • Access complete delivery history with timestamps<br>
            </p>

            <hr>

            <p><b>Developer:</b> Eduard R Mendoza</p>
            <p><b>Course:</b> BS Computer Engineering</p>
            <p><b>Date:</b> April 2026</p>

            <hr>

            <button id="exit" onclick="exit()">exit</button>

        </div>

    </div>

</body>
<!-- ==================== JAVASCRIPT SECTION ==================== -->
<script src="USER.JS"></script>

<style>

/* ==================== GLOBAL RESET ==================== */
* {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ==================== BODY ==================== */
body {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    height: 100vh;
    background: #03220a;
    overflow: hidden;
}

/* ==================== LOGO ==================== */
.logo-style {
    position: absolute;
    width: 90px;
    height: 90px;
    left: 445px;
    top: 36px;
    z-index: 10;
    pointer-events: none;
}

/* ==================== TITLE TEXT ==================== */
#logo_name {
    position: absolute;
    left: 535px;
    top: 16px;
    color: white !important;
    font-size: 35px;
    letter-spacing: 0px;
    font-weight: bolder;
}

#logo_subname {
    position: absolute;
    width: 400px;
    height: 20px;
    left: 535px;
    top: 76px;
    z-index: 10;
    pointer-events: none;
    opacity: 0.9;
    color: rgb(139, 204, 131);
    font-weight: 700;
    letter-spacing: 2px;
    font-size: 19px;
}

/* ==================== MAIN BOX ==================== */
#main {
    background: linear-gradient(126deg, #4fe058, #000a01);
    width: 600px;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    border-radius: 30px;
}

/* ==================== TITLE ==================== */
#title {
    width: 700px;
    height: 80px;
    margin: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

#reg {
    font-size: 2.2rem;
    font-weight: bolder;
    letter-spacing: 3px;
    margin: 0;
    text-shadow: 2px 2px 10px rgb(37, 34, 2);
    margin-bottom: -25px;
    color: #e0d357;
}

/* ==================== FORM ==================== */
form {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 15px;
    margin-top: 20px;
}

fieldset {
    border-radius: 20px;
    border: 3px solid rgba(160, 233, 160, 0.6);
}

legend {
    font-weight: bold;
    color: rgb(254, 255, 254);
    letter-spacing: 2px;
    margin-left: 15px;
}

input {
    width: 400px;
    padding: 13px;
    border: none;
    border-radius: 20px;
    background: transparent;
    margin: -10px;
    color: white;
    font-weight: bold;
    font-size: 17px;
    margin-left: 8px;
}

input::placeholder {
    font-weight: bold;
    font-size: 17px;
    color: rgb(169, 233, 206, 0.5);
}

input:focus {
    outline: none;
}

/* ==================== BUTTON ==================== */
button {
    padding: 13px;
    width: 430px;
    font-weight: bolder;
    font-size: 27px;
    border-radius: 15px;
    border: none;
    color: white;
    margin-top: 10px;
    background: rgb(8, 172, 63);
    box-shadow: inset 2px 2px 10px rgba(0, 2, 0, 0.423),
                5px 5px 10px rgba(0, 2, 0, 0.423);
}

/* ==================== TEXT ==================== */
p {
    color: white;
}

a {
    color: yellow;
}

/* ==================== LOGIN LINK ==================== */
#login {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

/* ==================== EXTRA IMAGES ==================== */
.registry-style {
    position: absolute;
    height: 500px;
    left: -20px;
    bottom: 0px;
}

/* ==================== FOOTER TEXT ==================== */
#developer {
    position: absolute;
    bottom: 0px;
    right: 20px;
    color: rgba(225, 225, 225, 0.5);
    font-weight: bolder;
    font-size: 13px;
}

/* ==================== ABOUT BUTTON ==================== */
#about {
    position: absolute;
    top: 30px;
    right: 50px;
    height: 35px;
    width: 35px;
    border-radius: 50%;
    font-weight: bolder;
    background: rgb(8, 75, 34);
    font-size: 20px;
    border: 1px solid rgba(253, 253, 253, 0.3);
    color: white;
    box-shadow: inset -4px -4px 3px rgba(0, 0, 0, 0.5) !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ==================== ABOUT MODAL ==================== */
#about_box {
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    position: absolute;
    z-index: 300;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

#about_box1 {
    background: #00220f;
    border-radius: 20px;
    height: 440px;
    width: 650px;
    position: absolute;
    z-index: 300;
    padding: 30px;
}

h2 {
    font-size: 40px;
    margin: 0;
}

#exit {
    width: 80px;
    border-radius: 15px;
    font-weight: bold;
    border: none;
    margin-top: 5px;
    font-size: 20px;
    background: transparent;
    box-shadow: 2px 2px 3px white, inset 2px 2px 3px white;
    color: white;
    padding: 0;
}
</style>
</style>

</html>