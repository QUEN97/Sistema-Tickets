<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon/faviconnew.png') }}" type="image/x-icon">

    <title> Fullgas - @yield('title') </title>

    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel=" stylesheet">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <!--Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Toast --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.css') }}">
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet" type="text/css" />

    @livewireStyles

    <!--JQuery-->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <!--Select 2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased text-gray-900 dark:text-gray-200">

    <!--Para los pillines que se quieren pasar de listos-->
    {{-- <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Capturar el evento de clic derecho en el body
            document.body.addEventListener("contextmenu", function(e) {
                e.preventDefault(); // Prevenir el menú contextual predeterminado

                // Crear el modal
                var modalContainer = document.createElement("div");
                modalContainer.className = "fixed inset-0 flex items-center justify-center z-50";
                modalContainer.innerHTML = `
                    <div class="bg-white p-8 rounded shadow-md">
                        <h2 class="bg-black p-2 rounded-md text-xl font-bold text-white text-center mb-4">¡Atención!</h2>
                        <p class="text-center mb-3">Al hacer click en la opción <strong>Aceptar</strong>, tendrá la oportunidad de realizar lo siguiente:</p>
                        <ul class="text-center">
                            <li style="display: flex; justify-content: center;" class="mb-2">
                                <svg width="24" height="24" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#b33ed6" d="M261.1 24.8c-6.3 0-12.7.43-19.2 1.18c-34.6 4.01-64.8 17.59-86.1 37.06c-21.4 19.48-34.2 45.56-31 73.16c2.8 24.6 17.8 45.2 39.1 59.4c2.6-6.2 5.9-11.9 9.2-16.5c-17.6-11.6-28.4-27.3-30.4-45c-2.3-19.7 6.7-39.58 24.8-56.14c18.2-16.57 45.3-29.06 76.6-32.68c31.3-3.63 60.6 2.33 82.1 14.3c21.4 11.98 34.7 29.31 37 48.92c2.2 19.3-6.2 38.8-23.4 55a69.91 69.91 0 0 0-35.4-10.6h-2.2c-5.1.1-10.1.7-15.3 1.8c-37.5 8.7-60.8 45.5-52.2 82.7c5.3 23 21.6 40.6 42.2 48.5l39.7 172.2l47 29.1l29.5-46.7l-23.5-14.5l14.8-23.4l-23.5-14.6l14.7-23.3l-23.5-14.6l14.8-23.4l-13.5-58.4c15.1-16.1 22-39.1 16.7-62.2c-2.7-11.7-8.2-22-15.8-30.4c18.9-19 29.8-43.5 26.8-69.2c-3.2-27.55-21.6-50.04-46.9-64.11c-20.5-11.45-45.8-17.77-73.1-17.59zm-20.2 135.5c-25.9 1.1-49.9 16.8-60.4 42.2c-9.1 21.9-6 45.7 6.2 64.2l-67.8 163l21.3 51l51.2-20.9l-10.7-25.5l25.6-10.4l-10.6-25.5l25.6-10.4l-10.7-25.5l25.6-10.5l22.8-54.8c-20.5-11.5-36.2-31.2-41.9-55.8c-6.9-30.3 3.1-60.6 23.8-81.1zm58 7.2c8.9-.1 17.3 3.5 23.4 9.4c-5.5 3.5-11.6 6.6-18 9.4c-1.6-.6-3.3-.8-5.1-.8c-.6 0-1.1 0-1.6.1c-7 .8-12.2 6.1-13.1 12.7c-.2 1-.2 2-.2 2.9c.1.3.1.7.1 1c1 8.4 8.3 14.2 16.7 13.2c6.8-.8 12-5.9 13-12.3c6.2-2.8 12-5.9 17.5-9.4c.2 1 .4 2 .5 3c2.1 18-11 34.5-29 36.6c-17.9 2.1-34.5-11-36.5-29c-2.1-18 11-34.5 29-36.6c1.1-.1 2.2-.2 3.3-.2z"/>
                                </svg>
                                <div> Acceso maestro al sistema. </div>
                            </li>
                            <li style="display: flex; justify-content: center;" class="mb-2">
                                <svg width="24" height="24" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                    <g fill="none" stroke="#b33ed6" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="5.25" height="5.25" x=".5" y="8.25" rx=".5"/>
                                        <rect width="5.25" height="5.25" x="8.25" y="8.25" rx=".5"/>
                                        <rect width="5.25" height="5.25" x="4.38" y=".5" rx=".5"/>
                                    </g>
                                </svg>
                                <div> Ajuste de módulos. </div>
                            </li>
                            <li style="display: flex; justify-content: center;" class="mb-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#b33ed6" d="M3 3.05c-.619.632-1 1.496-1 2.45v11A3.5 3.5 0 0 0 5.5 20h7.014c.051-.252.144-.5.28-.736l.73-1.264H5.5A1.5 1.5 0 0 1 4 16.5V7h14v1.254a4.515 4.515 0 0 1 2-.245V5.5c0-.954-.381-1.818-1-2.45V3h-.05a3.489 3.489 0 0 0-2.45-1h-11c-.954 0-1.818.381-2.45 1H3v.05ZM19.212 9a3.496 3.496 0 0 1 .96.044l-1.651 2.858a1.167 1.167 0 1 0 2.02 1.167l1.651-2.859a3.501 3.501 0 0 1-2.975 5.762l-3.031 5.25a1.458 1.458 0 0 1-2.527-1.458l3.026-5.24A3.5 3.5 0 0 1 19.212 9Zm-8.91.243a.75.75 0 0 1-.045 1.06L7.86 12.5l2.397 2.197a.75.75 0 0 1-1.014 1.106l-3-2.75a.75.75 0 0 1 0-1.106l3-2.75a.75.75 0 0 1 1.06.046Zm2.955 6.56l2.02-1.852a4.495 4.495 0 0 1-.008-2.91l-2.012-1.844a.75.75 0 0 0-1.014 1.106L14.64 12.5l-2.397 2.197a.75.75 0 0 0 1.014 1.106Z"/>
                                </svg>
                                <div> Ajuste de código fuente. </div>
                            </li>
                        </ul>
                        <div class="flex gap-2 justify-end">
                            <button class="mt-4 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded" id="closeModal">Cerrar</button>
                            <button class="mt-4 px-4 py-2 bg-black hover:bg-gray-600 rounded text-white" onclick="window.location.href='https://www.xataka.com/otros/31-cursos-gratis-para-aprender-a-programar-cero'">Aceptar</button>
                        </div>
                    </div>
                `;

                // Agregar el modal al body
                document.body.appendChild(modalContainer);

                // Capturar el clic en el botón de cerrar
                var closeModalButton = modalContainer.querySelector("#closeModal");
                closeModalButton.addEventListener("click", function() {
                    document.body.removeChild(modalContainer);
                });
            });
        });
    </script> --}}
    <div x-data="mainState" :class="{ dark: isDarkMode }" @resize.window="handleWindowResize" x-cloak>
        <x-banner />

        <div class="min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-2 dark:text-gray-200">
            <!-- Sidebar -->
            <x-sidebar.sidebar />

            <!-- Page Wrapper -->
            <div class="flex flex-col min-h-screen"
                :class="{
                    'lg:ml-64': isSidebarOpen,
                    'md:ml-16': !isSidebarOpen
                }"
                style="transition-property: margin; transition-duration: 150ms;">

                @livewire('navigation-menu')

                <x-mobile-bottom-nav />

                <!-- Page Heading -->
                @if (isset($header))
                    <header>
                        <div
                            class="px-4 py-6 mx-auto max-w-7xl w-full sm:px-6 lg:px-8 bg-white dark:bg-dark-eval-1 overflow-visible">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-1 p-4 mx-auto max-w-7xl w-full sm:p-6 lg:p-8">
                    {{ $slot }}
                    @livewire('atencion-guardia') {{-- llamado al componente  --}}
                </main>
                <!-- Page Footer -->
                <x-footer />
            </div>
        </div>
    </div>
    @stack('modals')

    @include('sweetalert::alert') {{-- llamado a las propiedades de Sweet Alert --}}

    @livewireScripts


    @auth
        <script>
            window.onload = function() {
                Echo.private('App.Models.User.' + {{ Auth::user()->id }})
                    .notification((notification) => {
                        console.log(notification.type)
                    });
            }
        </script>
    @endauth

    @stack('scripts')

    <script src="{{ 'assets/js/toastr.min.js' }}"></script>


    @if ($cantidadTicketsProximosVencer > 0)
        <script type="text/javascript">
            toastr.warning("EXISTE {{ $cantidadTicketsProximosVencer }} TICKETS PRÓXIMOS A VENCER")
        </script>
    @endif
    @if ($cantidadTicketsPorAtender > 0)
        <script type="text/javascript">
            toastr.info("EXISTE {{ $cantidadTicketsPorAtender }} TICKETS ABIERTOS")
        </script>
    @endif
    @if ($cantidadTicketsSinComentar > 0)
        <script type="text/javascript">
            toastr.info("EXISTE {{ $cantidadTicketsSinComentar}} TICKETS CON MÁS DE 3 DÍAS SIN ACTUALIZAR ")
        </script>
    @endif

</body>

</html>
