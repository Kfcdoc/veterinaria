<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
});

Route::middleware("auth")->group(function () {
    Route::get('/home', [AuthController::class, 'home'])->name('home');
    Route::get('/expedientes', function () {
        return view('modules.expedientes.index');
    })->name('expedientes.index');

    Route::get('/expedientes/buscar', function (Illuminate\Http\Request $request) {
        $query = $request->input('q');
        if (!$query) {
            return response()->json([]);
        }
        $resultados = App\Models\Mascota::search($query)->get();
        $resultados->load('dueno');
        return response()->json($resultados);
    })->name('expedientes.buscar');

    Route::get('/expedientes/mascotas/{mascota}/consultas', function (\App\Models\Mascota $mascota) {
        $mascota->load(['dueno', 'consultas.veterinario']);
        return view('modules.expedientes.consultas', compact('mascota'));
    })->name('expedientes.consultas');

    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        $mascota->load(['dueno', 'antecedentesAlergias', 'antecedentesLesiones', 'antecedentesPatologicos', 'historialAlimentacion']);
        $consulta->load('veterinario');
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }
        return view('modules.expedientes.consulta_detalle', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.detalle');

    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}/diagnostico', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }
        return view('modules.expedientes.diagnostico', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.diagnostico');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/diagnostico', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $request->validate([
            'diagnostico' => 'required|string'
        ]);

        $esNuevo = empty($consulta->diagnostico);
        
        $consulta->diagnostico = $request->diagnostico;
        $consulta->save();

        $mensaje = $esNuevo ? 'Se guardó la nueva información' : 'Se actualizó con éxito';

        return back()->with('success', $mensaje);
    })->name('expedientes.consultas.diagnostico.guardar');

    // Tratamiento
    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}/tratamiento', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        return view('modules.expedientes.tratamiento', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.tratamiento');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/tratamiento', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['tratamiento' => 'required|string']);
        $esNuevo = empty($consulta->tratamiento);
        $consulta->tratamiento = $request->tratamiento;
        $consulta->save();
        return back()->with('success', $esNuevo ? 'Se guardó el tratamiento' : 'Tratamiento actualizado con éxito');
    })->name('expedientes.consultas.tratamiento.guardar');

    // Alergias
    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}/alergias', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $mascota->load('antecedentesAlergias');
        return view('modules.expedientes.alergias', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.alergias');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/alergias', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['sustancia_alergena' => 'required|string|max:255']);
        \App\Models\AntecedenteAlergia::create([
            'mascota_id' => $mascota->id,
            'sustancia_alergena' => $request->sustancia_alergena,
            'reaccion' => $request->reaccion,
        ]);
        return back()->with('success', 'Alergia registrada exitosamente.');
    })->name('expedientes.consultas.alergias.guardar');

    // Lesiones
    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}/lesiones', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $mascota->load('antecedentesLesiones');
        return view('modules.expedientes.lesiones', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.lesiones');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/lesiones', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['tipo_lesion' => 'required|string|max:255']);
        \App\Models\AntecedenteLesion::create([
            'mascota_id' => $mascota->id,
            'tipo_lesion' => $request->tipo_lesion,
        ]);
        return back()->with('success', 'Lesión registrada exitosamente.');
    })->name('expedientes.consultas.lesiones.guardar');

    // Patológicos
    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}/patologicos', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $mascota->load('antecedentesPatologicos');
        return view('modules.expedientes.patologicos', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.patologicos');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/patologicos', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['enfermedad' => 'required|string|max:255']);
        \App\Models\AntecedentePatologico::create([
            'mascota_id' => $mascota->id,
            'enfermedad' => $request->enfermedad,
            'es_cronica' => $request->has('es_cronica'),
        ]);
        return back()->with('success', 'Antecedente patológico registrado.');
    })->name('expedientes.consultas.patologicos.guardar');

    // Alimentación
    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}/alimentacion', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $mascota->load('historialAlimentacion');
        return view('modules.expedientes.alimentacion', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.alimentacion');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/alimentacion', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['descripcion_dieta' => 'required|string']);
        \App\Models\HistorialAlimentacion::create([
            'mascota_id' => $mascota->id,
            'descripcion_dieta' => $request->descripcion_dieta,
            'frecuencia_diaria' => $request->frecuencia_diaria ?? 2,
        ]);
        return back()->with('success', 'Registro de alimentación guardado.');
    })->name('expedientes.consultas.alimentacion.guardar');
    
    // Rutas de Administrador
    Route::get('/admin/home', [AuthController::class, 'adminHome'])->name('admin.home');
    
    Route::get('/admin/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/admin/usuarios/crear', [UserController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/admin/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/admin/usuarios/{user}/editar', [UserController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/admin/usuarios/{user}', [UserController::class, 'update'])->name('admin.usuarios.update');
    Route::get('/admin/usuarios/{user}/eliminar', [UserController::class, 'show'])->name('admin.usuarios.show');
    Route::delete('/admin/usuarios/{user}', [UserController::class, 'destroy'])->name('admin.usuarios.destroy');

    // Configuración del Sistema
    Route::get('/admin/configuracion', function () {
        $config = \App\Models\ConfiguracionSistema::obtener();
        return view('modules.admin.configuracion', compact('config'));
    })->name('admin.configuracion');

    Route::post('/admin/configuracion', function (\Illuminate\Http\Request $request) {
        $config = \App\Models\ConfiguracionSistema::obtener();
        $config->fill($request->only([
            'nombre_clinica', 'mision', 'vision', 'valores', 'historia',
            'direccion_fisica', 'telefono_contacto'
        ]));

        // Precios como JSON
        if ($request->has('servicios_nombre')) {
            $servicios = [];
            $nombres = $request->input('servicios_nombre', []);
            $precios = $request->input('servicios_precio', []);
            foreach ($nombres as $i => $nombre) {
                if (!empty($nombre)) {
                    $servicios[] = ['nombre' => $nombre, 'precio' => $precios[$i] ?? 0];
                }
            }
            $config->precios_servicios = $servicios;
        }

        // Logo
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $config->logo_path = $path;
        }

        $config->save();
        return back()->with('success', 'Configuración actualizada correctamente.');
    })->name('admin.configuracion.guardar');

    // Antecedentes CRUD (eliminar registros individuales)
    Route::delete('/expedientes/mascotas/{mascota}/alergias/{alergia}', function (\App\Models\Mascota $mascota, \App\Models\AntecedenteAlergia $alergia) {
        if ($alergia->mascota_id !== $mascota->id) abort(404);
        $alergia->delete();
        return back()->with('success', 'Alergia eliminada.');
    })->name('expedientes.alergias.eliminar');

    Route::delete('/expedientes/mascotas/{mascota}/lesiones/{lesion}', function (\App\Models\Mascota $mascota, \App\Models\AntecedenteLesion $lesion) {
        if ($lesion->mascota_id !== $mascota->id) abort(404);
        $lesion->delete();
        return back()->with('success', 'Lesión eliminada.');
    })->name('expedientes.lesiones.eliminar');

    Route::delete('/expedientes/mascotas/{mascota}/patologicos/{patologico}', function (\App\Models\Mascota $mascota, \App\Models\AntecedentePatologico $patologico) {
        if ($patologico->mascota_id !== $mascota->id) abort(404);
        $patologico->delete();
        return back()->with('success', 'Antecedente eliminado.');
    })->name('expedientes.patologicos.eliminar');

    Route::delete('/expedientes/mascotas/{mascota}/alimentacion/{alimentacion}', function (\App\Models\Mascota $mascota, \App\Models\HistorialAlimentacion $alimentacion) {
        if ($alimentacion->mascota_id !== $mascota->id) abort(404);
        $alimentacion->delete();
        return back()->with('success', 'Registro de alimentación eliminado.');
    })->name('expedientes.alimentacion.eliminar');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
