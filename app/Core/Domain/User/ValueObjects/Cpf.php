<?php
// app/Core/Domain/User/ValueObjects/Cpf.php
namespace App\Core\Domain\User\ValueObjects;

use App\Core\Domain\User\Exceptions\InvalidCpfException;
use App\Core\Domain\User\Exceptions\BlacklistedCpfException;

final class Cpf
{
    private string $value;
    private const BLACKLIST = [
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999'
    ];

    public function __construct(string $value)
    {
        $cleanedValue = $this->clean($value);
        $this->validate($cleanedValue);
        $this->value = $cleanedValue;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getFormatted(): string
    {
        return substr($this->value, 0, 3) . '.' . 
               substr($this->value, 3, 3) . '.' . 
               substr($this->value, 6, 3) . '-' . 
               substr($this->value, 9, 2);
    }

    private function clean(string $cpf): string
    {
        return preg_replace('/[^0-9]/', '', $cpf);
    }

    private function validate(string $cpf): void
    {
        if (in_array($cpf, self::BLACKLIST, true)) {
            throw new BlacklistedCpfException($cpf);
        }

        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            throw new InvalidCpfException($cpf);
        }

        // Algoritmo de validação de dígitos
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw new InvalidCpfException($cpf);
            }
        }
    }
}