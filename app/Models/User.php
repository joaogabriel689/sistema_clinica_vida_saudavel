<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telefone',
        'clinica_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Resolve and return the valid clinica_id for the user, auto-creating if missing.
     */
    public function resolveClinicaId(): ?int
    {
        if ($this->clinica_id) {
            return $this->clinica_id;
        }

        // Try finding an existing clinic owned by this user
        $clinica = Clinica::where('user_id', $this->id)->first();
        if ($clinica) {
            $this->clinica_id = $clinica->id;
            $this->save();
            return $clinica->id;
        }

        // If no clinic exists, auto-create a default clinic for tenant isolation
        $clinica = Clinica::create([
            'nome' => 'Clínica ' . ($this->name ?? 'Minha Clínica'),
            'endereco' => 'Endereço Principal',
            'telefone' => '11999999999',
            'cnpj' => str_pad((string)rand(10000000, 99999999), 14, '0', STR_PAD_LEFT),
            'user_id' => $this->id,
        ]);

        $this->clinica_id = $clinica->id;
        $this->save();

        return $clinica->id;
    }
}
