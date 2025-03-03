<?php

namespace App\Models;

use CodeIgniter\Model;

class DblpModel extends Model
{
    private const DBLP_URL = 'https://dblp.org';

    public function get_author_data(string $author_name)
    {
        $query    = urlencode($author_name);
        $url      = self::DBLP_URL . "/org/search/author/api?q={$query}&format=json";
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    public function get_publications(string $author_id)
    {
        $url = self::DBLP_URL . "/pid/{$author_id}.xml";
        $xml = simplexml_load_file($url);
        return json_encode($xml);
    }
}
