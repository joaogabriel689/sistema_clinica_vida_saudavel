<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsultaRequest extends FormRequest
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
            'data_hora_inicio' => 'nullable|date_format:Y-m-d\TH:i',
            'data_hora_fim' => 'nullable|date_format:Y-m-d\TH:i|after:data_hora_inicio',
            'valor' => 'nullable|numeric|min:0',
            'medico_id' => 'nullable|exists:medicos,id',
            'paciente_id' => 'nullable|exists:pacientes,id',
            'convenio_id' => 'nullable|exists:convenios,id',
            'status' => 'nullable|in:agendada,confirmada,realizada,cancelada,faltou',
            'pago' => 'nullable|string|in:0,1',
            'observacoes' => 'nullable|string',
        ];
    }
}
