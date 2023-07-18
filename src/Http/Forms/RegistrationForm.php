<?php

namespace Budgetwise\Http\Forms;

use Budgetwise\Core\Validator;

class RegistrationForm
{
    private array $errors = [];

    public function __construct($email, $password)
    {
        if (! Validator::email($email)) {
            $this->errors['email'] = "Please provide valid email address";
        }

        if (! Validator::string($password, 8, 255)) {
            $this->errors['password'] = "Password must have at least 8 characters";
        }
    }

    public function isValid(): bool
    {
        return count($this->errors) === 0;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors($field, $msg): static
    {
        $this->errors[$field] = $msg;
        return $this;
    }
}