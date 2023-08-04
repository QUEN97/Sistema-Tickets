<x-app-layout>
    @section('title', 'Dashboard')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="text-xl font-semibold leading-tight bg-black text-center text-white dark:bg-dark-eval-3 p-2 rounded-lg">
                {{ $greeting }}
            </div>

            {{-- @if ($valid->pivot->wr == 1)
                @livewire('dashboard.generate-reporte')
            @endif --}}
            <div class="bg-gray-500 p-2 rounded-md font-bold text-white text-center">
                {{ __('Sistema de Atención de Tickets (Helpdesk)') }}
            </div>
        </div>
    </x-slot>
    <div class="flex flex-wrap justify-center items-center gap-3 py-3">
        <div class="p-2 w-full">
            <div class="w-full">
                <div class="flex flex-wrap justify-center gap-5">
                    <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                        <!-- Status Abierto-->
                        <div class="bg-white dark:bg-dark-eval-1 rounded-xl p-4 shadow-xl ">
                            <div class="flex flex-col justify-center items-center">
                                <img src="{{ asset('img/icons/Imagen1.png') }}" class="w-full h-40 rounded-lg" />
                            </div>
                            <p class="font-semibold text-lg mt-1 text-left"></p>
                            <p class="font-semibold text-sm text-gray-400">
                            <div class="border rounded-lg overflow-hidden">
                                <details>
                                    <summary class="bg-gray-100 dark:bg-dark-eval-2 py-2 px-4 cursor-pointer text-center">Mostrar/ocultar
                                    </summary>
                                    <table
                                        class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-white">
                                        <thead class="bg-gray-50 dark:bg-dark-eval-2">
                                            <tr>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Ticket</th>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Ir</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                            @forelse($ultimosAbiertos as $open)
                                                <tr>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800  dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                                        {{ $open->id }}
                                                    </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800  dark:text-white border border-b block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                                        <div style="display: flex; justify-content: center;">
                                                            <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                                href="{{ route('tck.ver', $open->id) }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 hover:text-blue-500">
                                                                    <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                                                                    <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
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
                        <!-- Status En Proceso -->
                        <div class="bg-white dark:bg-dark-eval-1 rounded-xl p-4 shadow-xl mt-">
                            <div class="flex flex-col justify-center items-center">
                                <img src="{{ asset('img/icons/Imagen3.png') }}" class="w-full h-40 rounded-lg" />
                            </div>
                            <p class="font-semibold text-lg mt-1 text-left"></p>
                            <p class="font-semibold text-sm text-gray-400">
                            <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                                <details>
                                    <summary class="bg-gray-100 dark:bg-dark-eval-2 py-2 px-4 ">Mostrar/ocultar
                                    </summary>
                                    <table
                                        class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-gray-400">
                                        <thead class="bg-gray-50 dark:bg-dark-eval-2">
                                            <tr>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Ticket</th>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Ir</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                            @forelse($ultimosEnProceso as $process)
                                                <tr>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                                        {{ $process->id }}
                                                    </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 dark:text-white border border-b block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                                            <div style="display: flex; justify-content: center;">
                                                                <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                                    href="{{ route('tck.ver', $process->id) }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 hover:text-blue-500">
                                                                        <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                                                                        <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
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
                        <div class="bg-white dark:bg-dark-eval-1 rounded-xl p-4 shadow-xl ">
                            <div class="flex flex-col justify-center items-center">
                                <img src="{{ asset('img/icons/Imagen2.png') }}" class="w-full h-40 rounded-lg" />
                            </div>
                            <p class="font-semibold text-lg mt-1 text-left"></p>
                            <p class="font-semibold text-sm text-gray-400">
                            <div class="border rounded-lg overflow-hidden ">
                                <details>
                                    <summary class="bg-gray-100 dark:bg-dark-eval-2 py-2 px-4 cursor-pointer text-center">Mostrar/ocultar
                                    </summary>
                                    <table
                                        class="border-collapse w-full  bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-gray-400">
                                        <thead class="bg-gray-50 dark:bg-dark-eval-2">
                                            <tr>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Ticket</th>
                                                <th
                                                    class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                                                    Ir</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                            @forelse($ultimosCerrados as $closed)
                                                <tr>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b  block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                                        {{ $closed->id }}
                                                    </td>
                                                    <td
                                                        class="w-full lg:w-auto p-3 text-gray-800 dark:text-white  border border-b block lg:table-cell relative lg:static">
                                                        <span
                                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
                                                            <div style="display: flex; justify-content: center;">
                                                                <a class="bg-white dark:bg-dark-eval-3 p-1 rounded-md tooltip"
                                                                    href="{{ route('tck.ver', $closed->id) }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 hover:text-blue-500">
                                                                        <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                                                                        <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
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
