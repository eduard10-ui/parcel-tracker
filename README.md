# Parcel-Tracker

A full-stack parcel tracking system built with PHP, MySQL, and JavaScript. This project was developed as the final requirement for **ELEC III (Technical Elective III — Software Development)**.

**Live URL:** `https://parcel-tracker.infinityfreeapp.com/ELECS/user/login.php`
**GitHub Repository:** `https://github.com/eduard10-ui/parcel-tracker`

---

## 1. Project Description

Parcel-Tracker is a simple, user-friendly web application that allows users to track a package from the moment it is shipped to the moment it arrives at the door. It provides full visibility into a package's journey. The system is designed with three distinct user roles:

*   **User (Public):** Types a tracking code to see the current status, location, and full delivery history of their parcel.
*   **Rider:** Updates the parcel's location and delivery status as it moves through the logistics network.
*   **Admin:** Registers new parcels, manages user accounts, and deletes parcels from the dashboard.

---

## 2. Features & Functionality (CRUD)

*   **Search Tracking:** Look up parcels by their unique tracking code (e.g., `FT-A1B2C3`).
*   **Real-time Updates:** View the current status and location of the package.
*   **Delivery History:** Access a complete timeline of status changes with timestamps.
*   **8-Stage Delivery Tracking:** Parcels move through 8 distinct statuses (from Order Placed to Delivered).
*   **GPS Location Update:** Riders can use their device's GPS to automatically update the parcel's current location.
*   **Interactive Map:** Users can view the delivery route on an interactive map powered by OpenStreetMap.
*   **Working CRUD Operations:** 
    *   *Create:* Admin registers new parcels.
    *   *Read:* Users and staff view parcel lists and histories.
    *   *Update:* Riders update statuses and locations; Admins toggle user account status.
    *   *Delete:* Admins delete parcels.

---

## 3. Tech Stack (Justification)

The technologies used in this project were chosen to provide a robust, lightweight, and fully functional full-stack experience:

*   **Backend:** **PHP 8** — Handles all server-side logic, session management, secure authentication, and database queries.
*   **Database:** **MySQL / MariaDB** — Stores all relational data, including user accounts, parcel records, and the delivery history logs.
*   **Frontend:** **HTML5, CSS3, Vanilla JavaScript** — Builds the responsive user interface, handles form submissions, and manages dynamic UI components (modals, navigation).
*   **Map & Geolocation:** **Leaflet.js, OpenStreetMap (Nominatim & OSRM APIs)** — Provides the interactive map display, converts addresses to coordinates, and draws the delivery routes.
*   **Hosting:** **InfinityFree** — A free PHP/MySQL hosting provider used to deploy the live application online.
*   **Local Environment:** **XAMPP** — Used for local development and testing (Apache + MySQL) before deployment.

---

## 4. Development Workflow (Git & GitHub)

This project strictly follows the professional development workflow required by the ELEC III rubric:

*   **Progressive Commits:** The project was built phase-by-phase over several weeks. Every commit represents a real, tested feature (e.g., "Add login page with role-based authentication", "Add GPS location update for riders"). The project was not uploaded all at once.
*   **Feature Branching:** A dedicated feature branch (`feature-about`) was created, developed in isolation, pushed to GitHub, and merged into the `main` branch via a GitHub Pull Request (#1) using a merge commit. This preserves the full branching history and demonstrates proper Git workflow.
*   **Remote Workflow:** Remote changes (like README updates) were synchronized using `git fetch` and `git pull`.

---

## 5. Project Structure

```text
ELECS/
├── admin/                  # Admin-only pages
│   ├── account-dashboard.php
│   ├── dashboard.php
│   ├── delete.php
│   ├── register-parcel.php
│   └── register-sql.php
├── rider/                  # Rider-only pages
│   ├── rider.js
│   ├── rider.php
│   ├── update-status.php
│   └── verify-admin.php
├── user/                   # Public user pages
│   ├── INTRO.HTML
│   ├── login.php
│   ├── logout.php
│   ├── user.js
│   ├── user.php
│   └── verify-password.php
├── images/                 # Image assets
├── .htaccess               # Apache configuration (blocks direct access to sensitive files)
├── db.php                  # Database connection
├── nav-button.js           # Shared navigation logic
└── README.md               # This file