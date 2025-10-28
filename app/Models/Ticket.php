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
        'id_auxiliar_asignado',
        'fecha_asignacion',
        'fecha_inicio',
        'fecha_finalizacion',
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_inicio' => 'datetime',
        'fecha_finalizacion' => 'datetime',
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

    // Relación con el auxiliar asignado
    public function auxiliarAsignado()
    {
        return $this->belongsTo(Usuario::class, 'id_auxiliar_asignado');
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
