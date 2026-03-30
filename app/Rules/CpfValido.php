<?php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfValido implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // limpa CPF
        $cpf = preg_replace('/\D/', '', $value);

        // tamanho
        if (strlen($cpf) !== 11) {
            $fail('CPF inválido.');
            return;
        }

        // bloqueia repetidos
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            $fail('CPF inválido.');
            return;
        }

        $cpfArray = array_map('intval', str_split($cpf));

        // primeiro dígito
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $cpfArray[$i] * (10 - $i);
        }

        $digito1 = ($soma * 10) % 11;
        if ($digito1 === 10) {
            $digito1 = 0;
        }

        if ($digito1 !== $cpfArray[9]) {
            $fail('CPF inválido.');
            return;
        }

        // segundo dígito
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += $cpfArray[$i] * (11 - $i);
        }

        $digito2 = ($soma * 10) % 11;
        if ($digito2 === 10) {
            $digito2 = 0;
        }

        if ($digito2 !== $cpfArray[10]) {
            $fail('CPF inválido.');
        }
    }
}