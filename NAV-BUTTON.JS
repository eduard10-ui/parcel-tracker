// ==================== NAVIGATION FUNCTIONS ====================

// go to user page
function user() {
    window.location.href = "../USER/USER.PHP";
}

// go to register parcel page
function register() {
    window.location.href = "REGISTER-PARCEL.PHP";
}

// go to admin dashboard (parcel list)
function parcel() {
    window.location.href = "DASHBOARD.PHP";
}

// go to rider page
function rider() {
    window.location.href = "../RIDER/RIDER.PHP";
}

// go to account dashboard
function account() {
    window.location.href = "ACCOUNT-DASHBOARD.PHP";
}

// logout and return to login page
function logout() {
    window.location.href = "../USER/LOGIN.PHP";
}