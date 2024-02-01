<div>
    <div class="py-4 space-y-4">
        {{-- Filtros --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- Barra de Busqueda --}}
            <div>
                <x-input wire:model="search" type="text" class="w-auto" placeholder="Buscar correos..." />
            </div>
            {{-- Filtro de Fechas --}}
            <div class="flex items-center">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input type="date" name="start" id="from_date" wire:model="from_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <span class="mx-4 text-gray-500">a</span>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input type="date" name="end" id="to_date" wire:model="to_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <button wire:click="clearDateFilters" class="mx-4 text-gray-500">x</button>
            </div>
        </div>

        <div class="flex-col space-y-4">
            {{-- Componente tabla --}}
            <x-table>
                <x-slot name="head">
                    {{-- Componente Heading  --}}
                    <x-heading>TIPO COMPRA</x-heading>
                    <x-heading>CORREOS ASIGNADOS</x-heading>
                    <x-heading>OPCIONES</x-heading>
                </x-slot>
                <x-slot name="body">
                    @if ($correos->count() > 0)
                        @forelse($categorias as $mail)
                            {{-- Componente Row --}}
                            <x-row wire:loading.class.delay="opacity-75">
                                {{-- Componente Column --}}
                                <x-cell>{{ $mail->name }}</x-cell>
                                <x-cell> {{ $mail->correos->count() }}
                                </x-cell>
                                <x-cell>
                                    <div class="flex gap-2 justify-center items-center">
                                        @if ($valid->pivot->vermas == 1)
                                            @livewire('correos.asignados.show-asignados', ['categoriaID' => $mail->id], key('show' . $mail->id))
                                        @endif
                                        @if ($mail->correos->count() > 0)
                                            @if ($valid->pivot->ed == 1)
                                                @livewire('correos.asignados.edit-asignacion', ['categoriaID' => $mail->id], key('edit' . $mail->id))
                                            @endif
                                        @endif
                                    </div>
                                </x-cell>
                            </x-row>
                        @empty
                            <x-row>
                                <x-cell colspan="6">
                                    <div class="flex justify-center items-center space-x-2">
                                        <x-icons.inbox class="w-8 h-8 text-gray-300" />
                                        <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron
                                            resultados...</span>
                                    </div>
                                </x-cell>
                            </x-row>
                        @endforelse
                    @endif
                    @if ($servs)
                        <x-row wire:loading.class.delay="opacity-75">
                            <x-cell>SERVICIOS</x-cell>
                            <x-cell>{{ $servs }}</x-cell>
                            <x-cell>
                                <div class="flex gap-2 justify-center items-center">
                                    @if ($valid->pivot->vermas == 1)
                                        @livewire('correos.asignados.show-correos-servicio', key('Servicios'))
                                    @endif
                                    @if ($valid->pivot->ed == 1)
                                        @livewire('correos.asignados.edit-correos-servicio', key('EditarServicios'))
                                    @endif
                                </div>
                            </x-cell>
                        </x-row>
                    @endif

                </x-slot>
            </x-table>
            {{-- Paginación y contenido por página --}}
            <div class="py-4 px-3">
                <div class="flex space-x-4 items-center mb3">
                    <x-label class="text-sm font-medium text-gray-600">Mostrar</x-label>
                    <select wire:model.live="perPage"
                        class="bg-gray-50 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
</div>
