
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc(PROG) ?></title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">

    <?php foreach ($stylesheets ?? [] as $stylesheet) {
        echo link_tag($stylesheet);
    } 
    foreach ($scripts ?? [] as $script) {
        echo script_tag($script);
    } ?>
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
</header>