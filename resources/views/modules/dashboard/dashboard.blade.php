<x-app-layout>
    @section('title', 'Dashboard')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight bg-black text-white dark:bg-dark-eval-3 p-2 rounded-lg">
                {{ $greeting }}
            </h2>

            @if ($valid->pivot->wr == 1)
                @livewire('dashboard.generate-reporte')
            @endif
        </div>
    </x-slot>
    <div class="flex flex-wrap justify-center items-center gap-3 py-3">
        <div class="p-2 w-full">
            <div class="w-full">
                <div class="flex flex-wrap justify-center gap-5">
                    <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                        <!-- Status Abierto-->
                        <div class="bg-white rounded-xl p-4 shadow-xl ">
                            <div class="flex flex-col justify-center items-center">
                                <img src="{{ asset('img/icons/Imagen1.png') }}" class="w-full h-40 rounded-lg" />
                            </div>
                            <p class="font-semibold text-lg mt-1 text-left"></p>
                            <p class="font-semibold text-sm text-gray-400">
                            <div class="border rounded-lg overflow-hidden">
                                <details>
                                    <summary class="bg-gray-100 py-2 px-4 cursor-pointer text-center">Mostrar/ocultar
                                    </summary>
                                    <table
                                        class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-gray-400">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Id</th>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                            @forelse($ultimosAbiertos as $open)
                                                <tr>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                                        {{ $open->id }}
                                                    </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800  border border-b block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                                        <div style="display: flex; justify-content: center;">
                                                            <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                                href="{{ route('tck.ver', $open->id) }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                                    height="15" fill="currentColor"
                                                                    class="w-6 h-6 text-gray-400 hover:text-purple-600 dark:text-white"
                                                                    viewBox="0 0 576 512">
                                                                    <path
                                                                        d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                                </svg>
                                                                <span class="tooltiptext">Ver Más</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static"
                                                        colspan="6">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Sin
                                                            registros</span>
                                                        {{ __('No hay tickets Abiertos') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </details>
                            </div>
                            </p>
                            <div class="flex justify-center items-center mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>
                                <p class="font-semibold text-sm text-gray-400">{{ $mesEnCurso }}</p>
                            </div>
                        </div>
                        <!-- End Card List -->
                    </div>
                    <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                        <!-- Start Card List -->
                        <div class="bg-white rounded-xl p-4 shadow-xl mt-">
                            <div class="flex flex-col justify-center items-center">
                                <img src="{{ asset('img/icons/Imagen3.png') }}" class="w-full h-40 rounded-lg" />
                            </div>
                            <p class="font-semibold text-lg mt-1 text-left"></p>
                            <p class="font-semibold text-sm text-gray-400">
                            <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                                <details>
                                    <summary class="bg-gray-100 py-2 px-4 ">Mostrar/ocultar
                                    </summary>
                                    <table
                                        class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-gray-400">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Id</th>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                            @forelse($ultimosEnProceso as $process)
                                                <tr>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                                        {{ $process->id }}
                                                    </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800  border border-b block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                                            <div style="display: flex; justify-content: center;">
                                                                <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                                    href="{{ route('tck.ver', $process->id) }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                                        height="15" fill="currentColor"
                                                                        class="w-6 h-6 text-gray-400 hover:text-purple-600 dark:text-white"
                                                                        viewBox="0 0 576 512">
                                                                        <path
                                                                            d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                                    </svg>
                                                                    <span class="tooltiptext">Ver Más</span>
                                                                </a>
                                                            </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static"
                                                        colspan="6">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Sin
                                                            registros</span>
                                                        {{ __('No hay tickets En Proceso') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </details>
                            </div>
                            </p>
                            <div class="flex justify-center items-center mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>
                                <p class="font-semibold text-sm text-gray-400">{{ $mesEnCurso }}</p>
                            </div>
                        </div>
                        <!-- End Card List -->
                    </div>
                    <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                        <!-- Start Card List -->
                        <div class="bg-white rounded-xl p-4 shadow-xl ">
                            <div class="flex flex-col justify-center items-center">
                                <img src="{{ asset('img/icons/Imagen2.png') }}" class="w-full h-40 rounded-lg" />
                            </div>
                            <p class="font-semibold text-lg mt-1 text-left"></p>
                            <p class="font-semibold text-sm text-gray-400">
                            <div class="border rounded-lg overflow-hidden ">
                                <details>
                                    <summary class="bg-gray-100 py-2 px-4 cursor-pointer text-center">Mostrar/ocultar
                                    </summary>
                                    <table
                                        class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-gray-400">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Id</th>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                            @forelse($ultimosCerrados as $closed)
                                                <tr>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                                        {{ $closed->id }}
                                                    </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800  border border-b block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                                            <div style="display: flex; justify-content: center;">
                                                                <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                                    href="{{ route('tck.ver', $closed->id) }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                                        height="15" fill="currentColor"
                                                                        class="w-6 h-6 text-gray-400 hover:text-purple-600 dark:text-white"
                                                                        viewBox="0 0 576 512">
                                                                        <path
                                                                            d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                                                                    </svg>
                                                                    <span class="tooltiptext">Ver Más</span>
                                                                </a>
                                                            </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static"
                                                        colspan="6">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Sin
                                                            registros</span>
                                                        {{ __('No hay tickets Cerrados') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </details>
                            </div>
                            </p>
                            <div class="flex justify-center items-center mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>
                                <p class="font-semibold text-sm text-gray-400">{{ $mesEnCurso }}</p>
                            </div>
                        </div>
                        <!-- End Card List -->
                    </div>
                </div>
            </div>
        </div>
        <div>
            @livewire('dashboard.dashboard-charts')
        </div>
    </div>
</x-app-layout>
