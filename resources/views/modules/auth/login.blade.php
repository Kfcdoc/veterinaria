@extends('layouts.auth')

@section('titulo_pagina', 'Iniciar sesión - Veterinaria')

@section('contenido')
<div class="login-wrapper">

    {{-- Panel izquierdo: Branding --}}
    <div class="login-left">
        <div class="login-left-content">
            <img src="{{ asset('img/logo1.jpeg') }}" alt="Logo Veterinaria" class="login-logo">
            <h2 class="login-brand-title">Veterinaria</h2>
            <p class="login-brand-sub">Sistema de Gestión Integral</p>
            <div class="login-features">
                <div class="feature-item">
                    <i class="fas fa-dog"></i>
                    <span>Gestión de pacientes</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Control de citas</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-file-medical"></i>
                    <span>Historial clínico</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel derecho: Formulario --}}
    <div class="login-right">
        <div class="login-form-container">

            <div class="login-form-header">
                <h1 class="login-title">Bienvenido</h1>
                <p class="login-subtitle">Ingresa tus credenciales para continuar</p>
            </div>

            <form action="{{ route('logear') }}" method="POST" class="login-form">
                @csrf

                {{-- Email --}}
                <div class="form-group-custom">
                    <label for="email">
                        <i class="fas fa-user"></i> Usuario
                    </label>
                    <input
                        type="text"
                        class="input-custom {{ session('error') ? 'input-error' : '' }}"
                        id="email"
                        name="email"
                        placeholder="Ingresa tu usuario o correo"
                        value="{{ old('email') }}"
                        autofocus
                        autocomplete="off"
                    >
                </div>

                {{-- Password --}}
                <div class="form-group-custom">
                    <label for="password">
                        <i class="fas fa-lock"></i> Contraseña
                    </label>
                    <div class="input-password-wrap">
                        <input
                            type="password"
                            class="input-custom {{ session('error') ? 'input-error' : '' }}"
                            id="password"
                            name="password"
                            placeholder="Ingresa tu contraseña"
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- Error message --}}
                @if(session('error'))
                    <div class="alert-custom">
                        <i class="fas fa-exclamation-circle"></i>
                        Credenciales incorrectas. Intenta de nuevo.
                    </div>
                @endif

                {{-- Submit --}}
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar sesión
                </button>

            </form>

            <p class="login-footer-text">
                &copy; {{ date('Y') }} Veterinaria &mdash; Todos los derechos reservados
            </p>
        </div>
    </div>

</div>

{{-- Estilos inline del login --}}
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Nunito', sans-serif;
        background: #f0f2f5;
    }

    .login-wrapper {
        display: flex;
        min-height: 100vh;
        width: 100%;
    }

    /* ===== PANEL IZQUIERDO ===== */
    .login-left {
        flex: 1;
        background: linear-gradient(145deg, #1a237e 0%, #283593 40%, #3949ab 70%, #5c6bc0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }

    .login-left::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 300px; height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .login-left::after {
        content: '';
        position: absolute;
        bottom: -100px; left: -60px;
        width: 350px; height: 350px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .login-left-content {
        text-align: center;
        color: white;
        position: relative;
        z-index: 1;
    }

    .login-logo {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.3);
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        margin-bottom: 24px;
    }

    .login-brand-title {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .login-brand-sub {
        font-size: 0.95rem;
        opacity: 0.8;
        margin-bottom: 40px;
        font-weight: 300;
    }

    .login-features {
        display: flex;
        flex-direction: column;
        gap: 16px;
        text-align: left;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 14px;
        background: rgba(255,255,255,0.1);
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 0.9rem;
        backdrop-filter: blur(4px);
    }

    .feature-item i {
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
        opacity: 0.9;
    }

    /* ===== PANEL DERECHO ===== */
    .login-right {
        flex: 1;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .login-form-container {
        width: 100%;
        max-width: 420px;
    }

    .login-form-header {
        margin-bottom: 36px;
    }

    .login-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1a237e;
        margin-bottom: 8px;
    }

    .login-subtitle {
        color: #9e9e9e;
        font-size: 0.95rem;
    }

    /* ===== INPUTS ===== */
    .form-group-custom {
        margin-bottom: 22px;
    }

    .form-group-custom label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #424242;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group-custom label i {
        color: #3949ab;
        margin-right: 6px;
    }

    .input-custom {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e8eaf6;
        border-radius: 12px;
        font-size: 0.95rem;
        font-family: 'Nunito', sans-serif;
        color: #333;
        background: #f8f9ff;
        transition: all 0.3s ease;
        outline: none;
    }

    .input-custom:focus {
        border-color: #3949ab;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(57, 73, 171, 0.1);
    }

    .input-custom.input-error {
        border-color: #e53935;
        background: #fff5f5;
    }

    .input-password-wrap {
        position: relative;
    }

    .input-password-wrap .input-custom {
        padding-right: 50px;
    }

    .toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #9e9e9e;
        font-size: 1rem;
        padding: 0;
        transition: color 0.2s;
    }

    .toggle-password:hover { color: #3949ab; }

    /* ===== ALERT ===== */
    .alert-custom {
        background: #ffebee;
        border: 1px solid #ffcdd2;
        color: #c62828;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.88rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ===== BOTON ===== */
    .btn-login {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #1a237e, #3949ab);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        font-family: 'Nunito', sans-serif;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #283593, #5c6bc0);
        box-shadow: 0 8px 24px rgba(57, 73, 171, 0.4);
        transform: translateY(-1px);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    /* ===== FOOTER ===== */
    .login-footer-text {
        text-align: center;
        color: #bdbdbd;
        font-size: 0.8rem;
        margin-top: 32px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .login-wrapper { flex-direction: column; }
        .login-left { padding: 40px 24px; min-height: 280px; flex: none; }
        .login-logo { width: 90px; height: 90px; }
        .login-brand-title { font-size: 1.4rem; }
        .login-features { display: none; }
        .login-right { padding: 32px 24px; }
    }
</style>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endpush
