// ==================== FILE: USER.JS ====================
// PURPOSE: UI helper functions for user-facing pages

// ==================== UI CONTROLS ====================

function about() {
    document.getElementById('about_box').style.display = 'flex';
}

function exit() {
    document.getElementById('about_box').style.display = 'none';
}

function admin() {
    document.getElementById('log_box').style.display = 'flex';
}

function cancel() {
    document.getElementById('log_box').style.display = 'none';
}