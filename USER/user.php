<!-- ==================== VIEWPORT ==================== -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

<!-- ==================== PAGE TITLE ==================== -->
<title>User View</title>

<!-- ==================== EXTERNAL RESOURCES ==================== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel='stylesheet' href='.CSS'>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- ==================== VISUAL ELEMENTS ==================== -->
<img class='logo-style' src="../IMAGES/LOGO.PNG">
<img class="foreground-style" src="../IMAGES/USER.PNG">
<img class="bg-img" src="../IMAGES/BG.PNG">

<!-- ==================== HEADER ==================== -->
<h1 class='logo_name'>PARCEL TRACKER</h1>
<p id="logo_subname">PARCEL TRACKING SYSTEM</p>

<!-- ==================== ABOUT BUTTON ==================== -->
<button id='about' onclick="about()">?</button>

<!-- ==================== ABOUT MODAL ==================== -->
<div id="about_box" style="display: none ;">
    <div id="about_box_inside">
        <h2>About Parcel Tracker</h2>
        <hr>
        <p><b>Parcel Tracker</b> lets you track your package from seller to doorstep.</p>
        <p><b>Features:</b><br>• Track with unique code<br>• Real-time status updates<br>• Current location<br>• Full history</p>
        <hr>
        <p><b>Developer:</b> Eduard R Mendoza</p>
        <p><b>Course:</b> BS Computer Engineering</p>
        <p><b>Date:</b> April 2026</p>
        <hr>
        <button id="exit" onclick="exit()">exit</button>
    </div>
</div>

<!-- ==================== FOOTER CREDITS ==================== -->
<p id='develop'>DEVELOPED BY EDUARD R. MENDOZA | BS COMPUTER ENGINEERING | APRIL 2026</p>

<?php
// ==================== DATABASE CONNECTION (RE-INIT SAFE) ====================
include '../db.php';

// ==================== SEARCH LOGIC ====================
$history = [];
$error = "";
$parcel_info = null;

if (isset($_POST['track_code'])) {

    // ===== CHECK EMPTY INPUT =====
    if (empty($_POST['track_code'])) {
        $error = "ENTER A TRACKING CODE";
    } else {

        // ===== CLEAN INPUT =====
        $code = trim(mysqli_real_escape_string($conn, $_POST['track_code']));

        // ===== GET PARCEL INFO =====
        $parcel_result = mysqli_query(
            $conn,
            "SELECT price, rider_contact FROM parcel WHERE tracking_code = '$code' LIMIT 1"
        );

        if (!$parcel_result) {
            $error = "Database error occurred";
        } else {

            $parcel_info = mysqli_fetch_assoc($parcel_result);

            // ===== CHECK IF PARCEL EXISTS =====
            if (!$parcel_info) {
                $error = "TRACKING CODE NOT FOUND";
            } else {

                // ===== GET HISTORY =====
                $history_result = mysqli_query(
                    $conn,
                    "SELECT status, location,
                    DATE_FORMAT(updated_at, '%b %d, %Y - %h:%i %p') as time
                    FROM parcel_history
                    WHERE tracking_code = '$code'
                    ORDER BY updated_at DESC"
                );

                if (!$history_result) {
                    $error = "Database error occurred";
                } elseif (mysqli_num_rows($history_result) > 0) {

                    while ($row = mysqli_fetch_assoc($history_result)) {
                        $history[] = $row;
                    }

                } else {
                    $error = "NO RECORD FOUND";
                }
            }
        }
    }
}
?>

<!-- ==================== BODY ==================== -->
<body>

<!-- ==================== TITLE ==================== -->
<p id="title"></p>

<!-- ==================== SEARCH FORM ==================== -->
<form method="POST" id="form_box">
    <span id="search_icon" class="material-symbols-outlined">search</span>
    <input type="text" name="track_code" placeholder="Enter your code ..." autocomplete="off" required>
    <button id="search_btn" type="submit">Search</button>
</form>

<!-- ==================== ERROR DISPLAY ==================== -->
<?php if ($error) echo "<p >$error</p>"; ?>

<!-- ==================== HISTORY CONTAINER ==================== -->
<div id='history_box'>

<?php if ($parcel_info): ?>
    <div id='info'>
        <div id='info-inside'>
            PRICE: ₱<?php echo $parcel_info['price']; ?> |
            RIDER: <?php echo $parcel_info['rider_contact']; ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($history)): ?>
    <?php foreach ($history as $item): ?>
        <div id='history_item'>
            <p id='status'><?php echo strtoupper($item['status']); ?></p>
            <p id='location'><?php echo $item['location']; ?></p>
            <p id='time'><?php echo $item['time']; ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div id='inside'>WAITING FOR TRACKING CODE...</div>
    <div id='inside'></div>
    <div id='inside'></div>
    <div id='inside'></div>
<?php endif; ?>

</div>

<!-- ==================== ADMIN LOGIN MODAL ==================== -->
<div id="log_box" style="display: none ;">
    <form action="verify-password.php" method="POST" id='log_box_inside'>
        <p>For admin and rider only!</p>
        <input type="text" id='password' name='password' placeholder='type admin password' autocomplete='off'>
        <input id='submit_btn' type="submit" name='login'>
        <button id="cancel_btn" type="button" onclick="cancel()">cancel</button>
    </form>
</div>

<!-- ==================== ADMIN BUTTON ==================== -->
<button id='admin_btn' onclick="admin()">
    <i class="fa-solid fa-right-from-bracket"></i>
</button>

<!-- ==================== MAP ==================== -->
<div id='map_box'>
    <img id="map-style" src="../IMAGES/MAP.PNG" alt="Map preview">
    <div id='map' style='display: none'></div>
</div>

<!-- ==================== HIDE MAP BUTTON ==================== -->
<div id='hide_box'>
    <button id='hide-holder'></button>
    <button id='hide' onclick="hide_map()" style='display: none'>hide map</button>
</div>

<!-- ==================== SCRIPTS ==================== -->
<script src="user.js"></script>
<script src='../nav-button.js'></script>

<script>
// ==================== AUTO MAP LOAD ====================
<?php if (!empty($history)): ?>
document.addEventListener("DOMContentLoaded", function() {
    show_map();
});
<?php endif; ?>
</script>

</body>

<!-- ==================== FULL CSS ==================== -->
<style>
* {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #010d00;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow: hidden;
    flex-direction: column;
}

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(
        circle at 50% 50%,
        rgba(195, 248, 166, 0.25) 0%,
        rgba(7, 43, 3, 0.2) 50%,
        rgba(1, 13, 0, 1) 100%
    );
    z-index: -1;
    pointer-events: none;
}

/* ==================== ANIMATIONS ==================== */
.bg-img {
    position: absolute;
    bottom: -120px;
    left: 50%;
    width: 100vw;
    height: auto;
    transform: translate(-50%, -50%);
    z-index: -2;
    pointer-events: none;
    opacity: 0.3;
    filter: drop-shadow(0 0 20px rgba(0, 0, 0, 0.2)) contrast(1.4) saturate(1.5) brightness(1.8);
}

.foreground-style {
    position: absolute;
    width: 550px;
    height: 480px;
    left: -20px;
    top: 51%;
    transform: translateY(-50%);
    z-index: 10;
    pointer-events: none;
}

.logo-style {
    position: absolute;
    width: 100px;
    height: 100px;
    left: 20px;
    top: 10px;
    z-index: 10;
    pointer-events: none;
}

/* ===========================================================================================================
    LOGO STYLES
   =========================================================================================================== */

.logo_name {
    position: absolute;
    left: 120px;
    top: 20px;
    z-index: 10;
    pointer-events: none;
    opacity: 0.9;
    color: white;
    font-weight: bolder;
    background: transparent;
    padding: 0;
}

#logo_subname {
    position: absolute;
    width: 500px;
    height: 150px;
    left: 120px;
    top: 60px;
    z-index: 10;
    pointer-events: none;
    opacity: 0.9;
    color: rgb(139, 204, 131);
    font-weight: 900;
    letter-spacing: 2px;
}

/* ===========================================================================================================
     TITLE
   =========================================================================================================== */

#title {
    color: white;
    font-size: 20px;
    font-weight: bolder;
    margin: 5px;
    margin-top: -100px;
}

/* ===========================================================================================================
      SEARCH FORM
   =========================================================================================================== */

#form_box {
    background: rgba(71, 168, 92, 0.1);
    padding: 7px;
    border-radius: 13px;
    border: 1px solid rgb(255, 255, 255, 0.2);
    width: 500px;
    display: flex;
    box-shadow: inset -3px -3px 20px rgb(2, 29, 5);
}

#search_icon {
    margin-top: 10px;
    margin-left: 0px;
    color: rgba(225,225,225, 0.7);
    font-size: 25px;
}

#form_box input {
    border: none;
    background: transparent;
    margin-left: 110px;
    color: white;
    font-weight: bold;
    text-align: center;
    font-size: 15px;
    letter-spacing: 2px;
}

#form_box input:focus {
    outline: 2px transparent;
}

#search_btn {
    border: none;
    background: linear-gradient(126deg, #34e03f, #000a01);
    padding: 10px 15px;
    border-radius: 10px;
    font-weight: bolder;
    color: rgb(255, 255, 255);
    margin-left: 66px;
    width: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
}

#error {
    color: red;
    font-weight: bold;
}

/* ===========================================================================================================
   HISTORY BOX
   =========================================================================================================== */

#history_box {
    background: rgba(1, 13, 0, 0.3);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    padding: 10px 30px 45px 30px;
    overflow: auto;
    border: 1px solid rgba(195, 248, 166, 0.2);
    border-radius: 20px;
    box-shadow: 0 8px 32px 0 rgba(0, 15, 5, 0.8),
                inset -10px -10px 30px rgba(0, 15, 5, 0.8);
    height: 300px;
    width: 450px;
}

#history_box::-webkit-scrollbar {
    width: 5px;
}

#history_box::-webkit-scrollbar-thumb {
    background: #fafffb5d;
    border-radius: 10px;
    margin: 0;
}

/* ===========================================================================================================
        INFO BOX
   =========================================================================================================== */

#info {
    text-align: center;
    background: linear-gradient(126deg, #53b853, #000a01);
    backdrop-filter: blur(15px);
    border-radius: 255px;
    margin-bottom: 12px;
    color: #e0ec6f;
    padding: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bolder;
    border: 1px solid rgba(195, 248, 166, 0.3);
    text-shadow: 1px 1px 3px black;
}

#info-inside {
    background: #000;
    width: 450px;
    padding: 8px;
    background: rgba(225, 225, 225, 0.05);
    border-radius: 210px;
    border: 1px solid rgba(195, 248, 166, 0.2);
}

/* ===========================================================================================================
        HISTORY ITEM
   =========================================================================================================== */

#history_item {
    text-align: center;
    background: linear-gradient(126deg, #58f863, #000a01);
    backdrop-filter: blur(15px);
    padding: 1px 10px 1px 10px;
    border-radius: 20px;
    margin-bottom: 12px;
    color: #012901;
    border: 1px solid rgba(195, 248, 166, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

#history p {
    border-radius: 10px;
}

#status {
    font-size: 15px;
    font-weight: bolder;
    background: rgba(2, 82, 26, 0.2);
    border-radius: 15px;
    padding: 7px;
    color: #e0ec6f;
    font-style: italic;
    box-shadow: -2px -2px 10px rgba(0, 0, 0, 0.5);
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 410px;
}

#status_icon {
    margin-right: 7px;
    color: #d0e03c;
    text-shadow: 2px 2px 5px rgb(164, 190, 166);
}

#location {
    margin: -15px;
    font-size: 12px;
    font-weight: bolder;
    color: #90f390;
    font-size: 14;
    font-style: italic;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 1);
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 400px;
}

#time {
    margin-top: 16px;
    font-size: 12px;
    font-weight: bolder;
    color: #bde0ad;
    font-style: italic;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 1);
}

/* ===========================================================================================================
    LOADING PLACEHOLDER ANIMATION (#inside, keyframes waveFade)
   =========================================================================================================== */

#inside {
    background: rgba(225, 225, 225, 0.1);
    border-radius: 10px;
    animation: waveFade 3s ease-in-out infinite;
    height: 32px;
    z-index: 200;
    margin-bottom: 10px;
    font-weight: bolder;
    color: rgba(0, 0, 0, 0.5);
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 75px;
}

#inside:nth-child(1) { animation-delay: 0s; }
#inside:nth-child(2) { animation-delay: 0.4s; }
#inside:nth-child(3) { animation-delay: 0.8s; }
#inside:nth-child(4) { animation-delay: 1s; }
#inside:nth-child(5) { animation-delay: 1.4s; }
#inside:nth-child(6) { animation-delay: 1.8s; }

@keyframes waveFade {
    0%, 100% {
        opacity: 0.5;
        transform: translateY(0) scale(0.98);
    }

    50% {
        opacity: 0.7;
        transform: translateY(-3px) scale(1);
        background: rgba(255, 255, 255, 0.6);
    }
}

/* ===========================================================================================================
    FOOTER
   =========================================================================================================== */

#develop {
    position: absolute;
    bottom: 0px;
    left: 20px;
    color: rgba(225, 225, 225, 0.5);
    font-weight: bolder;
    font-size: 13px;
}

/* ==================== ABOUT MODAL ==================== */

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
    border: 1px solid rgba(253, 253, 253, 0.5);
    color: white;
}

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
    box-shadow: inset -4px -4px 3px rgba(0, 0, 0, 0.5) !important;
    justify-content: center;
    color: white;
    left: 10px;
    top: 10px;
}

#about_box_inside {
    background: #00220f;
    box-shadow: inset -4px -4px 3px rgba(0, 0, 0, 0.5) !important;
    border-radius: 20px;
    height: 440px;
    width: 650px;
    position: absolute;
    z-index: 300;
    padding: 30px;
}

h2 {
    margin-top: -5px;
    font-size: 20px;
}

#exit {
    padding: 5px;
    width: 80px;
    border-radius: 15px;
    font-weight: bold;
    border: none;
    margin-top: 5px;
    background: transparent;
    box-shadow: 2px 2px 3px white, inset 2px 2px 3px white;
    color: white;
    font-size: 20px !important;
}

/* ==================== ADMIN BUTTON ==================== */

#admin_btn {
    position: absolute;
    right: 10px;
    bottom: 10px;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    letter-spacing: 1px;
    background: rgba(225, 225, 225, 0.2);
    color: rgba(225, 225, 225, 0.7);
}

#log_box {
    backdrop-filter: blur(5px);
    z-index: 300;
    height: 100vh;
    width: 100vw;
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bolder;
}

#log_box_inside {
    background: rgba(3, 37, 9, 0.8);
    height: 250px;
    width: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    border-radius: 20px;
}

#password {
    padding: 10px;
    border-radius: 20px;
    margin: 5px;
    width: 230px;
    text-align: center;
}

#submit_btn, #cancel_btn {
    padding: 7px;
    border-radius: 20px;
    font-weight: bold;
    width: 230px;
    margin: 5px;
    font-weight: bolder;
    font-size: 17px;
}

/* ==================== MAP PLACEHOLDER ==================== */

#map-style {
    position: absolute;
    inset: 10px;
    width: calc(100% - 20px);
    height: calc(100% - 20px);
    border-radius: 18px;
    object-fit: cover;
    object-position: center;
    z-index: 1;
    opacity: 0.7;
    pointer-events: none;
}

/* ==================== ACTUAL MAP ==================== */

#map {
    position: absolute;
    inset: 10px;
    width: calc(100% - 20px);
    height: calc(100% - 20px);
    background: white;
    border-radius: 18px;
    z-index: 2;
}

/* ==================== MAP CONTAINER ==================== */

#map_box {
    height: 350px;
    width: 350px;
    position: absolute;
    right: 50px;
    top: 25%;
    border-radius: 20px;
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(1, 13, 0, 0.3);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid rgba(195, 248, 166, 0.2);
    box-shadow: 0 8px 32px 0 rgba(0, 15, 5, 0.8),
                inset -10px -10px 30px rgba(0, 15, 5, 0.8);
}



@keyframes fade {
    0%, 100% {
        opacity: 0.1;
        background: rgba(225,225,225, 0.1);
        transform: translateY(0) scale(0.98);
    }

    50% {
        opacity: 0.6;
        background: rgba(225,225,225, 0.3);
        transform: scale(0.96);
    }
}

/* ==================== HIDE MAP BUTTONS ==================== */

#hide_box {
    position: absolute;
    right: 50px;
    top: 85px;
    border-radius: 20px;
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 60px;
    width: 350px;
    background: rgba(1, 13, 0, 0.3);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid rgba(195, 248, 166, 0.2);
    border-radius: 15px;
}

#hide-holder {
    background: linear-gradient(156deg, #c7c7c7, #585554);
    opacity: 0.7;
    position: absolute;
    border-radius: 15px;
    width: 325px;
    padding: 10px;
    z-index: 103;
    font-weight: bold;
    font-size: 20px;
    border: none;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 45px;
    animation: 3s fade ease-in-out infinite;
}

#hide {
    background: linear-gradient(156deg, #ffbb29, #d11f00);
    position: absolute;
    border-radius: 15px;
    width: 325px;
    padding: 10px;
    z-index: 103;
    display: none;
    font-weight: bold;
    font-size: 20px;
    border: none;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ===========================================================================================================
    MOBILE RESPONSIVE LAYOUT
    Optimized for iPhone 12 (390px × 844px CSS viewport)
   =========================================================================================================== */

@media screen and (max-width: 600px) {

    /* ===== GENERAL MOBILE SETTINGS ===== */

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    html {
        width: 100%;
        min-height: 100%;
        overflow-x: hidden;
    }

    body {
        position: relative;
        width: 100%;
        min-height: 100vh;
        min-height: 100svh;
        margin: 0;
        padding: 112px 16px 90px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        gap: 13px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    /* ===== HEADER AND LOGO ===== */

    .logo-style {
        position: absolute;
        width: 55px;
        height: 55px;
        left: 13px;
        top: 13px;
        object-fit: contain;
    }

    .logo_name {
        position: absolute;
        left: 76px;
        top: 20px;
        right: 65px;
        width: auto;
        font-size: 18px;
        line-height: 1.2;
        margin: 0;
    }

    #logo_subname {
        position: absolute;
        left: 77px;
        top: 45px;
        right: 65px;
        width: auto;
        height: auto;
        font-size: 9px;
        line-height: 1.4;
        letter-spacing: 1px;
    }

    /* ===== ABOUT BUTTON ===== */

    #about {
        position: absolute;
        top: 17px;
        right: 14px;
        width: 38px;
        height: 38px;
        padding: 0;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ===== DECORATIVE IMAGES ===== */

    .bg-img {
        position: absolute;
        width: 150vw;
        max-width: none;
        height: auto;
        left: 50%;
        bottom: -40px;
        transform: translateX(-50%);
    }

    .foreground-style {
        position: absolute;
        width: min(60vw, 230px);
        max-width: 230px;
        height: auto;
        left: -45px;
        top: auto;
        bottom: 95px;
        transform: none;
        z-index: 0;
    }

    /* ===== MAIN TITLE ===== */

    #title {
        position: relative;
        z-index: 5;
        width: 100%;
        margin: 0;
        padding: 0;
        font-size: 18px;
        line-height: 1.3;
        text-align: center;
    }

    /* ===== SEARCH FORM ===== */

    #form_box {
        position: relative;
        z-index: 5;
        width: 100%;
        max-width: 520px;
        min-height: 52px;
        margin: 0;
        padding: 6px 7px;
        display: flex;
        align-items: center;
        gap: 7px;
        border-radius: 13px;
    }

    #search_icon {
        flex: 0 0 27px;
        width: 27px;
        margin: 0;
        padding: 0;
        font-size: 23px;
        text-align: center;
    }

    #form_box input {
        flex: 1 1 auto;
        width: 0;
        min-width: 0;
        height: 40px;
        margin: 0;
        padding: 0 5px;
        font-size: 14px;
        letter-spacing: 0.7px;
        text-align: left;
    }

    #form_box input::placeholder {
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    #search_btn {
        flex: 0 0 auto;
        width: auto;
        min-width: 82px;
        height: 40px;
        margin: 0;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 14px;
        white-space: nowrap;
    }

    /* ===== ERROR MESSAGE ===== */

    #error {
        width: 100%;
        max-width: 520px;
        margin: 0;
        padding: 5px;
        font-size: 12px;
        text-align: center;
        overflow-wrap: anywhere;
    }

    /* ===== HISTORY CONTAINER ===== */

    #history_box {
        position: relative;
        z-index: 5;
        width: 100%;
        max-width: 520px;
        height: 290px;
        min-height: 220px;
        margin: 0;
        padding: 12px 13px 18px;
        overflow-x: hidden;
        overflow-y: auto;
        border-radius: 17px;
    }

    #history_box::-webkit-scrollbar {
        width: 4px;
    }

    /* ===== PARCEL INFORMATION ===== */

    #info {
        width: 100%;
        margin-bottom: 10px;
        padding: 7px;
        border-radius: 15px;
        font-size: 13px;
        line-height: 1.4;
    }

    #info-inside {
        width: 100%;
        min-width: 0;
        padding: 8px;
        border-radius: 12px;
        font-size: 12px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    /* ===== INDIVIDUAL HISTORY CARDS ===== */

    #history_item {
        width: 100%;
        min-width: 0;
        margin-bottom: 10px;
        padding: 10px 9px;
        border-radius: 14px;
    }

    #status {
        width: 100%;
        max-width: 100%;
        margin: 0 0 7px;
        padding: 7px 5px;
        font-size: 12px;
        line-height: 1.4;
        border-radius: 10px;
        overflow-wrap: anywhere;
        text-align: center;
    }

    #location {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0 3px;
        font-size: 12px;
        line-height: 1.5;
        letter-spacing: 0.3px;
        overflow-wrap: anywhere;
        text-align: center;
    }

    #time {
        width: 100%;
        margin: 8px 0 0;
        font-size: 10px;
        line-height: 1.4;
        text-align: center;
    }

    /* ===== WAITING PLACEHOLDERS ===== */

    #inside {
        width: 100%;
        min-height: 55px;
        height: auto;
        margin-bottom: 8px;
        padding: 10px;
        border-radius: 10px;
        font-size: 11px;
        line-height: 1.4;
        text-align: center;
    }

    /* ===== MAP CONTAINER ===== */

    #map_box {
        position: relative;
        z-index: 5;
        top: auto;
        right: auto;
        width: 100%;
        max-width: 520px;
        height: 280px;
        min-height: 240px;
        margin: 0;
        padding: 8px;
        border-radius: 17px;
    }

    #map {
        position: absolute;
        top: 8px;
        left: 8px;
        width: calc(100% - 16px);
        height: calc(100% - 16px);
        border-radius: 13px;
    }

    #map-style {
        width: min(65vw, 240px);
        height: auto;
        max-height: 240px;
        top: auto;
        right: 50%;
        bottom: 330px;
        transform: translateX(50%);
        object-fit: contain;
        z-index: 1;
    }

    /* ===== HIDE MAP CONTROLS ===== */

    #hide_box {
        position: relative;
        z-index: 5;
        top: auto;
        right: auto;
        width: 100%;
        max-width: 520px;
        height: 48px;
        min-height: 48px;
        margin: 0 0 5px;
        border-radius: 13px;
    }

    #hide-holder,
    #hide {
        width: calc(100% - 20px);
        max-width: none;
        height: 36px;
        padding: 7px 12px;
        border-radius: 10px;
        font-size: 14px;
    }

    /* ===== ADMIN BUTTON ===== */

    #admin_btn {
        position: fixed;
        z-index: 250;
        right: 13px;
        bottom: 13px;
        width: 43px;
        height: 43px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 16px;
    }

    /* ===== FOOTER ===== */

    #develop {
        position: fixed;
        z-index: 200;
        left: 12px;
        right: 68px;
        bottom: 17px;
        width: auto;
        margin: 0;
        font-size: 8px;
        line-height: 1.4;
        letter-spacing: 0.1px;
    }

    /* ===== ABOUT MODAL ===== */

    #about_box {
        position: fixed;
        z-index: 300;
        inset: 0;
        width: 100%;
        height: 100%;
        min-height: 100svh;
        margin: 0;
        padding: 16px;
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #about_box_inside {
        position: relative;
        width: 100%;
        max-width: 450px;
        height: auto;
        max-height: calc(100svh - 32px);
        padding: 22px 19px;
        overflow-x: hidden;
        overflow-y: auto;
        border-radius: 17px;
    }

    #about_box_inside h2 {
        margin: 0 0 12px;
        font-size: 19px;
        line-height: 1.3;
    }

    #about_box_inside p {
        margin: 12px 0;
        font-size: 13px;
        line-height: 1.6;
    }

    #about_box_inside hr {
        margin: 12px 0;
    }

    #exit {
        width: 80px;
        min-height: 40px;
        margin-top: 8px;
        padding: 7px;
        font-size: 16px !important;
    }

    /* ===== ADMIN / RIDER LOGIN MODAL ===== */

    #log_box {
        position: fixed;
        z-index: 300;
        inset: 0;
        width: 100%;
        height: 100%;
        min-height: 100svh;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    #log_box_inside {
        width: 100%;
        max-width: 330px;
        height: auto;
        min-height: 230px;
        padding: 22px 18px;
        border-radius: 17px;
        box-sizing: border-box;
    }

    #log_box_inside p {
        width: 100%;
        margin: 0 0 15px;
        font-size: 14px;
        text-align: center;
    }

    #password {
        width: 100%;
        max-width: 260px;
        min-height: 42px;
        margin: 5px 0 10px;
        padding: 10px;
        font-size: 14px;
        box-sizing: border-box;
    }

    #submit_btn,
    #cancel_btn {
        width: 100%;
        max-width: 260px;
        min-height: 42px;
        margin: 5px 0;
        padding: 9px;
        font-size: 14px;
        box-sizing: border-box;
    }
}

/* ===========================================================================================================
    SMALLER MOBILE SCREENS
   =========================================================================================================== */

@media screen and (max-width: 380px) {

    body {
        padding-left: 12px;
        padding-right: 12px;
    }

    .logo-style {
        width: 49px;
        height: 49px;
    }

    .logo_name {
        left: 68px;
        top: 18px;
        font-size: 16px;
    }

    #logo_subname {
        left: 69px;
        top: 41px;
        font-size: 8px;
    }

    #about {
        right: 12px;
        width: 35px;
        height: 35px;
    }

    #form_box {
        gap: 5px;
        padding: 5px;
    }

    #search_icon {
        flex-basis: 24px;
        width: 24px;
        font-size: 21px;
    }

    #form_box input {
        font-size: 12px;
        letter-spacing: 0;
    }

    #form_box input::placeholder {
        font-size: 11px;
    }

    #search_btn {
        min-width: 72px;
        padding: 8px;
        font-size: 13px;
    }

    #history_box {
        padding-left: 10px;
        padding-right: 10px;
    }

    #map_box {
        height: 250px;
    }

    #develop {
        font-size: 7px;
    }
}

/* ===========================================================================================================
    MOBILE LANDSCAPE / SHORT SCREEN ADJUSTMENTS
   =========================================================================================================== */

@media screen and (max-width: 600px) and (max-height: 700px) {

    body {
        padding-top: 100px;
        padding-bottom: 85px;
        gap: 10px;
    }

    #history_box {
        height: 230px;
        min-height: 200px;
    }

    #map_box {
        height: 230px;
        min-height: 210px;
    }

    #about_box_inside {
        max-height: calc(100svh - 24px);
        padding: 15px;
    }

    #about_box_inside p {
        margin: 8px 0;
        line-height: 1.4;
    }
}
</style>
</html>