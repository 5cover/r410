<?php
namespace App\Helpers;

use CodeIgniter\Cache\CacheInterface;
use CodeIgniter\HTTP\Exceptions\HTTPException;

final readonly class CacheEntry
{
    function __construct(
        public int $timestamp,
        public string $data,
    ) {}
}

/**
 * @property-read bool $is_online
 */
final class Remote
{
    private const CACHE_FOR = 18000;  // 300 minutes
    private const TIMEOUT   = 5;

    private bool $is_online;
    private int $last_check_at;
    private CacheInterface $cache;

    public function __get(string $name)
    {
        return match ($name) {
            'is_online' => $this->is_online,
        };
    }

    function __construct(
        readonly string $domain,
        CacheInterface $cache
    ) {
        [$this->is_online, $this->last_check_at] = $cache->get('remote' . md5($domain)) ?? [true, time()];
        $this->cache                             = $cache;
    }

    /**
     * @param string $protocol protocol
     * @param string $right right part of the url
     * @return string|bool A string if the request succeeded. False if the request failed
     * @throws HTTPException If an HTTP error occured.
     */
    function request(string $protocol, string $right): string|bool
    {
        $t         = time();
        $entryname = 'request' . md5("$this->domain:$protocol:$right");
        $url       = "$protocol://$this->domain$right";

        // Check CodeIgniter's cache first
        if (($cached = $this->cache->get($entryname)) !== null) {
            error_log("cached $url\n");
            return $cached;
        }

        // Request the data
        if ($this->is_online || $t - $this->last_check_at > self::CACHE_FOR) {
            $this->last_check_at = $t;
            error_log("request $url\n");

            try {
                $ch = curl_init($url);
                if (PHP_OS === 'WINNT') curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Pour benjamin

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);

                $data  = curl_exec($ch);
                $errno = curl_errno($ch);

                if ($errno !== 0) {
                    error_log('curl error: ' . curl_strerror($errno));
                    $data = false;
                } else {
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($http_code < 200 || $http_code > 299) {
                        throw new HTTPException("request $url", $http_code);
                    }
                }
            } finally {
                curl_close($ch);
            }

            $this->is_online = is_string($data);
        } else {
            $data = false;
        }

        if (is_string($data)) {
            // Store in CodeIgniter cache
            $this->cache->save($entryname, $data, self::CACHE_FOR);
        }

        return $data;
    }

    function __destruct()
    {
        $this->cache->save('remote' . md5($this->domain), [$this->is_online, $this->last_check_at], PHP_INT_MAX);
    }
}
