<?php
namespace App\Models;

final readonly class Author
{
    function __construct(
        public string $name,
        public string $pid,
    ) {}
}
