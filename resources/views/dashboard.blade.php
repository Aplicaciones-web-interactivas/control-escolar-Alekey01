<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">Control Escolar</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ Auth::user()->nombre }}</span>
                <span class="text-xs bg-blue-100 text-blue-700 font-medium px-2 py-0.5 rounded-full capitalize">
                    {{ Auth::user()->rol }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition cursor-pointer">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Contenido --}}
    <main class="max-w-5xl mx-auto px-6 py-10">
        <div class="bg-white rounded-2xl shadow p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Bienvenido, {{ Auth::user()->nombre }}</h2>
            <p class="text-gray-500">Has iniciado sesión correctamente en el sistema de Control Escolar.</p>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
                    <p class="text-sm text-blue-500 font-medium">Clave institucional</p>
                    <p class="text-xl font-bold text-blue-800 mt-1">{{ Auth::user()->clave_institucional }}</p>
                </div>
                <div class="bg-green-50 border border-green-100 rounded-xl p-5">
                    <p class="text-sm text-green-500 font-medium">Rol</p>
                    <p class="text-xl font-bold text-green-800 mt-1 capitalize">{{ Auth::user()->rol }}</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                    <p class="text-sm text-gray-500 font-medium">Estado</p>
                    <p class="text-xl font-bold text-gray-800 mt-1">
                        {{ Auth::user()->activo ? 'Activo' : 'Inactivo' }}
                    </p>
                </div>
            </div>

            {{-- Accesos rápidos --}}
            <div class="mt-8">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Accesos rápidos</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.materia') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Gestionar Materias
                    </a>
                    <a href="{{ route('calificaciones.index') }}"
                        class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Gestionar Calificaciones
                    </a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
