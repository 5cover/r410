<?php
namespace App\Helpers;

use CodeIgniter\Cache\CacheInterface;

final readonly class CacheEntry
{
    function __construct(
        public int $timestamp,
        public string $data,
    ) {}
}

final class Remote
{
    private const CACHE_FOR = 18000;  // 300 minutes
    private const TIMEOUT   = 5;

    private bool $is_online;
    private int $last_check_at;
    private CacheInterface $cache;

    function __construct(
        readonly string $domain,
        CacheInterface $cache
    ) {
        [$this->is_online, $this->last_check_at] = $cache->get('remote' . md5($domain)) ?? [true, time()];
        $this->cache                             = $cache;
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
            $this->last_check_at = $t;
            static $ctx          = stream_context_create([
                'http' => ['timeout' => self::TIMEOUT]
            ]);
            error_log("request $url\n");
            $data            = @file_get_contents($url, context: $ctx);
            $this->is_online = $data !== false;
        } else {
            $data = false;
        }

        if ($data !== false) {
            // Store in CodeIgniter cache
            $this->cache->save($entryname, $data, self::CACHE_FOR);
        }

        return $data;
    }

    function __destruct() {
        $this->cache->save('remote' . md5($this->domain), [$this->is_online, $this->last_check_at], PHP_INT_MAX);
    }
}
