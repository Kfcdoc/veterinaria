<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Veterinario;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $usuarios = User::all();
        return view('modules.admin.usuarios.index', compact('usuarios'));
    }

    public function create() {
        return view('modules.admin.usuarios.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'rol' => 'required|in:administrador,veterinario',
            'especialidad' => 'nullable|string|max:255',
            'cedula_profesional' => 'nullable|string|max:255|unique:veterinarios,cedula_profesional',
        ]);

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
}
