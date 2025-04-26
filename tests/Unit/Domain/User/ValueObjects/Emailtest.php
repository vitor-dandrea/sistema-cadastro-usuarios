<?php

// tests/Unit/Domain/User/ValueObjects/EmailTest.php
namespace Tests\Unit\Domain\User\ValueObjects;

use App\Core\Domain\User\ValueObjects\Email;
use App\Core\Domain\User\Exceptions\InvalidEmailException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    // E-mails válidos
    public function test_valid_emails()
    {
        $validEmails = [
            'user@example.com',
            'first.last@sub.example.co.uk',
            'email+tag@example.org'
        ];

        foreach ($validEmails as $email) {
            $this->assertInstanceOf(Email::class, new Email($email));
        }
    }

    // E-mails inválidos
    public function test_invalid_emails()
    {
        $invalidEmails = [
            'user@.com',                 // Domínio vazio
            'user@example..com',         // Domínio com duplo ponto
            'user@-example.com',         // Hífen no início do domínio
            'user@example.c',            // TLD muito curto
            'user@example.123'           // TLD numérico
        ];

        foreach ($invalidEmails as $email) {
            $this->expectException(InvalidEmailException::class);
            new Email($email);
        }
    }

    // Normalização para minúsculas
    public function test_normalization()
    {
        $email = new Email('John.Doe@Example.COM');
        $this->assertEquals('john.doe@example.com', $email->getValue());
    }
}