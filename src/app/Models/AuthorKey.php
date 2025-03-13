<?php
namespace App\Models;

final readonly class AuthorKey
{
    function __construct(
        public string $name,
        public Pid $pid,
        public ?string $orcid,
    ) {}
}
