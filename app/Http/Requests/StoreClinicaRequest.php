<?php

namespace App\Http\Requests;

use App\Rules\CnpjValido;
use Illuminate\Foundation\Http\FormRequest;

use App\Rules\CnpjValido;

class StoreClinicaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'cnpj' => ['required', new CnpjValido(), 'unique:clinicas,cnpj'],
        ];
    }
}
