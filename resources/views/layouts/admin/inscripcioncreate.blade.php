<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Inscripción - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">Control Escolar</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('inscripciones.index') }}" class="text-sm text-gray-600 hover:text-blue-600 transition">← Volver a inscripciones</a>
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
            <h2 class="text-xl font-bold text-gray-800 mb-6">Nueva inscripción</h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 text-sm mb-5">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('inscripciones.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="alumno_id" class="block text-sm font-medium text-gray-700 mb-1">Alumno</label>
                    <select id="alumno_id" name="alumno_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                        <option value="">— Selecciona un alumno —</option>
                        @foreach ($alumnos as $alumno)
                            <option value="{{ $alumno->id }}" {{ old('alumno_id') == $alumno->id ? 'selected' : '' }}>
                                {{ $alumno->nombre }} ({{ $alumno->clave_institucional }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="materia_id" class="block text-sm font-medium text-gray-700 mb-1">Materia</label>
                    <select id="materia_id" name="materia_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                        <option value="">— Selecciona una materia —</option>
                        @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
                                {{ $materia->nombre }} ({{ $materia->clave }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="periodo" class="block text-sm font-medium text-gray-700 mb-1">Periodo</label>
                    <input
                        type="text" id="periodo" name="periodo"
                        value="{{ old('periodo') }}" required maxlength="20"
                        placeholder="Ej. 2026-1"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    >
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition cursor-pointer">
                        Inscribir
                    </button>
                    <a href="{{ route('inscripciones.index') }}"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-lg transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

    </main>

</body>
</html>
