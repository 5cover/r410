<?php
namespace App\Helpers;

readonly class Faker implements \ArrayAccess
{
    function __construct(private string $value) {}

    function __get(string $name)
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    function offsetExists(mixed $offset): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    function offsetGet(mixed $offset): mixed
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \DomainException('read-only');
    }

    /**
     * @inheritDoc
     */
    function offsetUnset(mixed $offset): void
    {
        throw new \DomainException('read-only');
    }

    function __tostring()
    {
        return $this->value;
    }
}
