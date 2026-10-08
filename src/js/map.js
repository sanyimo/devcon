if (document.querySelector('#map')) { 
    const lat = 39.456446 
    const lng = -0.355252
    const zoom = 16;

    const map = L.map('map').setView([lat, lng], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup(`<h2 class="map__heading">DevCon</h2>
        <p class="map__text">Centro de convenciones, Valencia</p>`)
        .openPopup();
}