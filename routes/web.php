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
