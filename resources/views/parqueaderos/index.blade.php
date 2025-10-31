<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Parqueaderos Disponibles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Oculta elementos con x-cloak hasta que Alpine.js los inicialice -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans min-h-screen">

    <!-- Barra superior -->
    <header class="bg-blue-700 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Sistema Inteligente de Parqueaderos</h1>
            @if($usuario)
                <div class="flex items-center gap-4">
                    <span>👋 Hola, <span class="font-semibold">{{ $usuario->nombre }}</span></span>
                    <a href="/logout" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded transition">Cerrar sesión</a>
                </div>
            @else
                <div class="flex gap-2">
                    <a href="/login" class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded transition">Iniciar sesión</a>
                    <a href="/registro" class="bg-green-500 hover:bg-green-600 px-3 py-1 rounded transition">Registrarse</a>
                </div>
            @endif
        </div>
    </header>

    <!-- Contenedor principal -->
    <main class="max-w-6xl mx-auto p-6" x-data="{ modalOpen: false, selectedParqueadero: {} }">

        <!-- Alertas -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Botón de registrar parqueadero (solo admin) -->
        @if($usuario && $usuario->email === 'admin@gmail.com')
            <div class="text-right mb-6">
                <a href="/crear" class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2 rounded-lg shadow-md transition">
                    ➕ Registrar Nuevo Parqueadero
                </a>
            </div>
        @endif

        <!-- Grid de Parqueaderos -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($parqueaderos as $p)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition p-4 border-b border-gray-200">

                    <!-- Información del parqueadero -->
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $p->nombre }}</h2>
                            <p class="text-gray-600">{{ $p->ubicacion }}</p>
                            <div class="flex flex-col gap-2 mt-2">
                                <span class="text-gray-700 font-medium">Espacios: {{ $p->espacios_disponibles }}</span>
                                <span class="text-gray-700 font-medium">${{ $p->precio_por_hora }}/h</span>
                            </div>
                        </div>

                        <!-- Botones Admin -->
                        @if($usuario && $usuario->email === 'admin@gmail.com')
                            <div class="flex flex-col gap-2 ml-4">
                                <button @click="modalOpen = true; selectedParqueadero = {{ $p->toJson() }};"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow text-sm text-center">
                                    ✏️ Editar
                                </button>
                                <form action="/parqueadero/eliminar/{{ $p->id }}" method="POST" onsubmit="return confirm('¿Eliminar parqueadero?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-sm text-center">
                                        🗑️ Borrar
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Reservas (solo admin) -->
                    @if($usuario && $usuario->email === 'admin@gmail.com')
                        <div class="p-4 bg-gray-50 mt-3 rounded">
                            <h3 class="font-semibold text-gray-800 mb-2">Reservas</h3>
                            @if($p->reservas->isEmpty())
                                <p class="text-gray-400 italic">Sin reservas</p>
                            @else
                                <div class="flex flex-col gap-2">
                                    @foreach($p->reservas as $reserva)
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg px-3 py-2 shadow-sm hover:bg-blue-100 transition flex justify-between items-center">
                                            <div>
                                                <p class="text-blue-800 font-semibold">{{ $reserva->nombre_usuario }}</p>
                                                <span class="text-gray-600 text-xs">
                                                    {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('d/m/Y h:i A') }} —
                                                    {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('h:i A') }}
                                                </span>
                                            </div>
                                            <form action="/reserva/eliminar/{{ $reserva->id }}" method="POST" onsubmit="return confirm('¿Eliminar reserva?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">🗑️</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            @empty
                <p class="col-span-3 text-center py-6 text-gray-500">No hay parqueaderos registrados aún.</p>
            @endforelse
        </div>

        <!-- Modal de edición dinámico -->
        <div x-show="modalOpen" x-transition x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h3 class="text-lg font-bold mb-4">Editar Parqueadero</h3>
                <form :action="`/parqueadero/editar/${selectedParqueadero.id}`" method="POST">
                    @csrf
                    @method('PUT')

                    <label class="block mb-2">Nombre</label>
                    <input type="text" name="nombre" x-model="selectedParqueadero.nombre" class="w-full border rounded px-3 py-2 mb-4">

                    <label class="block mb-2">Ubicación</label>
                    <input type="text" name="ubicacion" x-model="selectedParqueadero.ubicacion" class="w-full border rounded px-3 py-2 mb-4">

                    <label class="block mb-2">Espacios Disponibles</label>
                    <input type="number" name="espacios_disponibles" x-model="selectedParqueadero.espacios_disponibles" class="w-full border rounded px-3 py-2 mb-4">

                    <label class="block mb-2">Precio/Hora</label>
                    <input type="number" step="0.01" name="precio_por_hora" x-model="selectedParqueadero.precio_por_hora" class="w-full border rounded px-3 py-2 mb-4">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="modalOpen = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

    </main>

</body>
</html>
