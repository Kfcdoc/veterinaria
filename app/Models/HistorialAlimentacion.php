<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialAlimentacion extends Model
{
    protected $table = 'historial_alimentacion';

    protected $fillable = [
        'mascota_id',
        'descripcion_dieta',
        'frecuencia_diaria',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
