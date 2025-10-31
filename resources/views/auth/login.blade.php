<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200 min-h-screen flex justify-center items-center">

    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h3 class="text-center text-2xl font-bold mb-4 text-blue-700">Iniciar Sesión</h3>

        <form method="POST" action="/login">
            @csrf

            <label class="block mb-2 font-semibold">Correo</label>
            <input type="email" name="email" class="w-full border p-2 rounded mb-3" required>

            <label class="block mb-2 font-semibold">Contraseña</label>
            <input type="password" name="password" class="w-full border p-2 rounded mb-4" required>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white w-full py-2 rounded">
                Ingresar
            </button>

            <p class="text-center mt-3 text-sm">
                ¿No tienes cuenta?
                <a href="/registro" class="text-blue-600 font-bold">Regístrate aquí</a>
            </p>
        </form>
    </div>


    <!-- SweetAlerts -->
    @if(session('success_login'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Bienvenido!',
            text: '{{ session("success_login") }}',
            confirmButtonColor: '#3b82f6'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session("error") }}',
            confirmButtonColor: '#ef4444'
        });
    </script>
    @endif

</body>
</html>
