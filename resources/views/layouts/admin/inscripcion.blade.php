<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripciones - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">Control Escolar</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-blue-600 transition">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition cursor-pointer">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10 space-y-8">

        {{-- Mensajes --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Encabezado --}}
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Inscripciones a materias</h2>
            <a href="{{ route('inscripciones.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                + Nueva inscripción
            </a>
        </div>

        {{-- Tabla --}}
        <div class="bg-white rounded-2xl shadow p-6">

            @if ($inscripciones->isEmpty())
                <p class="text-gray-400 text-sm text-center py-8">No hay inscripciones registradas aún.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 uppercase text-xs">
                                <th class="pb-3 pr-6">#</th>
                                <th class="pb-3 pr-6">Alumno</th>
                                <th class="pb-3 pr-6">Clave</th>
                                <th class="pb-3 pr-6">Materia</th>
                                <th class="pb-3 pr-6">Periodo</th>
                                <th class="pb-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($inscripciones as $ins)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 pr-6 text-gray-400">{{ $ins->id }}</td>
                                    <td class="py-3 pr-6 font-medium text-gray-800">{{ $ins->alumno->nombre }}</td>
                                    <td class="py-3 pr-6 text-gray-500 text-xs">{{ $ins->alumno->clave_institucional }}</td>
                                    <td class="py-3 pr-6 text-gray-700">
                                        {{ $ins->materia->nombre }}
                                        <span class="ml-1 bg-blue-100 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-full">
                                            {{ $ins->materia->clave }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-6">
                                        <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-1 rounded-full">
                                            {{ $ins->periodo }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('inscripciones.edit', $ins->id) }}"
                                                class="text-xs bg-yellow-100 text-yellow-700 hover:bg-yellow-200 font-medium px-3 py-1.5 rounded-lg transition">
                                                Editar
                                            </a>
                                            <form action="{{ route('inscripciones.destroy', $ins->id) }}" method="POST"
                                                onsubmit="return confirm('¿Eliminar esta inscripción?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-xs bg-red-100 text-red-700 hover:bg-red-200 font-medium px-3 py-1.5 rounded-lg transition cursor-pointer">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </main>

</body>
</html>
