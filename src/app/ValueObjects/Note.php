<?php
namespace App\ValueObjects;

use App\ValueObjects\NoteType;

final readonly class Note
{
    function __construct(
        public NoteType $type,
        public string $value,
        public ?string $label,
    ) {}
}
