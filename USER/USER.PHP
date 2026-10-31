<!-- ==================== PAGE TITLE ==================== -->
<title>User View</title>

<!-- ==================== EXTERNAL RESOURCES ==================== -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

<!-- ==================== VISUAL ELEMENTS ==================== -->
<img class='logo-style' src="../IMAGES/LOGO.PNG">
<img class="foreground-style" src="../IMAGES/USER.PNG">
<img class="bg-img" src="../IMAGES/BG.PNG">

<!-- ==================== HEADER ==================== -->
<h1 class='logo_name'>PARCEL TRACKER</h1>
<p id="logo_subname">PARCEL TRACKING SYSTEM</p>

<!-- ==================== FOOTER CREDITS ==================== -->
<p id='develop'>DEVELOPED BY EDUARD R. MENDOZA | BS COMPUTER ENGINEERING | APRIL 2026</p>

<?php
// ==================== DATABASE CONNECTION (RE-INIT SAFE) ====================
include '../DB.PHP';

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
    opacity: 0.8;
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
#error{
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
#history_item{
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
#develop{
    position: absolute;
    bottom: 0px;
    left: 20px;
    color: rgba(225, 225, 225, 0.5);
    font-weight: bolder;
    font-size: 13px;
}
</style>
</html>