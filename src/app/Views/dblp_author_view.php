<?php
use App\ValueObjects\Author;
use App\ValueObjects\AuthorKey;
use App\ValueObjects\NoteType;

assert($author instanceof Author);

function author_url(AuthorKey $key)
{
    return '/dblp/author/' . $key->pid->encode();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auteur et Publications - DBLP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style/dblp_author_view.css">
</head>

<body class="container mt-5">
    <header>
        <div class="menu">
            <ul>
                <li class="menu-toggle"><button id="menuToggle">&#9776;</button></li>
                <li class="menu-item hidden"><a href="/">Accueil</a></li>
                <li class="menu-item hidden"><a href="https://www.irisa.fr" target="_blank">IRISA</a></li>
                <li class="menu-item hidden"><a href="https://forum.codeigniter.com/" target="_blank">Community</a></li>
                <li class="menu-item hidden"><a href="https://codeigniter.com/contribute" target="_blank">Contribute</a></li>
            </ul>
        </div>
    </header>
    <main>
        <h1 class="mb-4"><?= esc($author->key->name) ?></h1>

        <p><a href="<?= esc($author->key->pid->to_dblp_url()) ?>" target="_blank">Voir sur DBLP</a></p>

        <h2>Profil</h2>
        <?php if ($author->key->orcid) { ?>
            <p>ORCID : <code><?= $author->key->orcid ?></code></p>
        <?php } ?>
        <ul>
            <?php foreach ($author->notes as $note) { ?>
                <li>
                    <?= match ($note->type) {
                        NoteType::Affiliation => 'Affilié à :',
                        NoteType::Award       => '🏆',
                        NoteType::IsNot       => 'À ne pas confondre avec :',
                    } . " $note->value" . ($note->label ? " ($note->label)" : '') ?>
                </li>
            <?php } ?>
        </ul>

        <?php if ($affiliations) { ?>
            <h2>Historique</h2>
            <div class="timeline">
                <?php foreach ($affiliations as /** @var \App\ValueObjects\Affiliation */ $a) { ?>
                    <div class="timeline-item">
                        <div class="timeline-date">
                            <?= $a->start_year ?> &ndash; <?= $a->end_year ?? 'Présent' ?>
                        </div>
                        <div class="timeline-content">
                            <h3><?= esc($a->role) ?></h3>
                            <p><strong><?= esc($a->institution) ?></strong></p>
                            <p><?= esc($a->city) ?>, <?= esc($a->country) ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            </div>
        <?php } ?>

        <?php
        $coauthors_frequency = [];
        foreach ($author->articles as $article) {
            foreach ($article->authors as $author_key) {
                $key                         = (string) $author_key->pid;
                $coauthors_frequency[$key] ??= [$author_key, 0];
                $coauthors_frequency[$key][1]++;
            }
        }
        usort($coauthors_frequency, fn($a, $b) => $b[1] - $a[1]);
        array_shift($coauthors_frequency);  // most frequent coauthor is always the author themselves
        ?>
        <h2>Co-auteurs</h2>
        <details>
            <summary><?= count($coauthors_frequency) ?> éléments</summary>
            <ol>
                <?php
                foreach ($coauthors_frequency as [$key, $frequency]) {
                    ?>
                    <li><a href="<?= author_url($key) ?>"><?= esc($key->name) ?></a> (<?= $frequency ?> apparitions)</a></li><?php
                }
                ?>
            </ol>
        </details>

        <h2 class="mt-4">Articles (<?= count($author->articles) ?>)</h2>
        <?php if (empty($author->articles)) { ?>
            <p>Aucun article trouvée.</p>
        <?php } else { ?>
            <ul class="list-group">
                <?php foreach ($author->articles as $article) { ?>
                    <li class="list-group-item">
                        <p><strong><?= esc($article->title ?? 'Titre inconnu') ?></strong></p>
                        <p><small>Année : <?= esc($article->year ?? 'N/A') ?></small></p>
                        <p><a href="<?= esc($article->url ?? '#') ?>" target="_blank">Voir sur DBLP</a></p>
                        <details>
                            <summary>Auteurs (<?= count($article->authors) ?>)</summary>
                            <ol>
                                <?php foreach ($article->authors as $a) { ?>
                                    <li><a href="<?= author_url($a) ?>"><?= esc($a->name) ?></a></li>
                                <?php } ?>
                            </ol>
                        </details>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </main>
    <footer>
    <div class="environment">
        <p><a href="https://github.com/5cover/r410" target="_blank" rel="noopener noreferrer">Dépôt GitHub</a></p>
    </div>
    <div class="copyrights">
        <p>&copy; <?= date('Y') ?> CodeIgniter Foundation. CodeIgniter is open source project released under the MIT
            open source licence.</p>
    </div>
</footer>
</body>

</html>