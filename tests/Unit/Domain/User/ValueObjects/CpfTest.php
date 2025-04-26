<?php

// tests/Unit/Domain/User/ValueObjects/CpfTest.php
namespace Tests\Unit\Domain\User\ValueObjects;

use App\Core\Domain\User\ValueObjects\Cpf;
use App\Core\Domain\User\Exceptions\InvalidCpfException;
use App\Core\Domain\User\Exceptions\BlacklistedCpfException;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{
    // Teste 1: CPF válido
    public function test_valid_cpf()
    {
        $cpf = new Cpf('529.982.247-25');
        $this->assertEquals('52998224725', $cpf->getValue());
    }

    // Teste 2: CPF inválido (dígitos repetidos)
    public function test_invalid_repeated_digits_cpf()
    {
        $this->expectException(InvalidCpfException::class);
        new Cpf('123.456.789-00');
    }

    // Teste 3: CPF inválido (tamanho incorreto)
    public function test_invalid_length_cpf()
    {
        $this->expectException(InvalidCpfException::class);
        new Cpf('123');
    }

    // Teste 4: CPF na blacklist
    public function test_blacklisted_cpf()
    {
        $this->expectException(BlacklistedCpfException::class);
        new Cpf('000.000.000-00');
    }

    // Teste 5: Formatação correta
    public function test_formatted_cpf()
    {
        $cpf = new Cpf('52998224725');
        $this->assertEquals('529.982.247-25', $cpf->getFormatted());
    }
}