<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200 min-h-screen flex justify-center items-center">

    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h3 class="text-center text-2xl font-bold mb-4 text-green-700">Crear Cuenta</h3>

        <form method="POST" action="/registro">
            @csrf

            <label class="block mb-2 font-semibold">Nombre</label>
            <input type="text" name="nombre" class="w-full border p-2 rounded mb-3" required>

            <label class="block mb-2 font-semibold">Correo</label>
            <input type="email" name="email" class="w-full border p-2 rounded mb-3" required>

            <label class="block mb-2 font-semibold">Contraseña</label>
            <input type="password" name="password" class="w-full border p-2 rounded mb-4" required>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white w-full py-2 rounded">
                Registrar
            </button>

            <p class="text-center mt-3 text-sm">
                ¿Ya tienes cuenta?
                <a href="/login" class="text-green-600 font-bold">Inicia sesión</a>
            </p>
        </form>
    </div>


    <!-- SweetAlerts -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Cuenta Creada!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#22c55e'
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error al Registrar',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#ef4444'
        });
    </script>
    @endif

</body>
</html>
