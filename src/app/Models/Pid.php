<?php

namespace App\Models;

final readonly class Pid
{
    function __construct(
        public int $part1,
        public int $part2,
    ) {}

    static function from_url(string $url)
    {
        $author_url_paths = explode('/', parse_url($url, PHP_URL_PATH));
        return new Pid((int) $author_url_paths[2], (int) $author_url_paths[3]);
    }

    function __tostring()
    {
        return "$this->part1/$this->part2";
    }
}
