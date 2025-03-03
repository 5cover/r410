<?php

namespace App\Controllers;

use App\Models\DblpModel;


class Dblp extends BaseController {
    public function author($name) {
        $model = model(DblpModel::class);
        $data = $model->get_author_data($name);
        echo json_encode($data);
    }
}
