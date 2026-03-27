<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tareas - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">Control Escolar</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ Auth::user()->nombre }}</span>
                <span class="text-xs bg-blue-100 text-blue-700 font-medium px-2 py-0.5 rounded-full capitalize">
                    {{ Auth::user()->rol }}
                </span>
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

    <main class="max-w-6xl mx-auto px-6 py-10 space-y-6">

        {{-- Mensajes --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Encabezado --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Mis Tareas</h2>
            <p class="text-sm text-gray-500 mt-1">Aquí puedes ver las tareas asignadas y subir tu entrega en formato PDF.</p>
        </div>

        {{-- Lista de tareas --}}
        @if ($tareas->isEmpty())
            <div class="bg-white rounded-2xl shadow p-10 text-center">
                <p class="text-gray-400 text-sm">No tienes tareas asignadas aún.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($tareas as $tarea)
                    @php
                        $estadoClases = [
                            'pendiente'  => 'bg-yellow-100 text-yellow-700',
                            'entregada'  => 'bg-blue-100 text-blue-700',
                            'calificada' => 'bg-green-100 text-green-700',
                        ];
                    @endphp
                    <div class="bg-white rounded-2xl shadow p-6 space-y-4">

                        {{-- Cabecera de la tarea --}}
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-800">{{ $tarea->titulo }}</h3>
                                @if ($tarea->descripcion)
                                    <p class="text-sm text-gray-500 mt-1">{{ $tarea->descripcion }}</p>
                                @endif
                            </div>
                            <span class="shrink-0 text-xs font-semibold px-3 py-1 rounded-full {{ $estadoClases[$tarea->estado] ?? 'bg-gray-100 text-gray-600' }} capitalize">
                                {{ $tarea->estado }}
                            </span>
                        </div>

                        {{-- Detalles --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-sm">
                            <div class="bg-gray-50 rounded-lg px-4 py-3">
                                <p class="text-xs text-gray-400 font-medium uppercase mb-0.5">Materia</p>
                                <p class="text-gray-700 font-semibold">{{ $tarea->materia->nombre }}</p>
                                <p class="text-xs text-gray-400">{{ $tarea->materia->clave }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg px-4 py-3">
                                <p class="text-xs text-gray-400 font-medium uppercase mb-0.5">Maestro</p>
                                <p class="text-gray-700 font-semibold">{{ $tarea->maestro->nombre }}</p>
                                <p class="text-xs text-gray-400">{{ $tarea->maestro->clave_institucional }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg px-4 py-3">
                                <p class="text-xs text-gray-400 font-medium uppercase mb-0.5">Fecha de entrega</p>
                                <p class="text-gray-700 font-semibold">
                                    {{ $tarea->fecha_entrega ? \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') : '—' }}
                                </p>
                            </div>
                        </div>

                        {{-- Sección de entrega --}}
                        <div class="border-t border-gray-100 pt-4">
                            @if ($tarea->archivo_pdf)
                                <div class="flex items-center justify-between flex-wrap gap-3">
                                    <div class="flex items-center gap-2 text-sm text-green-700">
                                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-medium">Tarea entregada</span>
                                        <a href="{{ Storage::url($tarea->archivo_pdf) }}" target="_blank"
                                            class="ml-2 text-blue-600 hover:underline text-xs font-medium">
                                            Ver PDF
                                        </a>
                                    </div>
                                    @if ($tarea->estado !== 'calificada')
                                        {{-- Permite resubir si no ha sido calificada --}}
                                        <form method="POST"
                                            action="{{ route('alumno.tareas.subir', $tarea->id) }}"
                                            enctype="multipart/form-data"
                                            class="flex items-center gap-2">
                                            @csrf
                                            <input type="file" name="archivo_pdf" accept=".pdf" required
                                                class="text-xs text-gray-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                            <button type="submit"
                                                class="bg-gray-700 hover:bg-gray-800 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                                                Reemplazar PDF
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @elseif ($tarea->estado === 'calificada')
                                <p class="text-sm text-gray-400">Esta tarea ya fue calificada.</p>
                            @else
                                <form method="POST"
                                    action="{{ route('alumno.tareas.subir', $tarea->id) }}"
                                    enctype="multipart/form-data"
                                    class="flex items-center gap-3 flex-wrap">
                                    @csrf
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-xs text-gray-500">Solo se acepta formato <strong>PDF</strong> (máx. 10 MB)</span>
                                    </div>
                                    <input type="file" name="archivo_pdf" accept=".pdf" required
                                        class="text-xs text-gray-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition">
                                        Entregar tarea
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </main>

</body>
</html>
