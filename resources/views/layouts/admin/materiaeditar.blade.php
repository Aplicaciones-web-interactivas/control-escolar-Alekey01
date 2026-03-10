<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Materia - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">Control Escolar</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.materia') }}" class="text-sm text-gray-600 hover:text-blue-600 transition">← Volver a materias</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition cursor-pointer">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-lg mx-auto px-6 py-10">

        <div class="bg-white rounded-2xl shadow p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Editar materia</h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 text-sm mb-5">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.updateMateria', $materia->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input
                        type="text" id="nombre" name="nombre"
                        value="{{ old('nombre', $materia->nombre) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    >
                </div>

                <div>
                    <label for="clave" class="block text-sm font-medium text-gray-700 mb-1">Clave</label>
                    <input
                        type="text" id="clave" name="clave"
                        value="{{ old('clave', $materia->clave) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    >
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition cursor-pointer">
                        Guardar cambios
                    </button>
                    <a href="{{ route('admin.materia') }}"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-lg transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

    </main>

</body>
</html>