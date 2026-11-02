// ==================== LOCATION UPDATE FUNCTION ====================
function updateLocation(id) {

    // ==================== BUTTON REFERENCE ====================
    const btn = event.target;
    const originalText = btn.innerText;

    // ==================== LOADING STATE ====================
    btn.innerText = "Locating...";
    btn.disabled = true;

    // ==================== CHECK GEOLOCATION SUPPORT ====================
    if (!navigator.geolocation) {
        alert("Geolocation is not supported by your browser.");
        btn.innerText = originalText;
        btn.disabled = false;
        return;
    }

    // ==================== GET CURRENT GPS LOCATION ====================
    navigator.geolocation.getCurrentPosition(

        // ==================== SUCCESS FUNCTION ====================
        (pos) => {

            const lat = pos.coords.latitude;
            const lon = pos.coords.longitude;

            // ==================== OPENSTREETMAP API URL ====================
            const url =
                `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`;

            // ==================== FETCH ADDRESS ====================
            fetch(url, {
                headers: { 'Accept-Language': 'en' }
            })

            .then(res => res.json())

            .then(data => {

                // ==================== CHECK IF ADDRESS EXISTS ====================
                if (data.address) {

                    // ==================== GET STREET NAME ====================
                    const street =
                        data.address.road ||
                        data.address.pedestrian ||
                        data.address.path ||
                        "Unknown Street";

                    // ==================== SPLIT FULL ADDRESS ====================
                    let rawParts = data.display_name.split(', ');

                    // ==================== CLEAN ADDRESS PARTS ====================
                    let cleanParts = rawParts.filter(part => {

                        const p = part.toLowerCase();

                        // ==================== REMOVE REGION / COUNTRY ====================
                        const isRegionOrCountry =
                            p.includes('central luzon') ||
                            p.includes('philippines');

                        // ==================== REMOVE ZIP CODE ====================
                        const isZipCode = /\b\d{4}\b/.test(p);

                        // ==================== KEEP VALID DATA ====================
                        return !isRegionOrCountry && !isZipCode;

                    });

                    // ==================== FINAL ADDRESS ====================
                    const finalAddress = cleanParts.join(', ');

                    // ==================== SET INPUT VALUE ====================
                    document.getElementById('input_' + id).value = finalAddress;

                    // ==================== AUTO SUBMIT FORM ====================
                    document.getElementById('loc_form_' + id).submit();

                } else {

                    // ==================== ADDRESS NOT FOUND ====================
                    alert("Could not find a street at these coordinates.");
                    btn.innerText = originalText;
                    btn.disabled = false;

                }

            })

            .catch(() => {

                // ==================== API ERROR ====================
                alert("API error. Please check your connection.");
                btn.innerText = originalText;
                btn.disabled = false;

            });

        },

        // ==================== GPS ERROR FUNCTION ====================
        (err) => {

            alert(`GPS Error: ${err.message}`);
            btn.innerText = originalText;
            btn.disabled = false;

        },

        // ==================== GPS SETTINGS ====================
        {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        }

    );
}