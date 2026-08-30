<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Paciente;
use \App\Models\Clinica;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
class PacientesController extends Controller
{


    public function create()
    {

        return view('pacientes.create');
    }

    public function store(StorePacienteRequest $request)
    {



        $id_clinica = Auth::user()->resolveClinicaId();
        Paciente::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'data_nascimento' => $request->data_nascimento,
            'clinica_id' => $id_clinica,
        ]);
        return redirect()->route('admin.pacientes')->with('success', 'Paciente criado com sucesso.');
    }

    public function show($id)
    {
        $paciente = Paciente::with([
            'consultas.medico',
            'consultas.especialidade'
        ])->where('id', $id)->where('clinica_id', Auth::user()->resolveClinicaId())->firstOrFail();

        return view('pacientes.show', compact('paciente'));
    }

    public function edit($id)
    {
        $paciente = Paciente::where('id', $id)->where('clinica_id', Auth::user()->resolveClinicaId())->firstOrFail();
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(UpdatePacienteRequest $request, $id)
    {
        $paciente = Paciente::where('id', $id)->where('clinica_id', Auth::user()->resolveClinicaId())->firstOrFail();
        $paciente->update([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'data_nascimento' => $request->data_nascimento,
        ]);
        return redirect()->route('admin.pacientes')->with('success', 'Paciente atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $paciente = Paciente::where('id', $id)->where('clinica_id', Auth::user()->resolveClinicaId())->firstOrFail();
        $paciente->delete();
        return redirect()->route('admin.pacientes')->with('success', 'Paciente deletado com sucesso.');
    }

}
