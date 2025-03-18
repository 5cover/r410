import { parseCsv } from './util.mjs';

const country_centroids = parseCsv(await (await fetch('/data/country_centroids_all.csv')).text());

/**
 * @type {[string, number][]}
 */
export const irisa_collaborations = parseCsv(await (await fetch('/data/irisa_collaborations.csv')).text())
    .map(([country, n_publications]) => [country, parseInt(n_publications)]);

/**
 * @param {string} country_fips
 * @return {[number, number]}
 */
export function get_country_coordinates(country_fips) {
    for (const [fips10,, lat, lon] of country_centroids) {
        if (country_fips === fips10) return [parseFloat(lat), parseFloat(lon)];
    }
    throw new Error(`Country '${country_fips}' not found`);
}

/**
 * @param {string} country_code
 */
export function get_country_name(country_code) {
    for (const [fips10, name] of country_centroids) {
        if (country_code === fips10) return name;
    }
    throw new Error(`Country '${country_code}' not found`);
}
