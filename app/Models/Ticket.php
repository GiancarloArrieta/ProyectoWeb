<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'título',
        'descripción',
        'status',
        'id_usuario',
        'id_departamento_asignado',
    ];

    // Relación con el usuario que creó el ticket
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Relación con el departamento asignado
    public function departamentoAsignado()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento_asignado');
    }

    // Scope para filtrar por estado
    public function scopePorEstado($query, $estado)
    {
        return $query->where('status', $estado);
    }

    // Scope para filtrar por usuario
    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('id_usuario', $usuarioId);
    }
}
