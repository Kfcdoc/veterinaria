<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Dueno;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Veterinario;
use App\Models\User;
use Carbon\Carbon;

class ExpedientesDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Obtener o crear un veterinario
        $userVet = User::where('email', 'veterinario@gmail.com')->first();
        if (!$userVet) {
            $userVet = User::factory()->create(['email' => 'veterinario@gmail.com', 'rol' => 'veterinario']);
        }

        $veterinario = Veterinario::firstOrCreate(
            ['usuario_id' => $userVet->id],
            [
                'nombre_completo' => 'Dr. Juan Pérez',
                'especialidad' => 'Medicina Interna',
                'cedula_profesional' => '12345678',
                'foto_firma' => 'default.png'
            ]
        );

        // 2. Crear un Dueño
        $dueno = Dueno::create([
            'nombre_completo' => 'María Fernández',
            'telefono' => '555-123-4567',
            'direccion' => 'Av. Siempre Viva 742'
        ]);

        // 3. Crear una Mascota
        $mascota = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => 'Firulais',
            'especie' => 'Perro',
            'raza' => 'Golden Retriever',
            'fecha_nacimiento' => Carbon::now()->subYears(3),
            'tipo_sangre' => 'DEA 1.1 Positivo',
            'comportamiento' => 'Dócil y amigable',
            'es_adoptado' => true
        ]);

        // 4. Crear dos Consultas
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subMonths(2),
            'peso' => 25.5,
            'talla' => 60.0,
            'diagnostico' => 'Revisión general sana. Vacunación anual aplicada.',
            'tratamiento' => 'Ninguno. Próxima vacuna en un año.'
        ]);

        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subDays(5),
            'peso' => 26.0,
            'talla' => 60.0,
            'diagnostico' => 'Infección leve en oído derecho (Otitis externa).',
            'tratamiento' => 'Limpieza con suero fisiológico y aplicar gotas óticas (antibiótico/antiinflamatorio) 3 gotas cada 12 horas por 7 días.'
        ]);
    }
}
