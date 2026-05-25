<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedenteLesion extends Model
{
    protected $table = 'antecedentes_lesiones';

    protected $fillable = [
        'mascota_id',
        'tipo_lesion',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
