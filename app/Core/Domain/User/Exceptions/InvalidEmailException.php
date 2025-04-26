<?php

// app/Core/Domain/User/Exceptions/InvalidEmailException.php
namespace App\Core\Domain\User\Exceptions;

class InvalidEmailException extends \DomainException
{
    public function __construct(string $email)
    {
        parent::__construct("E-mail $email é inválido");
    }
}