<?php

namespace App\Controllers;

use App\Models\DblpModel;
use App\Models\OrcIdModel;
use App\ValueObjects\Pid;
use CodeIgniter\HTTP\Exceptions\HTTPException;

class Dblp extends BaseController
{
    function getAuthor(string $encoded_pid)
    {
        $model       = model(DblpModel::class);
        $orcid_model = model(OrcIdModel::class);

        // Récupération des infos de l'auteur

        // Récupération des publications
        try {
            $author_info = $model->get_author_info(Pid::decode($encoded_pid));
        } catch (HTTPException $e) {
            return view('error_view', [
                'e' => $e,
            ]);
        }
        // Passage des données à la vue
        return view('head_header', [
            'stylesheets' => [
                'css/base.css',
                'css/dblp_author.css',
            ],
        ]) . view('dblp_author', [
            'author'       => $author_info,
            'affiliations' => $author_info->key->orcid === null ? [] : $orcid_model->get_affiliations($author_info->key->orcid),
        ]) . view('footer');
    }
}
