<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordComplexityValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (mb_strlen($value) < 8) {
            $this->context->buildViolation(
                'Пароль должен содержать минимум 8 символов.'
            )->addViolation();
        }

        if (preg_match_all('/\p{L}/u', $value) < 3) {
            $this->context->buildViolation(
                'Пароль должен содержать минимум 3 буквы.'
            )->addViolation();
        }

        if (preg_match_all('/[0-9]/', $value) < 2) {
            $this->context->buildViolation(
                'Пароль должен содержать минимум 2 цифры.'
            )->addViolation();
        }

        if (!preg_match('/[^\p{L}0-9]/u', $value)) {
            $this->context->buildViolation(
                'Пароль должен содержать спецсимвол.'
            )->addViolation();
        }

        if (preg_match('/^(.)\1*$/us', $value)) {
            $this->context->buildViolation(
                'Пароль не должен состоять из одинаковых символов.'
            )->addViolation();
        }

        // получение пользователя которому принадлежит пароль
        $user = $this->context->getObject();

        if ($user instanceof User) {
            if ($value === $user->getName()) {
                $this->context->buildViolation(
                    'Пароль не должен совпадать с именем.'
                )->addViolation();
            }

            if ($value === $user->getEmail()) {
                $this->context->buildViolation(
                    'Пароль не должен совпадать с email.'
                )->addViolation();
            }
        }
    }
}