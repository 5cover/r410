<?php
namespace App\Models;

enum NoteType
{
    case Affiliation;
    case Award;
    case IsNot;
}

final readonly class Note
{
    function __construct(
        public NoteType $type,
        public string $value,
        public ?string $label,
    ) {}
}
