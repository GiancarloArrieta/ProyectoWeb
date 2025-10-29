<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'correo',
        'contreseña',
        'id_rol',
        'id_departamento',
        'profile_photo',
    ];

    protected $hidden = [
        'contreseña',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'contreseña' => 'hashed',
        ];
    }

    // Relación con el rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    // Relación con el departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    // Relación con los tickets creados por el usuario
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_usuario');
    }

    // Método para obtener el nombre del rol
    public function getRolNombreAttribute()
    {
        return $this->rol ? $this->rol->nombre : 'Sin rol';
    }

    // Método para obtener el nombre del departamento
    public function getDepartamentoNombreAttribute()
    {
        return $this->departamento ? $this->departamento->nombre : 'Sin departamento';
    }
}
