<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos - Control Escolar</title>
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
                        Cerrar sesion
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Formulario nuevo alumno --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-base font-bold text-gray-800 mb-5">Nuevo alumno</h2>

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 text-sm mb-4">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.alumnos.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" required maxlength="100"
                                placeholder="Ej. Ana Martinez Lopez"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Clave institucional</label>
                            <input type="text" name="clave_institucional" value="{{ old('clave_institucional') }}" required maxlength="50"
                                placeholder="Ej. ALU-2026-001"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo electronico</label>
                            <input type="email" name="email" value="{{ old('email') }}" required maxlength="150"
                                placeholder="correo@ejemplo.com"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contrasena</label>
                            <input type="password" name="password" required minlength="6"
                                placeholder="Minimo 6 caracteres"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-lg transition cursor-pointer">
                            Registrar alumno
                        </button>
                    </form>
                </div>
            </div>

            {{-- Lista de alumnos --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-base font-bold text-gray-800 mb-5">Alumnos registrados</h2>

                    @if ($alumnos->isEmpty())
                        <p class="text-gray-400 text-sm text-center py-8">No hay alumnos registrados.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead>
                                    <tr class="border-b border-gray-200 text-gray-500 uppercase text-xs">
                                        <th class="pb-3 pr-6">Nombre</th>
                                        <th class="pb-3 pr-6">Clave</th>
                                        <th class="pb-3 pr-6">Correo</th>
                                        <th class="pb-3 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($alumnos as $alumno)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="py-3 pr-6 font-medium text-gray-800">{{ $alumno->nombre }}</td>
                                            <td class="py-3 pr-6 text-gray-500">{{ $alumno->clave_institucional }}</td>
                                            <td class="py-3 pr-6 text-gray-500">{{ $alumno->email }}</td>
                                            <td class="py-3 text-right">
                                                <form method="POST" action="{{ route('admin.alumnos.destroy', $alumno->id) }}"
                                                    onsubmit="return confirm('Eliminar a {{ $alumno->nombre }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs text-red-500 hover:text-red-700 font-medium transition cursor-pointer">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

</body>
</html>
