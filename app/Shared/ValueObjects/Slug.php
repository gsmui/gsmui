<?php

declare(strict_types=1);

namespace App\Shared\ValueObjects;

use Illuminate\Support\Str;

class Slug
{
    public function __construct(
        private readonly string $value
    ) {}

    /**
     * Create a slug from a string.
     */
    public static function fromString(string $value): self
    {
        return new self(Str::slug($value));
    }

    /**
     * Create a slug from an existing value.
     */
    public static function fromValue(string $value): self
    {
        return new self($value);
    }

    /**
     * Get the slug value.
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Check if the slug is valid.
     */
    public function isValid(): bool
    {
        return (bool) preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $this->value);
    }

    /**
     * Get the string representation.
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
