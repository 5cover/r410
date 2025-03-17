/** @import L from 'leaflet'; */

const map = L.map('map').setView([46, 2], 4);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


/**
 * @var {Map<string, string>} people
 */
const people = new Map();
people.set("Laurent d'Orazio", 'Lannion, FR');

const fallback_coords = [48.7446, -3.4592];

/**
 * @var {Map<string, [number, number]>}
 */
const coordinates = new Map();
//coordinates.set("Lannion, FR", [48.7446, -3.4592]);

for (const [name, city_country] of people) {
    let coords = coordinates.get(city_country);
    if (!coords) {
        coords = await get_coordinates(...city_country.split(', ', 2));
        coordinates.set(city_country, coords);
    }
    // if null fetch api
    const marker = L.marker(coords ?? fallback_coords).addTo(map);
    marker.bindPopup(`${name}<br>${city_country}`);
}

/**
 * @param {string} city
 * @param {string} country
 */
async function get_coordinates(city, country) {
    const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${city},${country}&format=json&limit=1`);
    const data = await response.json();
    if (data.length > 0) {
        const location = data[0];
        return [location.lat, location.lon];
    } else {
        return null;
    }
}
