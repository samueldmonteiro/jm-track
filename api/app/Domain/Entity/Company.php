<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;

class Company
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $document,
        private Email $email,
        private string $phone,
        private string $password,
        
    ) {}

    protected $hidden = ['password'];

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
 
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document): self
    {
        $this->document = $document;
        return $this;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}
