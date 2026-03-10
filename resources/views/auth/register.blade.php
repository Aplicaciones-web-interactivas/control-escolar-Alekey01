<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">

    <div class="bg-white rounded-2xl shadow-lg w-full max-w-lg p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Control Escolar</h1>
            <p class="text-gray-500 mt-1">Crear nueva cuenta</p>
        </div>

        {{-- Errores --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg p-3 mb-6 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
            @csrf

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre completo
                </label>
                <input
                    id="nombre"
                    type="text"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    required
                    autofocus
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Ej. Juan Pérez García"
                >
            </div>

            <div>
                <label for="clave_institucional" class="block text-sm font-medium text-gray-700 mb-1">
                    Clave institucional
                </label>
                <input
                    id="clave_institucional"
                    type="text"
                    name="clave_institucional"
                    value="{{ old('clave_institucional') }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Ej. 2024001"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Correo electrónico
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="correo@ejemplo.com"
                >
            </div>

            <div>
                <label for="rol" class="block text-sm font-medium text-gray-700 mb-1">
                    Rol
                </label>
                <select
                    id="rol"
                    name="rol"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white"
                >
                    <option value="" disabled {{ old('rol') ? '' : 'selected' }}>Selecciona un rol</option>
                    <option value="alumno"   {{ old('rol') == 'alumno'   ? 'selected' : '' }}>Alumno</option>
                    <option value="maestro"  {{ old('rol') == 'maestro'  ? 'selected' : '' }}>Maestro</option>
                    <option value="admin"    {{ old('rol') == 'admin'    ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Contraseña
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Mínimo 8 caracteres"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirmar contraseña
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Repite la contraseña"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition cursor-pointer"
            >
                Crear cuenta
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Inicia sesión</a>
        </p>

    </div>

</body>
</html>
