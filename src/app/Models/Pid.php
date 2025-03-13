<?php

namespace App\Models;

final readonly class Pid
{
    function __construct(
        private readonly string $value,
    ) {
        assert(preg_match('/^[a-zA-Z0-9\/-]+$/', $value) === 1);
    }

    static function decode(string $encoded_value)
    {
        return new Pid(str_replace('_', '/', $encoded_value));
    }

    function encode(): string
    {
        return str_replace('/', '_', $this->value);
    }

    function to_dblp_url(): string
    {
        return 'https://' . \Config\Services::dblp_domain() . '/pid/' . $this;
    }

    function __tostring()
    {
        return $this->value;
    }
}
