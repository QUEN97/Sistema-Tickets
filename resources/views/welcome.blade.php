<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon/faviconnew.png') }}" type="image/x-icon">

    <title>BIENVENIDO TICKETS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

  

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased">
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <img src="{{ asset('img/logo/FullGas.png') }}" alt="">
            </div>
            {{-- <div>
                <p class="mt-8 text-center">SISTEMA DE ATENCIÓN DE TICKETS HELPDESK
                </p>
            </div> --}}
            <div class="leyenda flex justify-center mt-3">
                <a id="loginLink" style="text-decoration: none; display: flex; align-items: center;" class="kbc-button" href="/login">
                    <span style="margin-right: 5px;">
                        <svg width="20" height="20" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#6b7280" d="M864 170h-60c-4.4 0-8 3.6-8 8v518H310v-73c0-6.7-7.8-10.5-13-6.3l-141.9 112a8 8 0 0 0 0 12.6l141.9 112c5.3 4.2 13 .4 13-6.3v-75h498c35.3 0 64-28.7 64-64V178c0-4.4-3.6-8-8-8z"/>
                        </svg>
                    </span>
                </a>
            </div>
            <small class="text-gray-500">Click al botón o presiona la tecla ENTER en tu teclado para acceder al Login del sistema.</small>
        </div>
    </div>
    <script>
        // Obtén el elemento del enlace por su ID
        var loginLink = document.getElementById("loginLink");
    
        // Agrega un evento de escucha para la tecla "Enter"
        document.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                // Previene la acción predeterminada de la tecla "Enter"
                event.preventDefault();
                
                // Redirige al usuario a la página de login
                window.location.href = loginLink.getAttribute("href");
            }
        });
    </script>
</body>
</html>
