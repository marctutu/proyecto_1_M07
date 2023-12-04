{{-- resources/views/layouts/about-us.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- Aquí incluirías tu enlace a Tailwind CSS o a tu hoja de estilos personalizada -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Asumiendo que Tailwind está en app.css -->
    <style>
        /* Aquí puedes añadir estilos adicionales específicos para la página 'about-us' si es necesario */
        body {
            background-color: #6B46C1; /* bg-purple-600 */
            color: #fff; /* Texto blanco para que contraste con el fondo púrpura */
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
