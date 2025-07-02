<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $patterns = [
            'uppercase' => '/[A-Z]/',
            'lowercase' => '/[a-z]/',
            'numbers' => '/[0-9]/',
            'special' => '/[!@#$%^&*()\-_=+{};:,<.>]/',
            'length' => '/.{12,}/'
        ];

        $messages = [
            'uppercase' => 'debe contener al menos una letra mayúscula',
            'lowercase' => 'debe contener al menos una letra minúscula',
            'numbers' => 'debe contener al menos un número',
            'special' => 'debe contener al menos un carácter especial',
            'length' => 'debe tener al menos 12 caracteres'
        ];

        $errors = [];

        foreach ($patterns as $key => $pattern) {
            if (!preg_match($pattern, $value)) {
                $errors[] = $messages[$key];
            }
        }

        if (!empty($errors)) {
            $fail('La contraseña ' . implode(', ', $errors) . '.');
        }

        // Verificar si la contraseña está en la lista de contraseñas comunes
        $commonPasswords = [
            '123456', 'password', 'qwerty', 'admin', 'letmein',
            'welcome', 'monkey', 'football', 'abc123', '111111'
        ];

        if (in_array(strtolower($value), $commonPasswords)) {
            $fail('Esta contraseña es demasiado común. Por favor, elige una más segura.');
        }

        // Verificar si la contraseña contiene información personal común
        $commonInfo = [
            'admin', 'administrator', 'root', 'user', 'guest',
            date('Y'), date('y'), // año actual
            date('Y')-1, date('y')-1, // año anterior
        ];

        foreach ($commonInfo as $info) {
            if (stripos($value, $info) !== false) {
                $fail('La contraseña no debe contener información personal o común.');
                break;
            }
        }
    }
} 