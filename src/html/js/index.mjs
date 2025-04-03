/** @import L from 'leaflet'; */

import { get_country_coordinates, get_country_name, irisa_collaborations } from './data.mjs';
import { requireElementById } from './util.mjs';

const map = L.map('map').setView([46, 2], 4);

const span_publication_count = requireElementById('span-publication-count');

const table_collaborations = requireElementById('table-collaborations');

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


const colorPalette = [
    '#e6194B', '#3cb44b', '#ffe119', '#4363d8', '#f58231',
    '#911eb4', '#42d4f4', '#f032e6', '#bfef45', '#fabed4',
    '#469990', '#dcbeff', '#9A6324', '#fffac8', '#800000',
    '#aaffc3', '#808000', '#ffd8b1', '#000075', '#a9a9a9',
];

let i = 0;
let n_publications_total = 0;
for (const [country_code, n_publications] of irisa_collaborations) {
    n_publications_total += n_publications;
    if (country_code === 'FR') continue;
    const coords = get_country_coordinates(country_code);
    const obj = L.circle(coords, {
        radius: 20000 + 1000 * n_publications,
        color: colorPalette[i++ % colorPalette.length],

    }).addTo(map);
    const country_name = get_country_name(country_code);
    obj.bindTooltip(`${country_name} (${n_publications})`);

    const tr = table_collaborations.insertRow();
    tr.insertCell().textContent = country_name;
    tr.insertCell().textContent = n_publications;
}

span_publication_count.textContent = n_publications_total.toString();

// /**
//  * @var {Map<string, string>} people
//  */
// const people = new Map();
// people.set("Laurent d'Orazio", 'Lannion, FR');

// const fallback_coords = [48.7446, -3.4592];

// /**
//  * @var {Map<string, [number, number]>}
//  */
// const coordinates = new Map();
// //coordinates.set("Lannion, FR", [48.7446, -3.4592]);

// for (const [name, city_country] of people) {
//     let coords = coordinates.get(city_country);
//     if (!coords) {
//         coords = await get_coordinates(...city_country.split(', ', 2));
//         coordinates.set(city_country, coords);
//     }
//     // if null fetch api
//     const marker = L.marker(coords ?? fallback_coords).addTo(map);
//     marker.bindPopup(`${name}<br>${city_country}`);
// }

// /**
//  * @param {string} city
//  * @param {string} country
//  */
// async function get_coordinates(city, country) {
//     const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${city},${country}&format=json&limit=1`);
//     const data = await response.json();
//     if (data.length > 0) {
//         const location = data[0];
//         return [location.lat, location.lon];
//     } else {
//         return null;
//     }
// }
