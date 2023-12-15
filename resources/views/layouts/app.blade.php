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

        /* body {
            background: grey;
            overflow-x: hidden;
        }

        @-moz-keyframes nieve {
            from {
                top: -40px;
            }

            to {
                top: 101%;
            }
        }

        @-webkit-keyframes nieve {
            from {
                top: -40px;
            }

            to {
                top: 2000px;
            }
        }

        @keyframes nieve {
            from {
                top: -40px;
            }

            to {
                top: 2000px;
            }
        }

        @-moz-keyframes horiz2 {
            20% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(150px);
            }

            80% {
                transform: translateX(0);
            }
        }

        @-webkit-keyframes horiz2 {
            20% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(150px);
            }

            80% {
                transform: translateX(0);
            }
        }

        @keyframes horiz2 {
            20% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(-70px);
            }

            80% {
                transform: translateX(0);
            }
        }

        @-moz-keyframes horiz {
            20% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(150px);
            }

            80% {
                transform: translateX(0);
            }
        }

        @-webkit-keyframes horiz {
            20% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(150px);
            }

            80% {
                transform: translateX(0);
            }
        }

        @keyframes horiz {
            20% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(150px);
            }

            80% {
                transform: translateX(0);
            }
        }

        .tpl-snow>div {
            position: fixed;
            -webkit-animation: ease-in infinite normal;
            -moz-animation: ease-in infinite normal;
            animation: ease-in infinite normal;
        }

        .tpl-snow>div {
            z-index: 9999999999999;
            width: 10px;
            height: 10px;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border-radius: 50%;
            background-color: #f1e7e7;
            -webkit-animation-name: nieve, horiz;
            -moz-animation-name: nieve, horiz;
            animation-name: nieve, horiz;
        }

        .tpl-snow>div:nth-of-type(odd) {
            width: 5px;
            height: 5px;
            -webkit-animation-name: nieve, horiz2;
            -moz-animation-name: nieve, horiz2;
            animation-name: nieve, horiz2;
        }

        .tpl-snow>div:nth-of-type(1) {
            left: 40px;
            -webkit-animation-duration: 5.5s;
            -moz-animation-duration: 5.5s;
            animation-duration: 5.5s;
            -webkit-animation-delay: 1s;
            -moz-animation-delay: 1s;
            animation-delay: 1s;
        }

        .tpl-snow>div:nth-of-type(2) {
            left: 120px;
            -webkit-animation-duration: 7s;
            -moz-animation-duration: 7s;
            animation-duration: 7s;
        }

        .tpl-snow>div:nth-of-type(3) {
            left: 200px;
            -webkit-animation-duration: 8s;
            -moz-animation-duration: 8s;
            animation-duration: 8s;
        }

        .tpl-snow>div:nth-of-type(4) {
            left: 20%;
            -webkit-animation-duration: 6s;
            -moz-animation-duration: 6s;
            animation-duration: 6s;
            -webkit-animation-delay: 1s;
            -moz-animation-delay: 1s;
            animation-delay: 1s;
        }

        .tpl-snow>div:nth-of-type(5) {
            left: 30%;
            -webkit-animation-duration: 9s;
            -moz-animation-duration: 9s;
            animation-duration: 9s;
        }

        .tpl-snow>div:nth-of-type(6) {
            left: 40%;
            -webkit-animation-duration: 7.2s;
            -moz-animation-duration: 7.2s;
            animation-duration: 7.2s;
            -webkit-animation-delay: 1s;
            -moz-animation-delay: 1s;
            animation-delay: 1s;
        }

        .tpl-snow>div:nth-of-type(7) {
            left: 50%;
            -webkit-animation-duration: 10s;
            -moz-animation-duration: 10s;
            animation-duration: 10s;
        }

        .tpl-snow>div:nth-of-type(8) {
            left: 60%;
            -webkit-animation-duration: 6.4s;
            -moz-animation-duration: 6.4s;
            animation-duration: 6.4s;
            -webkit-animation-delay: 1s;
            -moz-animation-delay: 1s;
            animation-delay: 1s;
        }

        .tpl-snow>div:nth-of-type(9) {
            left: 70%;
            -webkit-animation-duration: 10s;
            -moz-animation-duration: 10s;
            animation-duration: 10s;
            -webkit-animation-delay: 1.4s;
            -moz-animation-delay: 1.4s;
            animation-delay: 1.4s;
        }

        .tpl-snow>div:nth-of-type(10) {
            left: 80%;
            -webkit-animation-duration: 8s;
            -moz-animation-duration: 8s;
            animation-duration: 8s;
        }

        .tpl-snow>div:nth-of-type(11) {
            left: 90%;
            -webkit-animation-duration: 7.1s;
            -moz-animation-duration: 7.1s;
            animation-duration: 7.1s;
            -webkit-animation-delay: 2s;
            -moz-animation-delay: 2s;
            animation-delay: 2s;
        }

        .tpl-snow>div:nth-of-type(12) {
            left: 99%;
            -webkit-animation-duration: 6.6s;
            -moz-animation-duration: 6.6s;
            animation-duration: 6.6s;
            -webkit-animation-delay: 1.6s;
            -moz-animation-delay: 1.6s;
            animation-delay: 1.6s;
        }

        .tpl-snow>div:nth-of-type(13) {
            left: 10px;
            -webkit-animation-duration: 10.2s;
            -moz-animation-duration: 10.2s;
            animation-duration: 10.2s;
        }

        .tpl-snow>div:nth-of-type(14) {
            left: 180px;
            -webkit-animation-duration: 12s;
            -moz-animation-duration: 12s;
            animation-duration: 12s;
        }

        .tpl-snow>div:nth-of-type(15) {
            left: 213px;
            -webkit-animation-duration: 7.3s;
            -moz-animation-duration: 7.3s;
            animation-duration: 7.3s;
            -webkit-animation-delay: .5s;
            -moz-animation-delay: .5s;
            animation-delay: .5s;
        }

        .tpl-snow>div:nth-of-type(16) {
            left: 23%;
            -webkit-animation-duration: 9.2s;
            -moz-animation-duration: 9.2s;
            animation-duration: 9.2s;
        }

        .tpl-snow>div:nth-of-type(17) {
            left: 38%;
            -webkit-animation-duration: 5s;
            -moz-animation-duration: 5s;
            animation-duration: 5s;
        }

        .tpl-snow>div:nth-of-type(18) {
            left: 45%;
            -webkit-animation-duration: 15s;
            -moz-animation-duration: 15s;
            animation-duration: 15s;
        }

        .tpl-snow>div:nth-of-type(19) {
            left: 58%;
            -webkit-animation-duration: 5s;
            -moz-animation-duration: 5s;
            animation-duration: 5s;
        }

        .tpl-snow>div:nth-of-type(20) {
            left: 64%;
            -webkit-animation-duration: 12s;
            -moz-animation-duration: 12s;
            animation-duration: 12s;
        }

        .tpl-snow>div:nth-of-type(21) {
            left: 76%;
            -webkit-animation-duration: 5.6s;
            -moz-animation-duration: 5.6s;
            animation-duration: 5.6s;
            -webkit-animation-delay: 1s;
            -moz-animation-delay: 1s;
            animation-delay: 1s;
        }

        .tpl-snow>div:nth-of-type(22) {
            left: 86%;
            -webkit-animation-duration: 8.5s;
            -moz-animation-duration: 8.5s;
            animation-duration: 8.5s;
        }

        .tpl-snow>div:nth-of-type(23) {
            left: 83%;
            -webkit-animation-duration: 14.4s;
            -moz-animation-duration: 14.4s;
            animation-duration: 14.4s;
        }

        .tpl-snow>div:nth-of-type(24) {
            left: 95%;
            -webkit-animation-duration: 12s;
            -moz-animation-duration: 12s;
            animation-duration: 12s;
        }

        .tpl-snow>div:nth-of-type(25) {
            left: 55px;
            -webkit-animation-duration: 8.7s;
            -moz-animation-duration: 8.7s;
            animation-duration: 8.7s;
            -webkit-animation-delay: 1.2s;
            -moz-animation-delay: 1.2s;
            animation-delay: 1.2s;
        }

        .tpl-snow>div:nth-of-type(26) {
            left: 133px;
            -webkit-animation-duration: 5.2s;
            -moz-animation-duration: 5.2s;
            animation-duration: 5.2s;
        }

        .tpl-snow>div:nth-of-type(27) {
            left: 215px;
            -webkit-animation-duration: 10.4s;
            -moz-animation-duration: 10.4s;
            animation-duration: 10.4s;
            -webkit-animation-delay: 1.6s;
            -moz-animation-delay: 1.6s;
            animation-delay: 1.6s;
        }

        .tpl-snow>div:nth-of-type(28) {
            left: 26%;
            -webkit-animation-duration: 9s;
            -moz-animation-duration: 9s;
            animation-duration: 9s;
        }

        .tpl-snow>div:nth-of-type(29) {
            left: 33%;
            -webkit-animation-duration: 12s;
            -moz-animation-duration: 12s;
            animation-duration: 12s;
        }

        .tpl-snow>div:nth-of-type(30) {
            left: 49%;
            -webkit-animation-duration: 9.4s;
            -moz-animation-duration: 9.4s;
            animation-duration: 9.4s;
            -webkit-animation-delay: 1s;
            -moz-animation-delay: 1s;
            animation-delay: 1s;
        }

        .tpl-snow>div:nth-of-type(31) {
            left: 55%;
            -webkit-animation-duration: 9.1s;
            -moz-animation-duration: 9.1s;
            animation-duration: 9.1s;
        }

        .tpl-snow>div:nth-of-type(32) {
            left: 68%;
            -webkit-animation-duration: 9.6s;
            -moz-animation-duration: 9.6s;
            animation-duration: 9.6s;
            -webkit-animation-delay: .5s;
            -moz-animation-delay: .5s;
            animation-delay: .5s;
        }

        .tpl-snow>div:nth-of-type(33) {
            left: 73%;
            -webkit-animation-duration: 12.4s;
            -moz-animation-duration: 12.4s;
            animation-duration: 12.4s;
            -webkit-animation-delay: 1s;
            -moz-animation-delay: 1s;
            animation-delay: 1s;
        }

        .tpl-snow>div:nth-of-type(34) {
            left: 85%;
            -webkit-animation-duration: 9s;
            -moz-animation-duration: 9s;
            animation-duration: 9s;
            -webkit-animation-delay: 1.5s;
            -moz-animation-delay: 1.5s;
            animation-delay: 1.5s;
        }

        .tpl-snow>div:nth-of-type(35) {
            left: 93%;
            -webkit-animation-duration: 5s;
            -moz-animation-duration: 5s;
            animation-duration: 5s;
        }

        .tpl-snow>div:nth-of-type(36) {
            left: 99%;
            -webkit-animation-duration: 10.6s;
            -moz-animation-duration: 10.6s;
            animation-duration: 10.6s;
        }

        .tpl-snow>div:nth-of-type(37) {
            left: 15px;
            -webkit-animation-duration: 9.6s;
            -moz-animation-duration: 9.6s;
            animation-duration: 9.6s;
        }

        .tpl-snow>div:nth-of-type(38) {
            left: 99px;
            -webkit-animation-duration: 7.5s;
            -moz-animation-duration: 7.5s;
            animation-duration: 7.5s;
        }

        .tpl-snow>div:nth-of-type(39) {
            left: 260px;
            -webkit-animation-duration: 11s;
            -moz-animation-duration: 11s;
            animation-duration: 11s;
            -webkit-animation-delay: 1s;
            -moz-animation-delay: 1s;
            animation-delay: 1s;
        }

        .tpl-snow>div:nth-of-type(40) {
            left: 28%;
            -webkit-animation-duration: 19s;
            -moz-animation-duration: 19s;
            animation-duration: 19s;
        }

        .tpl-snow>div:nth-of-type(41) {
            left: 35%;
            -webkit-animation-duration: 14s;
            -moz-animation-duration: 14s;
            animation-duration: 14s;
        }

        .tpl-snow>div:nth-of-type(42) {
            left: 43%;
            -webkit-animation-duration: 5.6s;
            -moz-animation-duration: 5.6s;
            animation-duration: 5.6s;
        }

        .tpl-snow>div:nth-of-type(43) {
            left: 53%;
            -webkit-animation-duration: 8.8s;
            -moz-animation-duration: 8.8s;
            animation-duration: 8.8s;
            -webkit-animation-delay: 1s;
            -moz-animation-delay: 1s;
            animation-delay: 1s;
        }

        .tpl-snow>div:nth-of-type(44) {
            left: 66%;
            -webkit-animation-duration: 16s;
            -moz-animation-duration: 16s;
            animation-duration: 16s;
        }

        .tpl-snow>div:nth-of-type(45) {
            left: 78%;
            -webkit-animation-duration: 6s;
            -moz-animation-duration: 6s;
            animation-duration: 6s;
        }

        .tpl-snow>div:nth-of-type(46) {
            left: 88%;
            -webkit-animation-duration: 9.5s;
            -moz-animation-duration: 9.5s;
            animation-duration: 9.5s;
            -webkit-animation-delay: .5s;
            -moz-animation-delay: .5s;
            animation-delay: .5s;
        }

        .tpl-snow>div:nth-of-type(47) {
            left: 94%;
            -webkit-animation-duration: 7.6s;
            -moz-animation-duration: 7.6s;
            animation-duration: 7.6s;
        }

        .tpl-snow>div:nth-of-type(48) {
            left: 96%;
            -webkit-animation-duration: 8.2s;
            -moz-animation-duration: 8.2s;
            animation-duration: 8.2s;
            -webkit-animation-delay: .3s;
            -moz-animation-delay: .3s;
            animation-delay: .3s;
        }

        @media(max-width:600px) {
            .tpl-snow>div:nth-of-type(24)~* {
                display: none;
            }
        }

        @media(max-width:800px) {
            .tpl-snow>div:nth-of-type(36)~* {
                display: none;
            }
        } */
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
    {{-- <script type='text/javascript'>
        $(function() {
            $(document).bind("contextmenu", function(e) {
                return false;
            });
        });
    </script> --}}
    <div x-data="mainState" :class="{ dark: isDarkMode }" @resize.window="handleWindowResize" x-cloak>
        <x-banner />

        <div class="min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-2 dark:text-gray-200 ">
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
                    <!-- Divs copos de nieve -->
                    {{-- <div class="tpl-snow">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div> --}}
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

    <style>
        .bg-opacity-50 {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
    
    @if ($cantidadTicketsProximosVencer > 0)
        <script type="text/javascript">
            toastr.error("EXISTE {{ $cantidadTicketsProximosVencer }} TICKETS PRÓXIMOS A VENCER", 'Tickets por vencer', {

                timeOut: 0, // Desactiva el tiempo de espera automático para la notificación
                extendedTimeOut: 0, // Desactiva el tiempo extendido de espera
                closeButton: true, // Muestra el botón de cierre en la notificación

                onclick: function() {
                    document.getElementById('miModalV').classList.remove('hidden');
                    document.getElementById('miModalV').classList.add('flex');

                    document.getElementById('closeModalBtnV').addEventListener('click', function() {
                        document.getElementById('miModalV').classList.add('hidden');
                        document.getElementById('miModalV').classList.remove('flex');
                    });

                    document.getElementById('closeModalV').addEventListener('click', function() {
                        document.getElementById('miModalV').classList.add('hidden');
                        document.getElementById('miModalV').classList.remove('flex');
                    });
                }
            });
        </script>

        <!-- Modal -->
        <div id="miModalV"
            class="hidden fixed inset-0 items-center justify-center z-50 overflow-auto bg-black bg-opacity-50">
            <div class="bg-white p-8 rounded-lg">
                <div class="modal-header flex justify-between items-center mb-4">
                    <h5 class="modal-title text-lg font-semibold">Tickets <strong>PRÓXIMOS A VENCER</strong> </h5>
                    <div class="text-xs">* Tickets cuya <strong>FECHA DE VENCIMIENTO</strong> se da dentro de 5 horas.
                    </div>
                </div>
                <div class="modal-body">
                    <div class=" max-h-72 overflow-auto">
                        <table class="w-full text-center rounded-b-md">
                            <thead>
                                <tr>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        ID
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        ESTADO
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        ASUNTO
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        CLIENTE
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        AGENTE
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        CREADO
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        VENCE
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        PRIORIDAD
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        OPCIÓN
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticketsProximosVencer as $item)
                                    <tr>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->id }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            <div>
                                                {{ $item->status }}
                                            </div>
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->falla->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->cliente->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->agente->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->created_at }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->fecha_cierre }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->falla->prioridad->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                href="{{ route('tck.ver', $item->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                    fill="currentColor"
                                                    class="w-6 h-6 text-black hover:text-gray-600 dark:text-white"
                                                    viewBox="0 0 576 512">
                                                    <path
                                                        d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                </svg>
                                                <span class="tooltiptext">Ver Más</span>
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button id="closeModalBtnV"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md mr-4">
                        Cerrar
                    </button>
                    <!-- Otros botones o acciones que desees -->
                </div>
            </div>
        </div>
    @endif
    @if ($cantidadTicketsPorAtender > 0)
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                toastr.info("EXISTE {{ $cantidadTicketsPorAtender }} TICKETS ABIERTOS", 'Tickets abiertos', {

                    timeOut: 0, // Desactiva el tiempo de espera automático para la notificación
                    extendedTimeOut: 0, // Desactiva el tiempo extendido de espera
                    closeButton: true, // Muestra el botón de cierre en la notificación

                    onclick: function() {
                        document.getElementById('miModalA').classList.remove('hidden');
                        document.getElementById('miModalA').classList.add('flex');

                        document.getElementById('closeModalBtnA').addEventListener('click', function() {
                            document.getElementById('miModalA').classList.add('hidden');
                            document.getElementById('miModalA').classList.remove('flex');
                        });

                        document.getElementById('closeModalA').addEventListener('click', function() {
                            document.getElementById('miModalA').classList.add('hidden');
                            document.getElementById('miModalA').classList.remove('flex');
                        });
                    }
                });
            });
        </script>

        <!-- Modal -->
        <div id="miModalA"
            class="hidden fixed inset-0 items-center justify-center z-50 overflow-auto bg-black bg-opacity-50">
            <div class="bg-white p-8 rounded-lg">
                <div class="modal-header flex justify-between items-center mb-4">
                    <h5 class="modal-title text-lg font-semibold">Tickets <strong>POR ATENDER</strong> </h5>
                    <div class="text-xs">* Tickets con estado <strong>ABIERTO</strong> con más de 30 minutos sin atender
                        desde su creación.</div>
                </div>
                <div class="modal-body">
                    <div class=" max-h-72 overflow-auto">
                        <table class="w-full text-center rounded-b-md">
                            <thead>
                                <tr>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        ID
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        ESTADO
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        ASUNTO
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        CLIENTE
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        AGENTE
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        CREADO
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        VENCE
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        PRIORIDAD
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        OPCIÓN
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticketsPorAtender as $item)
                                    <tr>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->id }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            <div>
                                                {{ $item->status }}
                                            </div>
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->falla->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->cliente->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->agente->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->created_at }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->fecha_cierre }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->falla->prioridad->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                href="{{ route('tck.ver', $item->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                    fill="currentColor"
                                                    class="w-6 h-6 text-black hover:text-gray-600 dark:text-white"
                                                    viewBox="0 0 576 512">
                                                    <path
                                                        d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                </svg>
                                                <span class="tooltiptext">Ver Más</span>
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button id="closeModalBtnA"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md mr-4">
                        Cerrar
                    </button>
                    <!-- Otros botones o acciones que desees -->
                </div>
            </div>
        </div>
    @endif
    @if ($cantidadTicketsSinComentar > 0)
        <script type="text/javascript">
            toastr.warning("EXISTE {{ $cantidadTicketsSinComentar }} TICKETS CON MÁS DE 3 DÍAS SIN ACTUALIZAR ",
                'Tickets sin comentar', {
                    timeOut: 0, // Desactiva el tiempo de espera automático para la notificación
                    extendedTimeOut: 0, // Desactiva el tiempo extendido de espera
                    closeButton: true, // Muestra el botón de cierre en la notificación
                    onclick: function() {
                        document.getElementById('miModalC').classList.remove('hidden');
                        document.getElementById('miModalC').classList.add('flex');

                        document.getElementById('closeModalBtnC').addEventListener('click', function() {
                            document.getElementById('miModalC').classList.add('hidden');
                            document.getElementById('miModalC').classList.remove('flex');
                        });

                        document.getElementById('closeModalC').addEventListener('click', function() {
                            document.getElementById('miModalC').classList.add('hidden');
                            document.getElementById('miModalC').classList.remove('flex');
                        });
                    }
                });
        </script>

        <!-- Modal -->
        <div id="miModalC"
            class="hidden fixed inset-0 items-center justify-center z-50 overflow-auto bg-black bg-opacity-50">
            <div class="bg-white p-8 rounded-lg">
                <div class="modal-header flex justify-between items-center mb-4">
                    <h5 class="modal-title text-lg font-semibold">Tickets <strong>SIN ATENCIÓN</strong> </h5>
                    <div class="text-xs">* Tickets con más de <strong>3 DÍAS</strong> sin actualizar.</div>
                </div>
                <div class="modal-body">
                    <div class=" max-h-72 overflow-auto">
                        <table class="w-full text-center rounded-b-md">
                            <thead>
                                <tr>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        ID
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        ESTADO
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        ASUNTO
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        CLIENTE
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        AGENTE
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        CREADO
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        VENCE
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        PRIORIDAD
                                    </th>
                                    <th
                                        class="p-2 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 lg:table-cell dark:bg-slate-700 dark:text-gray-300 dark:border-gray-700">
                                        OPCIÓN
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticketsEnProcesoSinComentarios as $item)
                                    <tr>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->id }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            <div>
                                                {{ $item->status }}
                                            </div>
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->falla->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->cliente->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->agente->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->created_at }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->fecha_cierre }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            {{ $item->falla->prioridad->name }}
                                        </th>
                                        <th
                                            class="w-full font-medium text-sm lg:w-auto p-2 text-gray-800 text-center border border-b dark:text-gray-400  dark:border-gray-700">
                                            <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                href="{{ route('tck.ver', $item->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                    fill="currentColor"
                                                    class="w-6 h-6 text-black hover:text-gray-600 dark:text-white"
                                                    viewBox="0 0 576 512">
                                                    <path
                                                        d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                </svg>
                                                <span class="tooltiptext">Ver Más</span>
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button id="closeModalBtnC"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md mr-4">
                        Cerrar
                    </button>
                    <!-- Otros botones o acciones que desees -->
                </div>
            </div>
        </div>
    @endif
</body>

</html>
