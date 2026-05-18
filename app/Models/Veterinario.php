<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinario extends Model
{
    protected $fillable = [
        'usuario_id',
        'nombre_completo',
        'especialidad',
        'cedula_profesional',
        'foto_firma',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
