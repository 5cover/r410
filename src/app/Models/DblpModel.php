<?php

namespace App\Models;

use App\Helpers\Remote;
use CodeIgniter\Model;
use SimpleXMLElement;

final class DblpModel extends Model
{
    private static ?array $remotes = null;

    static function remotes(): array
    {
        if (self::$remotes === null) {
            error_log('init dblp remotes');
            $cache                  = \Config\Services::cache();
            self::$remotes = [
                new Remote('dblp.org', $cache),
                new Remote('dblp.uni-trier.de', $cache),
                new Remote('dblp2.uni-trier.de', $cache),
                new Remote('dblp.dagstuhl.de', $cache),
            ];
        }
        return self::$remotes;
    }

    private const PROTOCOL = 'https';

    public function get_author_data(string $author_name): array
    {
        $response = self::query_api('/search/author/api?format=json&q=' . urlencode($author_name));
        return json_decode($response, true);
    }

    /**
     * @param string $author_id
     * @return Article[]
     */
    public function get_publications(string $author_id): array
    {
        $xml = simplexml_load_string(self::query_api("/pid/$author_id.xml"));
        return array_map(function (SimpleXMLElement $a) {
            return new Article(
                (string) $a->title,
                (int) $a->year,
                (string) $a->ee
            );
        }, $xml->xpath('/dblpperson/r/article'));
    }

    /**
     * Executes a query against the DBLP API and returns the response.
     *
     * @param string $path The path to the DBLP API endpoint.
     * @return string The response from the DBLP API in plain text
     */
    private static function query_api(string $path): string
    {
        foreach (self::remotes() as $remote) {
            error_clear_last();
            $res = $remote->request(self::PROTOCOL, $path);
            if (false !== $res) return $res;
        }
        $err = error_get_last();
        throw new \Exception('DBLP not accessible: ' . ($err === null ? null : var_export($err, true)));
    }
}
