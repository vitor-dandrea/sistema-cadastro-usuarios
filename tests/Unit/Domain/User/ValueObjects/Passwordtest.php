<?php

// tests/Unit/Domain/User/ValueObjects/PasswordTest.php
namespace Tests\Unit\Domain\User\ValueObjects;

use App\Core\Domain\User\ValueObjects\Password;
use App\Core\Domain\User\Exceptions\WeakPasswordException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    // Teste 1: Senha válida
    public function test_valid_password()
    {
        $password = new Password('SenhaForte@123');
        $this->assertTrue(password_verify('SenhaForte@123', $password->getHash()));
    }

    // Teste 2: Senha fraca (mínimo de caracteres)
    public function test_short_password()
    {
        $this->expectException(WeakPasswordException::class);
        new Password('abc123');
    }

    // Teste 3: Senha fraca (sem números)
    public function test_password_without_numbers()
    {
        $this->expectException(WeakPasswordException::class);
        new Password('SenhaFraca@');
    }

    // Teste 4: Senha fraca (sem caracteres especiais)
    public function test_password_without_special_chars()
    {
        $this->expectException(WeakPasswordException::class);
        new Password('SenhaFraca123');
    }

    // Teste 5: Verificação de hash
    public function test_hash_verification()
    {
        $password = new Password('SenhaForte@123');
        $this->assertTrue($password->verify('SenhaForte@123'));
        $this->assertFalse($password->verify('senhaerrada'));
    }
}