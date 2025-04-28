<?php

// app/Core/Domain/User/Exceptions/WeakPasswordException.php
namespace App\Core\Domain\User\Exceptions;

class WeakPasswordException extends \DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}