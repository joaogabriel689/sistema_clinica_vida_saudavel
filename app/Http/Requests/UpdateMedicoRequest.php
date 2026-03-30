<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateMedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'nome' => 'required|string|max:255',

            'crm' => [
                'required',
                'string',
                'max:255',
                Rule::unique('medicos', 'crm')->ignore($id)
                    ->where(fn ($q) => 
                        $q->where('clinica_id', Auth::user()->clinica_id)
                    )
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->medicoUserId())
            ],

            'especialidade' => 'required',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
        ];
    }

    private function medicoUserId()
    {
        $id = $this->route('id');

        return \App\Models\Medico::find($id)?->user_id;
    }
}