<?php
namespace App\ValueObjects;

final readonly class Article
{
    function __construct(
        public ?string $title,
        public ?int $year,
        public ?string $url,

        /**
         * @var AuthorKey[]
         */
        public array $authors,
    ) {}
}
