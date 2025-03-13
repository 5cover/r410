<?php
namespace App\Models;

use App\Models\NoteType;

final readonly class Note
{
    function __construct(
        public NoteType $type,
        public string $value,
        public ?string $label,
    ) {}
}
