<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PasswordComplexity extends Constraint
{
    public string $message = 'Пароль слишком простой.';
}