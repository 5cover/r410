<main>
    <h1><?= esc(PROG) ?></h1>
    <div class="heroe">
        <p><strong id="span-publication-count"></strong> articles</p>
        <figure>
            <div id="map"></div>
            <figcaption>
                Nombre de collobrations avec l'IRISA par pays
            </figcaption>
        </figure>
    </div>
    <table>
        <thead>
            <th>Pays</th>
            <th>Nombre de collaborations</th>
        </thead>
        <tbody id="table-collaborations">

        </tbody>
    </table>
    <section>
        <h2>Auteurs</h2>
        <p><a href="/dblp/author/97_947">Olivier Barais</a></p>
        <p><a href="/dblp/author/94_2593">Jalil Boukhobza</a></p>
        <p><a href="/dblp/author/87_3974">Sandro Bimonte</a></p>
        <p><a href="/dblp/author/269_2155">Mohamed Handaoui</a></p>
        <p><a href="/dblp/author/153_7542">Jean-Emile Dartois</a></p>
        <p><a href="/dblp/author/41_2927">Julien Lallet</a></p>
        <p><a href="/dblp/author/138_1224">Romain Perriot</a></p>
        <p><a href="/dblp/author/11_2374">Laurent d'Orazio</a></p>
    </section>
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
</main>

