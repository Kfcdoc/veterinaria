<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionSistema extends Model
{
    protected $table = 'configuracion_sistema';

    protected $fillable = [
        'nombre_clinica',
        'mision',
        'vision',
        'valores',
        'historia',
        'precios_servicios',
        'direccion_fisica',
        'telefono_contacto',
        'logo_path',
    ];

    protected $casts = [
        'precios_servicios' => 'array',
    ];

    /**
     * Obtener la configuración (singleton).
     */
    public static function obtener()
    {
        return static::firstOrCreate([], ['nombre_clinica' => 'Veterinaria']);
    }
}
