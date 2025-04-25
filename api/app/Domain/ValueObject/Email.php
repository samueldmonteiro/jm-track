<?php

namespace App\Domain\ValueObject;

class Email
{
    public function __construct(private string $email)
    {
        $this->setEmail($email);
    }

    private function setEmail(string $email): void
    {
        if (!$this->isValidEmail($email)) {
            throw new \InvalidArgumentException("Email inválido: $email");
        }
        $this->email = $email;
    }

    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function equals(Email $other): bool
    {
        return $this->email === $other->getEmail();
    }
}
