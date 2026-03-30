<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnpjValido implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // limpa
        $cnpj = preg_replace('/\D/', '', $value);

        // tamanho
        if (strlen($cnpj) !== 14) {
            $fail('CNPJ inválido.');
            return;
        }

        // bloqueia repetidos
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            $fail('CNPJ inválido.');
            return;
        }

        // primeiro dígito
        $peso1 = [5,4,3,2,9,8,7,6,5,4,3,2];
        $soma = 0;

        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $peso1[$i];
        }

        $resto = $soma % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;

        if ($digito1 != $cnpj[12]) {
            $fail('CNPJ inválido.');
            return;
        }

        // segundo dígito
        $peso2 = [6,5,4,3,2,9,8,7,6,5,4,3,2];
        $soma = 0;

        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $peso2[$i];
        }

        $resto = $soma % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;

        if ($digito2 != $cnpj[13]) {
            $fail('CNPJ inválido.');
        }
    }
}
