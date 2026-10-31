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
    document.getElementById('password').value = '';
    document.getElementById('log_box').style.display = 'flex';
}

function cancel() {
    document.getElementById('log_box').style.display = 'none';
}


// ==================== MAP INITIALIZATION ====================
var map = L.map('map').setView([15.33, 119.97], 9); 

var pathCoordinates = []; 
var roadLayer = L.layerGroup().addTo(map);

// ==================== TILE LAYER (OPENSTREETMAP) ====================
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// ==================== TRACE PARCEL HISTORY ====================
async function traceParcelHistory() {

    // Get all location elements from history UI
    const locationElements = document.querySelectorAll('#history_box #location, .inside .location-text');

    const locations = Array.from(locationElements)
        .map(el => el.innerText.trim())
        .reverse();

    // If no locations found, stop
    if (locations.length === 0) return;

    roadLayer.clearLayers();
    pathCoordinates = [];

    // ==================== LOOP THROUGH LOCATIONS ====================
    for (let i = 0; i < locations.length; i++) {

        const loc = locations[i];

        try {

            // Delay to avoid API overload (rate limiting safety)
            await new Promise(resolve => setTimeout(resolve, 1200));

            // ==================== GEOCODING (NOMINATIM) ====================
            const response = await fetch(
                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(loc)}`
            );

            const data = await response.json();

            if (data && data[0]) {

                const currentPoint = [
                    parseFloat(data[0].lat),
                    parseFloat(data[0].lon)
                ];

                // ==================== MARKER STYLE ====================
                let color = (i === 0) 
                    ? "green" 
                    : (i === locations.length - 1 ? "#00812b" : "blue");

                let radius = (i === locations.length - 1) ? 10 : 7;

                L.circleMarker(currentPoint, {
                    radius: radius,
                    color: "white",
                    weight: 2,
                    fillColor: color,
                    fillOpacity: 1
                }).addTo(roadLayer)
                  .bindPopup(`<b>${loc}</b>`);

                // ==================== ROUTE DRAWING (OSRM) ====================
                if (pathCoordinates.length > 0) {

                    const prev = pathCoordinates[pathCoordinates.length - 1];

                    const osrmUrl =
                        `https://router.project-osrm.org/route/v1/driving/` +
                        `${prev[1]},${prev[0]};${currentPoint[1]},${currentPoint[0]}` +
                        `?overview=full&geometries=geojson`;

                    const routeRes = await fetch(osrmUrl);
                    const routeData = await routeRes.json();

                    if (routeData.routes && routeData.routes[0]) {

                        const coords = routeData.routes[0].geometry.coordinates
                            .map(c => [c[1], c[0]]);

                        // ==================== ROUTE LINE STYLE ====================
                        L.polyline(coords, {
                            color: 'red',
                            weight: 8,
                            opacity: 0.8,
                            lineJoin: 'round'
                        }).addTo(roadLayer);
                    }
                }

                pathCoordinates.push(currentPoint);
            }

        } catch (error) {
            console.error("Geocoding failed for: " + loc);
        }
    }

    // ==================== AUTO FIT MAP ====================
    if (pathCoordinates.length > 0) {
        map.fitBounds(L.latLngBounds(pathCoordinates).pad(0.2));
    }
}

// ==================== MAP UTILITIES ====================

// Re-center route
function locateRoute() { 
    if (pathCoordinates.length > 0) {
        map.fitBounds(L.latLngBounds(pathCoordinates).pad(0.2));
    }
}

// ==================== MAP VISIBILITY CONTROL ====================

function hide_map() {

    const mapContainer = document.getElementById('map');

    mapContainer.style.opacity = '0';
    mapContainer.style.transform = 'translateY(20px)';

    setTimeout(() => {
        mapContainer.style.display = 'none';
        document.getElementById('map-style').style.display = 'flex';
        document.getElementById('hide-holder').style.display = 'flex';
    }, 400);

    document.getElementById('hide').style.display = 'none';
}

function show_map() {

    const mapSync = document.getElementById('map');
    mapSync.style.display = 'flex';

    document.querySelectorAll('#inside').forEach(el => {
        el.style.display = 'none';
    });

    document.getElementById('map-style').style.display = 'none';
    document.getElementById('hide-holder').style.display = 'none';

    setTimeout(() => {
        if (typeof map !== 'undefined') {
            map.invalidateSize();
        }
    }, 200);

    document.getElementById('hide').style.display = 'flex';
}

// ==================== AUTO RUN ====================
window.onload = () => setTimeout(traceParcelHistory, 500);