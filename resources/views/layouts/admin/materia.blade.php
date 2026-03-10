<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias - Control Escolar</title>
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

        {{-- Formulario agregar --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-5">Agregar nueva materia</h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 text-sm mb-4">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.saveMateria') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                @csrf
                <div class="flex-1">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input
                        type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                        placeholder="Ej. Cálculo Diferencial"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    >
                </div>
                <div class="w-full sm:w-48">
                    <label for="clave" class="block text-sm font-medium text-gray-700 mb-1">Clave</label>
                    <input
                        type="text" id="clave" name="clave" value="{{ old('clave') }}" required
                        placeholder="Ej. MAT101"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    >
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg transition cursor-pointer">
                        Agregar
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabla de materias --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-5">Lista de materias</h2>

            @if ($materias->isEmpty())
                <p class="text-gray-400 text-sm text-center py-8">No hay materias registradas aún.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 uppercase text-xs">
                                <th class="pb-3 pr-6">#</th>
                                <th class="pb-3 pr-6">Nombre</th>
                                <th class="pb-3 pr-6">Clave</th>
                                <th class="pb-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($materias as $materia)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 pr-6 text-gray-400">{{ $materia->id }}</td>
                                    <td class="py-3 pr-6 font-medium text-gray-800">{{ $materia->nombre }}</td>
                                    <td class="py-3 pr-6">
                                        <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                            {{ $materia->clave }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.editMateria', $materia->id) }}"
                                                class="text-xs bg-yellow-100 text-yellow-700 hover:bg-yellow-200 font-medium px-3 py-1.5 rounded-lg transition">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.deleteMateria', $materia->id) }}" method="POST"
                                                onsubmit="return confirm('¿Eliminar esta materia?')">
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