<?php
namespace App\Models;
final readonly class AuthorInfo
{
    function __construct(
        public string $name,
        public Pid $pid,

        /**
         * @var Article[]
         */
        public array $articles
    ) {}
}