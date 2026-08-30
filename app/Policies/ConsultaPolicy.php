<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Consulta;

class ConsultaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Consulta $consulta): bool
    {
        return $user->clinica_id === $consulta->clinica_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'recepcionista']);
    }

    public function update(User $user, Consulta $consulta): bool
    {
        return $user->clinica_id === $consulta->clinica_id;
    }

    public function delete(User $user, Consulta $consulta): bool
    {
        return $user->clinica_id === $consulta->clinica_id && in_array($user->role, ['admin', 'recepcionista']);
    }
}
