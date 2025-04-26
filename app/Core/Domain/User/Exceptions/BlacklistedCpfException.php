<?php

// app/Core/Domain/User/Exceptions/BlacklistedCpfException.php
namespace App\Core\Domain\User\Exceptions;

class BlacklistedCpfException extends \DomainException
{
    public function __construct(string $cpf)
    {
        parent::__construct("CPF $cpf está bloqueado");
    }
}