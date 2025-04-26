<?php

// app/Core/Domain/User/ValueObjects/Email.php
namespace App\Core\Domain\User\ValueObjects;

use App\Core\Domain\User\Exceptions\InvalidEmailException;

final class Email
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = strtolower($value); // Normaliza para minúsculas
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function validate(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email);
        }

        $domain = explode('@', $email)[1];
        if (!checkdnsrr($domain, 'MX')) { // Verifica se o domínio existe
            throw new InvalidEmailException($email);
        }
    }
}