<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auteur et Publications - DBLP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Données DBLP pour <?= htmlspecialchars($author['author']) ?></h2>

    <h4>Profil DBLP :</h4>
    <p><a href="<?= htmlspecialchars($author['url']) ?>" target="_blank"><?= htmlspecialchars($author['url']) ?></a></p>

    <h3 class="mt-4">📚 Publications</h3>
    <?php if (!empty($publications)) : ?>
        <ul class="list-group">
            <?php foreach ($publications as $pub) : ?>
                <?php if (isset($pub['article'])) : ?>
                    <?php $article = $pub['article']; ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($article['title'] ?? "Titre inconnu") ?></strong>
                        <br>
                        <small>Année : <?= htmlspecialchars($article['year'] ?? "N/A") ?></small>
                        <br>
                        <a href="<?= htmlspecialchars($article['url'] ?? "#") ?>" target="_blank">Voir sur DBLP</a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Aucune publication trouvée.</p>
    <?php endif; ?>

</body>
</html>
