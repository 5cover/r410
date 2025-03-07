<?php

namespace App\Models;

use CodeIgniter\Cache\CacheInterface;
use CodeIgniter\Model;
use SimpleXMLElement;

// todo: maintain state of dblp domains so we don't keep timeouting.
// array domains [string, bool, long] : name, is_online, last_check
// try again if last check was more than half an hour ago

final readonly class CacheEntry
{
    function __construct(
        public int $timestamp,
        public string $data,
    ) {}
}

final class Remote
{
    private const CACHE_FOR = 1800;  // 30 minutes
    private const TIMEOUT   = 5;

    private bool $is_online;
    private int $last_check_at;
    private CacheInterface $cache;

    function __construct(
        readonly string $domain,
        CacheInterface $cache
    ) {
        $this->is_online     = true;
        $this->last_check_at = time();
        $this->cache         = $cache;
    }

    function request(string $protocol, string $right): string|false
    {
        $t         = time();
        $entryname = 'dblp_cache' . md5("$this->domain:$protocol:$right");
        $url       = "$protocol://$this->domain$right";

        // Check CodeIgniter's cache first
        if (($cached = $this->cache->get($entryname)) !== null) {
            error_log("cached $url\n");
            return $cached;
        }

        // Request the data
        if ($this->is_online || $t - $this->last_check_at > self::CACHE_FOR) {
            $ctx = stream_context_create([
                $protocol => ['timeout' => self::TIMEOUT]
            ]);
            error_log("request $url\n");
            $data = @file_get_contents($url, context: $ctx);
        } else {
            $data = false;
        }

        $this->last_check_at = $t;

        if ($this->is_online = $data !== false) {
            // Store in CodeIgniter cache
            $this->cache->save($entryname, $data, self::CACHE_FOR);
        }

        return $data;
    }
}

final class DblpModel extends Model
{
    private const PROTOCOL = 'https';

    private ?array $remotes = null;

    public function get_author_data(string $author_name): array
    {
        $response = $this->query_api('/search/author/api?format=json&q=' . urlencode($author_name));
        return json_decode($response, true);
    }

    /**
     * @param string $author_id
     * @return Article[]
     */
    public function get_publications(string $author_id): array
    {
        $xml = simplexml_load_string($this->query_api("/pid/$author_id.xml"));
        return array_map(function (SimpleXMLElement $a) {
            $o = json_decode(json_encode($a));
            return new Article($o->title, $o->year, $o->url);
        }, $xml->xpath('/dblpperson/r/article'));
    }

    /**
     * Executes a query against the DBLP API and returns the response.
     *
     * @param string $path The path to the DBLP API endpoint.
     * @return string The response from the DBLP API in plain text
     */
    private function query_api(string $path): string
    {
        if (!isset(self::$remotes)) {
            error_log('init remotes');
            $cache         = \Config\Services::cache();
            $this->remotes = [
                new Remote('dblp.org', $cache),
                new Remote('dblp.uni-trier.de', $cache),
                new Remote('dblp2.uni-trier.de', $cache),
                new Remote('dblp.dagstuhl.de', $cache),
            ];
        }

        foreach ($this->remotes as $remote) {
            error_clear_last();
            $res = $remote->request(self::PROTOCOL, $path);
            if (false !== $res) return $res;
        }
        $err = error_get_last();
        throw new \Exception('DBLP not accessible: ' . ($err === null ? null : var_export($err, true)));
    }
}
