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
        // Verifica formato básico do e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email);
        }

        // Extrai o domínio e valida sua estrutura via regex
        $domain = explode('@', $email)[1];
        if (!$this->isValidDomain($domain)) {
            throw new InvalidEmailException($email);
        }
    }

    private function isValidDomain(string $domain): bool
    {
        // Regex para domínios genéricos (ex: example.com, sub.example.co.uk)
        return preg_match(
            '/^([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/', 
            $domain
        );
    }
}