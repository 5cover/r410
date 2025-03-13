<?php
namespace App\ValueObjects;

final readonly class Affiliation
{
    function __construct(
        public string $institution,
        public string $department,
        public string $role,
        public string $city,
        public string $region,
        public string $country,
        public ?int $start_year,
        public ?int $end_year,
    ) {}
}
