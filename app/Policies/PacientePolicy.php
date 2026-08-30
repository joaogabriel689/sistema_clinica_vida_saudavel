<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Paciente;

class PacientePolicy
{
    /**
     * Determine if the user can view any patients.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'recepcionista', 'medico']);
    }

    /**
     * Determine if the user can view the patient.
     */
    public function view(User $user, Paciente $paciente): bool
    {
        return $user->clinica_id === $paciente->clinica_id;
    }

    /**
     * Determine if the user can create patients.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'recepcionista']);
    }

    /**
     * Determine if the user can update the patient.
     */
    public function update(User $user, Paciente $paciente): bool
    {
        return $user->clinica_id === $paciente->clinica_id && in_array($user->role, ['admin', 'recepcionista']);
    }

    /**
     * Determine if the user can delete the patient.
     */
    public function delete(User $user, Paciente $paciente): bool
    {
        return $user->clinica_id === $paciente->clinica_id && in_array($user->role, ['admin', 'recepcionista']);
    }
}
