<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon/faviconnew.png') }}" type="image/x-icon">

    <title> Fullgas - @yield('title') </title>

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
    {{-- <script type="text/javascript">
        $(document).ready(function () {
            //Deshabilitar click derecho mouse
            $("body").on("contextmenu",function(e){
                return false;
            });
        });
        </script>  --}}
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
                        <div class="px-4 py-6 mx-auto max-w-7xl w-full sm:px-6 lg:px-8 bg-white dark:bg-dark-eval-1 overflow-visible">
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

    @stack('scripts')

    {{-- Toast --}}
    <script src="{{ asset('js/toast.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    @if ($cantidadTicketsProximosVencer > 0)
        <script type="text/javascript">
            toastr.warning("EXISTEN {{ $cantidadTicketsProximosVencer }} TICKETS PRÓXIMOS  A VENCER")
        </script>
    @endif


</body>

</html>
