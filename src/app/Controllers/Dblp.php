<?php

namespace App\Controllers;

use App\Models\DblpModel;
use App\Models\Pid;
use CodeIgniter\HTTP\Exceptions\HTTPException;

class Dblp extends BaseController
{
    function getAuthor(string $pidLeft, string $pidRight)
    {
        $model = model(DblpModel::class);

        // Récupération des infos de l'auteur

        // Récupération des publications
        try {
            $author_info = $model->get_author_info(new Pid($pidLeft, $pidRight));
        } catch (HTTPException $e) {
            return view('error_view', [
                'e' => $e,
            ]);
        }

        // Passage des données à la vue
        return view('dblp_author_view', [
            'author' => $author_info,
        ]);
    }
}
