<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Parqueaderos Disponibles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h1 class="text-center mb-4">Parqueaderos Disponibles</h1>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Espacios Disponibles</th>
                <th>Precio por Hora</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        @forelse($parqueaderos as $parqueadero)
            <tr>
                <td>{{ $parqueadero->nombre }}</td>
                <td>{{ $parqueadero->ubicacion }}</td>
                <td>{{ $parqueadero->espacios_disponibles }}</td>
                <td>${{ $parqueadero->precio_por_hora }}</td>
                <td>
                 <a href="/reservar/{{ $parqueadero->id }}" class="btn btn-success btn-sm">Reservar</a>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No hay parqueaderos disponibles en este momento.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <a href="/" class="btn btn-secondary">Volver</a>
</div>

</body>
</html>
