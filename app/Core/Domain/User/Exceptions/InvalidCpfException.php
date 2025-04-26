<?php

// app/Core/Domain/User/Exceptions/InvalidCpfException.php
namespace App\Core\Domain\User\Exceptions;

class InvalidCpfException extends \DomainException
{
    public function __construct(string $cpf)
    {
        parent::__construct("CPF $cpf é inválido");
    }
}