<?php

namespace App\Domain\ValueObject;

class Amount
{
    private float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function format(string $currencySymbol = 'R$'): string
    {
        return $currencySymbol . " ". number_format($this->value, 2, ',', '.');
    }

    public function add(Amount $amount): Amount
    {
        return new Amount($this->value + $amount->getValue());
    }

    public function subtract(Amount $amount): Amount
    {
        return new Amount($this->value - $amount->getValue());
    }

    public function multiply(float $factor): Amount
    {
        return new Amount($this->value * $factor);
    }

    public function divide(float $divisor): Amount
    {
        if ($divisor == 0) {
            throw new \InvalidArgumentException("Divisor cannot be zero.");
        }
        return new Amount($this->value / $divisor);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}