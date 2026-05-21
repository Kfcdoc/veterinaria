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
        $mascota->load('dueno');
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
        return view('modules.expedientes.alergias', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.alergias');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/alergias', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['alergias' => 'required|string']);
        $esNuevo = empty($mascota->alergias);
        $mascota->alergias = $request->alergias;
        $mascota->save();
        return back()->with('success', $esNuevo ? 'Alergias registradas' : 'Alergias actualizadas con éxito');
    })->name('expedientes.consultas.alergias.guardar');

    // Lesiones
    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}/lesiones', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        return view('modules.expedientes.lesiones', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.lesiones');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/lesiones', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['lesiones' => 'required|string']);
        $esNuevo = empty($mascota->lesiones);
        $mascota->lesiones = $request->lesiones;
        $mascota->save();
        return back()->with('success', $esNuevo ? 'Lesiones registradas' : 'Lesiones actualizadas con éxito');
    })->name('expedientes.consultas.lesiones.guardar');

    // Patológicos
    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}/patologicos', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        return view('modules.expedientes.patologicos', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.patologicos');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/patologicos', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['patologicos' => 'required|string']);
        $esNuevo = empty($mascota->patologicos);
        $mascota->patologicos = $request->patologicos;
        $mascota->save();
        return back()->with('success', $esNuevo ? 'Antecedentes patológicos registrados' : 'Antecedentes patológicos actualizados con éxito');
    })->name('expedientes.consultas.patologicos.guardar');

    // Alimentación
    Route::get('/expedientes/mascotas/{mascota}/consultas/{consulta}/alimentacion', function (\App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        return view('modules.expedientes.alimentacion', compact('mascota', 'consulta'));
    })->name('expedientes.consultas.alimentacion');

    Route::post('/expedientes/mascotas/{mascota}/consultas/{consulta}/alimentacion', function (\Illuminate\Http\Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta) {
        if ($consulta->mascota_id !== $mascota->id) abort(404);
        $request->validate(['alimentacion' => 'required|string']);
        $esNuevo = empty($mascota->alimentacion);
        $mascota->alimentacion = $request->alimentacion;
        $mascota->save();
        return back()->with('success', $esNuevo ? 'Dieta/Alimentación registrada' : 'Dieta/Alimentación actualizada con éxito');
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
    
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
