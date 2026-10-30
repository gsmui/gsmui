<?php

declare(strict_types=1);

namespace App\Shared\ValueObjects;

class Money
{
    public function __construct(
        private readonly int $amount,
        private readonly string $currency = 'USD'
    ) {}

    /**
     * Create money from a decimal amount.
     */
    public static function fromDecimal(float $amount, string $currency = 'USD'): self
    {
        return new self((int) round($amount * 100), $currency);
    }

    /**
     * Create money from cents.
     */
    public static function fromCents(int $cents, string $currency = 'USD'): self
    {
        return new self($cents, $currency);
    }

    /**
     * Get the amount in cents.
     */
    public function cents(): int
    {
        return $this->amount;
    }

    /**
     * Get the amount as a decimal.
     */
    public function decimal(): float
    {
        return $this->amount / 100;
    }

    /**
     * Get the currency.
     */
    public function currency(): string
    {
        return $this->currency;
    }

    /**
     * Format the money value.
     */
    public function format(): string
    {
        return number_format($this->decimal(), 2) . ' ' . $this->currency;
    }

    /**
     * Add two money values.
     */
    public function add(Money $other): Money
    {
        if ($this->currency !== $other->currency) {
            throw new \InvalidArgumentException('Cannot add money with different currencies');
        }

        return new self($this->amount + $other->amount, $this->currency);
    }

    /**
     * Subtract two money values.
     */
    public function subtract(Money $other): Money
    {
        if ($this->currency !== $other->currency) {
            throw new \InvalidArgumentException('Cannot subtract money with different currencies');
        }

        return new self($this->amount - $other->amount, $this->currency);
    }

    /**
     * Check if the money is zero.
     */
    public function isZero(): bool
    {
        return $this->amount === 0;
    }

    /**
     * Check if the money is positive.
     */
    public function isPositive(): bool
    {
        return $this->amount > 0;
    }

    /**
     * Check if the money is negative.
     */
    public function isNegative(): bool
    {
        return $this->amount < 0;
    }

    /**
     * Get the string representation.
     */
    public function __toString(): string
    {
        return $this->format();
    }
}
