<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Parqueadero</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8">

    @if(session('error'))
        <div class="mb-4 bg-red-600 text-white px-4 py-2 rounded-lg font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
        Reserva en <span class="text-blue-600">{{ $parqueadero->nombre }}</span>
    </h2>

    <!-- Selección de fecha -->
    <form method="GET" action="/reservar/{{ $parqueadero->id }}" class="mb-6">
        <label class="block text-gray-700 font-semibold mb-2">Selecciona el día</label>
        <input type="date" name="fecha" value="{{ $fecha }}"
               class="w-full border px-3 py-2 rounded-lg focus:ring focus:ring-blue-300"
               onchange="this.form.submit()">
    </form>

    @php
        $horas = range(6, 22);
        $ocupadas = [];

        foreach($reservas as $r) {
            $ini = intval(date('H', strtotime($r->hora_inicio)));
            $fin = intval(date('H', strtotime($r->hora_fin)));
            for($i = $ini; $i < $fin; $i++) $ocupadas[] = $i;
        }
    @endphp

    <!-- Formulario de reserva -->
    <form method="POST" action="/reservar" class="space-y-5">
        @csrf

        <input type="hidden" name="parqueadero_id" value="{{ $parqueadero->id }}">

        <!-- Hora inicio -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Hora de Inicio</label>
            <select name="hora_inicio" required
                class="w-full border px-3 py-2 rounded-lg focus:ring focus:ring-blue-300">
                <option value="">Seleccionar hora</option>

                @foreach($horas as $h)
                    <option value="{{ $fecha.' '.$h.':00' }}"
                        {{ in_array($h, $ocupadas) ? 'disabled class=bg-gray-300 text-gray-500' : '' }}>
                        {{ sprintf('%02d:00', $h) }}
                        {{ in_array($h, $ocupadas) ? ' (Ocupado)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Hora fin -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Hora de Fin</label>
            <select name="hora_fin" required
                class="w-full border px-3 py-2 rounded-lg focus:ring focus:ring-blue-300">
                <option value="">Seleccionar hora</option>

                @foreach($horas as $h)
                    <option value="{{ $fecha.' '.$h.':00' }}"
                        {{ in_array($h, $ocupadas) ? 'disabled class=bg-gray-300 text-gray-500' : '' }}>
                        {{ sprintf('%02d:00', $h) }}
                        {{ in_array($h, $ocupadas) ? ' (Ocupado)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-between">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md">
                Confirmar ✅
            </button>

            <a href="/"
               class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md">
                Volver
            </a>
        </div>
    </form>
</div>

</body>
</html>
