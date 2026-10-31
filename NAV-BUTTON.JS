// ==================== NAVIGATION FUNCTIONS ====================

// go to user page
function user() {
    window.location.href = "../USER/user.php";
}

// go to register parcel page
function register() {
    window.location.href = "register-parcel.php";
}

// go to admin dashboard (parcel list)
function parcel() {
    window.location.href = "dashboard.php";
}

// go to rider page
function rider() {
    window.location.href = "../RIDER/rider.php";
}

// go to account dashboard
function account() {
    window.location.href = "account-dashboard.php";
}

// logout and return to login page
function logout() {
    window.location.href = "../USER/login.php";
}