<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Author;
use App\Models\AuthorKey;
use App\Models\Note;
use CodeIgniter\HTTP\Exceptions\HTTPException;
use CodeIgniter\Model;
use Exception;
use SimpleXMLElement;

final class DblpModel extends Model
{
    private const PROTOCOL = 'https';

    /**
     * Summary of search_author_name
     * @param string $author_name
     * @return array
     * @throws HTTPException
     */
    function search_author_name(string $author_name): array
    {
        $response = self::query_api('/search/author/api?format=json&q=' . urlencode($author_name));
        return json_decode($response, true);
    }

    /**
     * @param Pid $pid
     * @return Author
     *
     * @throws HTTPException
     */
    function get_author_info(Pid $pid): Author
    {
        $xml = simplexml_load_string(self::query_api("/pid/$pid.xml"));
        return new Author(
            new AuthorKey($xml->attributes()->name, $pid),
            array_map(fn(SimpleXMLElement $p) => new Article(
                (string) $p->title,
                (int) $p->year,
                (string) $p->ee,
                array_map(fn($a) => new AuthorKey($a, new Pid($a['pid'])), $p->xpath('./author')),
            ), $xml->xpath('/dblpperson/r/article')),
            array_map(fn(SimpleXMLElement $n) => new Note(
                match ((string)$n->attributes()->type) {
                    'affiliation' => NoteType::Affiliation,
                    'award'       => NoteType::Award,
                    'isnot'       => NoteType::IsNot,
                },
                $n,
                $n->attributes()->label ?? null,
            ), $xml->xpath('/dblpperson/person/note')),
        );
    }

    /**
     * Executes a query against the DBLP API and returns the response.
     *
     * @param string $path The path to the DBLP API endpoint.
     * @return string The response from the DBLP API in plain text
     *
     * @throws HTTPException
     */
    private static function query_api(string $path): string
    {
        foreach (\Config\Services::dblp_remotes() as /** @var App\Helpers\Remote */ $r) {
            error_clear_last();
            $res = $r->request(self::PROTOCOL, $path);
            $err = error_get_last();
            if (false !== $res) return $res;
        }
        throw new \Exception('DBLP not accessible ' . var_export($err, true));
    }
}
