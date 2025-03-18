
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc(PROG) ?></title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">

    <!-- STYLES -->
    <link rel="stylesheet" href="/style/index.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script type="module" src="/js/index.mjs"></script>
</head>
<body>

<!-- HEADER: MENU + HEROE SECTION -->
<header>

    <div class="menu">
        <ul>
            <li class="menu-toggle"><button id="menuToggle">&#9776;</button></li>
            <li class="menu-item hidden"><a href="#">Accueil</a></li>
            <li class="menu-item hidden"><a href="https://www.irisa.fr" target="_blank">IRISA</a></li>
            <li class="menu-item hidden"><a href="https://forum.codeigniter.com/" target="_blank">Community</a></li>
            <li class="menu-item hidden"><a href="https://codeigniter.com/contribute" target="_blank">Contribute</a></li>
        </ul>
    </div>

    <div class="heroe">
        <h1><?= esc(PROG) ?></h1>
        <p><strong id="span-publication-count"></strong> articles</p>
        <figure>
            <div id="map"></div>
            <figcaption>
                Nombre de collobrations avec l'IRISA par pays
            </figcaption>
        </figure>
    </div>

</header>

<section>
    <h2>Auteurs</h2>
    <p><a href="/dblp/author/11_2374">Laurent d'Orazio</a></p>

    
</section>

<!--
<details>
    <summary>VERSION CURL</summary>
        <pre>
        <?= esc(var_export(curl_version(), true)) ?>
        </pre>
    </details>

    
    <p><a href="/test-db">TEST DB</a></p>
-->

<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

<footer>
    <div class="environment">
        <p><a href="https://github.com/5cover/r410" target="_blank" rel="noopener noreferrer">Dépôt GitHub</a></p>
        <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

        <p>Environment: <?= ENVIRONMENT ?></p>

    </div>

    <div class="copyrights">

        <p>&copy; <?= date('Y') ?> CodeIgniter Foundation. CodeIgniter is open source project released under the MIT
            open source licence.</p>

    </div>

</footer>

<!-- SCRIPTS -->

<script {csp-script-nonce}>
    document.getElementById("menuToggle").addEventListener('click', toggleMenu);
    function toggleMenu() {
        var menuItems = document.getElementsByClassName('menu-item');
        for (var i = 0; i < menuItems.length; i++) {
            var menuItem = menuItems[i];
            menuItem.classList.toggle("hidden");
        }
    }
</script>

</body>
</html>
