<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';

    protected $fillable = [
        'nombre',
    ];

    // Relación con usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_departamento');
    }

    // Relación con tickets asignados
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_departamento_asignado');
    }
}
