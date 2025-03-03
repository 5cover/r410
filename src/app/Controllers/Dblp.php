<?php

namespace App\Controllers;

use App\Models\DblpModel;


class Dblp extends BaseController {
    public function author(string $name) {
        $model = model(DblpModel::class);

        // Récupération des infos de l'auteur
        $author_data = $model->get_author_data($name);

        if (!isset($author_data['result']['hits']['hit'][0]['info'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Auteur '$name' non trouvé dans DBLP.");
        }

        $author_info = $author_data['result']['hits']['hit'][0]['info'];
        $author_id = basename($author_info['url']);

        // Récupération des publications
        $publications = $model->get_publications($author_id);

        // Passage des données à la vue
        $data = [
            'author' => $author_info,
            'publications' => $publications['r'] ?? []
        ];

        view('dblp_view', $data);
    }
}
