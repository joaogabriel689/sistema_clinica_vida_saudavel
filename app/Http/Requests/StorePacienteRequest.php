<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePacienteRequest extends FormRequest
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
            'nome' => 'required',
            'cpf' => ['required', new \App\Rules\CpfValido(), 'unique:pacientes,cpf'],
            'telefone' => 'required',
            'endereco' => 'required',
            'data_nascimento' => 'required|date',
        ];
    }
}
