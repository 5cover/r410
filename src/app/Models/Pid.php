<?php

namespace App\Models;

final readonly class Pid
{
    function __construct(
        public string $part1,
        public string $part2,
    ) {}

    static function from_url(string $url)
    {
        $author_url_paths = explode('/', parse_url($url, PHP_URL_PATH), 4);
        return new Pid((int) $author_url_paths[2], (int) $author_url_paths[3]);
    }

    static function from_string(string $pid)
    {
        return new Pid(...explode('/', $pid, 2));
    }

    function to_url(): string
    {
        return 'https://' . \Config\Services::dblp_domain() . '/pid/' . $this;
    }

    function __tostring()
    {
        return "$this->part1/$this->part2";
    }
}
