<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view("modules/auth/login");
    }

    public function logear(Request $request) {
        $credenciales = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credenciales)) {
            if (Auth::user()->rol === 'administrador') {
                return to_route('admin.home');
            }
            return to_route('home');
        } else {
            session()->flash('error', true);
            return to_route('login');
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return to_route('login');
    }

    public function home() {
        $user = Auth::user();
        $veterinario = clone $user->veterinario; // El veterinario actual
        $veterinarioId = $veterinario ? $veterinario->id : null;

        $stats = [
            'total_mascotas' => \App\Models\Mascota::count(),
            'consultas_hoy' => \App\Models\Consulta::whereDate('fecha_consulta', \Carbon\Carbon::today())->count(),
            'mis_consultas' => $veterinarioId ? \App\Models\Consulta::where('veterinario_id', $veterinarioId)->count() : 0,
        ];

        $consultasRecientes = collect();
        if ($veterinarioId) {
            $consultasRecientes = \App\Models\Consulta::with('mascota')
                ->where('veterinario_id', $veterinarioId)
                ->orderBy('fecha_consulta', 'desc')
                ->take(5)
                ->get();
        }

        return view('modules/dashboard/home', compact('stats', 'consultasRecientes'));
    }

    public function adminHome() {
        $stats = [
            'usuarios' => \App\Models\User::count(),
            'mascotas' => \App\Models\Mascota::count(),
            'consultas' => \App\Models\Consulta::count(),
        ];
        $config = \App\Models\ConfiguracionSistema::obtener();

        return view('modules/dashboard/admin_home', compact('stats', 'config'));
    }
}
