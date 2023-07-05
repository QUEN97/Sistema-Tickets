<x-app-layout>
    @section('title', 'Tarea')
    <div class="flex flex-col sm:flex-row gap-2">
        <div class="bg-white dark:bg-dark-eval-3 text-gray-800 p-4 rounded-md shadow-lg mb-4 sm:mb-0">
            <ul class="list-style:none">
                <li class="mb-2"><strong class="dark:text-white">Ticket: </strong>
                    <span class="dark:text-white">#{{ $ticketID }}</span>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Status:</strong>
                    @if ($tck->status == 'Abierto')
                        <span class="bg-green-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'En proceso')
                        <span class="bg-orange-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @elseif ($tck->status == 'Cerrado')
                        <span class="bg-gray-400 p-1 rounded-md text-white">
                            {{ $tck->status }}
                        </span>
                    @endif
                </li>
                <li class="mb-2"><strong class="dark:text-white">Cliente:</strong>
                    <div class="dark:text-white">
                        {{ $tck->cliente->name }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Creado:</strong>
                    <div class="dark:text-white">
                        {{ $tck->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}</div>
                </li>
                <li class="mb-2"><strong class="dark:text-white">Vencimiento:</strong>
                    <div class="bg-gray-400 p-1 rounded-md text-white">
                        {{ \Carbon\Carbon::parse($tck->fecha_cierre)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                    </div>
                </li>
                @if ($tck->status == 'Cerrado' && $tck->cerrado != NULL)
                <li class="mb-2"><strong class="dark:text-white">Cerrado:</strong>
                    <div class="bg-gray-400 p-1 rounded-md text-white">
                        {{ \Carbon\Carbon::parse($tck->cerrado)->locale('es')->isoFormat('D [de] MMMM [de] YYYY H:mm:ss a') }}
                    </div>
                </li>
                @endif
            </ul>
        </div>

        <div class="ml-0 sm:ml-16">
            @livewire('tickets.tareas.new-tarea', ['ticketID' => $ticketID])
        </div>
    </div>

    <div class="mt-4 bg-white dark:bg-dark-eval-1 text-gray-800 p-4 rounded-md shadow-lg">
        <p class="dark:text-white">{{ __('Tareas') }}</p>
        <div class="bg-white dark:bg-dark-eval-0">
            <table
                class="border-collapse w-full bg-white text-center text-sm text-gray-500  dark:bg-dark-eval-0 dark:text-gray-400">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Ticket #</th>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Tarea #</th>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Asunto - Tarea</th>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell dark:bg-dark-eval-2 dark:text-gray-300 dark:border-gray-700">
                            Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tareas as $tarea)
                        <tr>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 dark:bg-dark-eval-3 dark:text-white px-1 py-1 text-xs rounded-md">Ticket
                                    #</span>
                                {{ $tarea->ticket_id }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 dark:bg-dark-eval-3 dark:text-white px-1 py-1 text-xs rounded-md">Tarea
                                    #</span>
                                {{ $tarea->id }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 dark:bg-dark-eval-3 dark:text-white px-1 py-1 text-xs rounded-md">Asunto
                                    - Tarea</span>
                                {{ $tarea->asunto }}
                            </td>
                            <td
                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                <span
                                    class="lg:hidden absolute top-0 left-0 bg-gray-300 dark:bg-dark-eval-3 dark:text-white px-1 py-1 text-xs rounded-md">Opciones</span>
                                    <div class="flex gap-2 justify-center">
                                        @livewire('tickets.tareas.edit-tarea', ['tareaID' => $tarea->id])
                                        @livewire('tickets.tareas.show-tarea', ['tareaID' => $tarea->id])
                                        @livewire('tickets.tareas.delete-tarea', ['tareaID' => $tarea->id])
                                    </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-4" colspan="4">
                                <span class="text-danger text-lg">
                                    <p style="display: flex; justify-content: center;"><img
                                            src="{{ asset('img/logo/emptystate.svg') }}" style=""
                                            alt="Buzón Vacío"></p>
                                </span>
                                Sin registros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">
            {{ $tareas->links() }}
        </div>
    </div>
</x-app-layout>
