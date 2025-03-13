<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auteur et Publications - DBLP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <main>
        <h2 class="mb-4">Données DBLP pour <?= esc($author->name) ?></h2>

        <h4>Profil DBLP :</h4>
        <p><a href="<?= esc($author->pid->to_url()) ?>" target="_blank">Voir sur DBLP</a></p>

        <h3 class="mt-4">📚 Articles</h3>
        <?php if (empty($author->articles)) { ?>
            <p>Aucun article trouvée.</p>
        <?php } else { ?>
            <ul class="list-group">
                <?php foreach ($author->articles as /** @var \App\Models\Article */ $article) { ?>
                    <li class="list-group-item">
                        <p><strong><?= esc($article->title ?? 'Titre inconnu') ?></strong></p>
                        <p><small>Année : <?= esc($article->year ?? 'N/A') ?></small></p>
                        <p><a href="<?= esc($article->url ?? '#') ?>" target="_blank">Voir sur DBLP</a></p>
                        <details>
                            <summary>Auteurs (<?= count($article->authors) ?>)</summary>
                            <ol>
                                <?php foreach ($article->authors as $a) { ?>
                                    <li><p><a href="/dblp/author/<?= esc($a->pid) ?>"><?= esc($a->name) ?></a></p></li>
                                <?php } ?>
                            </ol>
                        </details>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </main>
</body>

</html>