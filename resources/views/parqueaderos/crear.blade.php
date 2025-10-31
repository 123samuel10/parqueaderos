<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Parqueadero</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Registrar Nuevo Parqueadero</h2>
    <form method="POST" action="/guardar">
        @csrf
        <div class="mb-3">
            <label>Nombre del Parqueadero</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Espacios Disponibles</label>
            <input type="number" name="espacios_disponibles" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Precio por Hora</label>
            <input type="number" step="0.01" name="precio_por_hora" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="/" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
