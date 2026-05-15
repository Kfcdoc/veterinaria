# Sistema de Veterinaria

Sistema de gestión para clínicas veterinarias construido con Laravel.

## Estado Actual del Proyecto

Actualmente, el sistema cuenta con la estructura base de autenticación y separación de roles, utilizando la plantilla **SB Admin 2** para la interfaz gráfica.

### Características Implementadas

- **Autenticación (Login/Logout):** Sistema de inicio de sesión funcional y cierre de sesión seguro.
- **Gestión de Roles:** Soporte en base de datos para múltiples tipos de usuario (`administrador` y `veterinario`).
- **Redirección Inteligente:**
  - Los **Administradores** son redirigidos a un panel de control exclusivo (`/admin/home`).
  - Los **Veterinarios** son redirigidos al panel general de la clínica (`/home`).
- **Layouts (Plantillas) Independientes:** 
  - El administrador tiene un layout específico con sus propios menús de navegación (Sidebar y Topbar exclusivos).
  - El veterinario conserva el layout base enfocado a la atención médica.
- **Mensajes de Bienvenida:** Alertas dinámicas al ingresar a cada dashboard.

---

## Configuración y Ejecución Local

Para correr este proyecto en tu computadora, asegúrate de tener PHP, Composer y MySQL instalados.

1. **Instalar dependencias de PHP y Node:**
   ```bash
   composer install
   npm install
   ```

2. **Configurar el archivo de entorno:**
   Asegúrate de tener un archivo `.env` configurado con tus credenciales de base de datos (MySQL). Si no lo tienes, cópialo del ejemplo:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Crear las tablas y cargar datos de prueba:**
   Ejecuta las migraciones junto con los seeders para tener la base de datos lista.
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Levantar el servidor de desarrollo:**
   ```bash
   php artisan serve
   ```
   *Luego abre tu navegador en `http://localhost:8000`*

---

## Credenciales de Prueba

Al ejecutar el comando de migraciones con `--seed` (paso 3), se crearán automáticamente dos usuarios para que puedas probar ambos paneles del sistema:

**1. Cuenta de Administrador (Acceso al Admin Panel)**
- **Correo:** `admin@gmail.com`
- **Contraseña:** `admin`

**2. Cuenta de Veterinario (Acceso al Dashboard Médico)**
- **Correo:** `veterinario@gmail.com`
- **Contraseña:** `veterinario`
