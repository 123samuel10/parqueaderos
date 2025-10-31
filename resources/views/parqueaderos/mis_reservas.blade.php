<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h1 class="text-center mb-4">Bienvenido {{ $usuario->nombre }}</h1>
    <h4 class="text-center mb-3">Tus reservas</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="/logout" class="btn btn-danger">Cerrar sesión</a>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Parqueadero</th>
                <th>Ubicación</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
            </tr>
        </thead>
        <tbody>
        @forelse($reservas as $reserva)
            <tr>
                <td>{{ $reserva->parqueadero->nombre }}</td>
                <td>{{ $reserva->parqueadero->ubicacion }}</td>
         <td>{{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('h:i A') }}</td>
<td>{{ \Carbon\Carbon::parse($reserva->hora_fin)->format('h:i A') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Aún no tienes reservas registradas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

  <a href="{{ route('parqueaderos.disponibles') }}" class="btn btn-primary">Ver Parqueaderos Disponibles</a>

</div>

</body>
</html>
