<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Veterinario;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $usuarios = User::with('veterinario')->paginate(5);
        return view('modules.admin.usuarios.index', compact('usuarios'));
    }

    public function create() {
        return view('modules.admin.usuarios.create');
    }

    public function store(StoreUserRequest $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        if ($request->rol === 'veterinario') {
            Veterinario::create([
                'usuario_id' => $user->id,
                'nombre_completo' => $request->name,
                'especialidad' => $request->especialidad,
                'cedula_profesional' => $request->cedula_profesional,
                'foto_firma' => null,
            ]);
        }

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario registrado correctamente.');
    }

    public function edit(User $user) {
        $user->load('veterinario');
        return view('modules.admin.usuarios.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user) {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Si mandaron contraseña, la actualizamos
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Si es veterinario, actualizamos sus datos profesionales
        if ($user->rol === 'veterinario' && $user->veterinario) {
            $user->veterinario->update([
                'nombre_completo' => $request->name,
                'especialidad' => $request->especialidad,
                'cedula_profesional' => $request->cedula_profesional,
            ]);
        }

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function show(User $user) {
        $user->load('veterinario');
        
        // Lógica para comprobar si tiene dependencias que impidan el borrado.
        // Como 'veterinarios' se borra en cascada, no cuenta como dependencia que bloquee.
        // En el futuro, aquí contaremos citas, pacientes, etc.
        $tieneDependencias = false; 
        
        return view('modules.admin.usuarios.show', compact('user', 'tieneDependencias'));
    }

    public function destroy(User $user) {
        // Prevenir borrar al propio administrador activo por seguridad
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.usuarios.index')->withErrors(['No puedes eliminar tu propia cuenta mientras estás logueado.']);
        }

        $user->delete();
        
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
