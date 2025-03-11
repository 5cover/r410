<?php
namespace App\Models;

final readonly class Author
{
    function __construct(
        public AuthorKey $key,

        /**
         * @var Article[]
         */
        public array $articles,

        /**
         * @var Note[]
         */
        public array $notes
    ) {}
}
