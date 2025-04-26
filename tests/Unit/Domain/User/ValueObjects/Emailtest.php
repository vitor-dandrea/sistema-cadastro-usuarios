<?php

// tests/Unit/Domain/User/ValueObjects/EmailTest.php
namespace Tests\Unit\Domain\User\ValueObjects;

use App\Core\Domain\User\ValueObjects\Email;
use App\Core\Domain\User\Exceptions\InvalidEmailException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    // Teste 1: E-mail válido
    public function test_valid_email()
    {
        $email = new Email('john.doe@example.com');
        $this->assertEquals('john.doe@example.com', $email->getValue());
    }

    // Teste 2: E-mail inválido (sem @)
    public function test_invalid_email_missing_at()
    {
        $this->expectException(InvalidEmailException::class);
        new Email('johndoe.example.com');
    }

    // Teste 3: E-mail inválido (domínio inexistente)
    public function test_invalid_email_domain()
    {
        $this->expectException(InvalidEmailException::class);
        new Email('john.doe@nonexistentdomain.xyz');
    }

    // Teste 4: E-mail normalizado (maiúsculas → minúsculas)
    public function test_normalizes_email_to_lowercase()
    {
        $email = new Email('John.Doe@Example.COM');
        $this->assertEquals('john.doe@example.com', $email->getValue());
    }
}