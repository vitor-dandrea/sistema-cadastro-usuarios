<?php

// app/Core/Domain/User/ValueObjects/Password.php
namespace App\Core\Domain\User\ValueObjects;

use App\Core\Domain\User\Exceptions\WeakPasswordException;

final class Password
{
    private string $hash;

    public function __construct(string $plainPassword)
    {
        $this->validate($plainPassword);
        $this->hash = password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hash);
    }

    private function validate(string $password): void
    {
        if (strlen($password) < 8) {
            throw new WeakPasswordException("A senha deve ter pelo menos 8 caracteres");
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new WeakPasswordException("A senha deve conter números");
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            throw new WeakPasswordException("A senha deve conter caracteres especiais");
        }
    }
}