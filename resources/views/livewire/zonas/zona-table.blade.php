<div>
    <div class="py-4 space-y-4">
        <div>
            <x-input wire:model="search" type="text" class="w-full sm:w-1/2 lg:w-1/4" placeholder="Buscar zonas..."/>
        </div>
      <div class="flex-col space-y-4">
        <x-table>
            <x-slot name="head">
                <x-heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">ID</x-heading>
                <x-heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">NOMBRE</x-heading>
                <x-heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">ESTADO</x-heading>
                <x-heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">FECHA REGISTRO</x-heading>
                <x-heading >OPCIONES</x-heading>
            </x-slot>
            <x-slot name="body">
                @forelse($zonas as $zona)
                <x-row wire:loading.class.delay="opacity-75">
                    <x-cell>{{ $zona->id }} </x-cell>
                    <x-cell>{{ $zona->name }}</x-cell>
                    <x-cell>
                        <span class="rounded bg-{{ $zona->status_color }}-200 py-1 px-3 text-xs text-{{ $zona->status_color }}-500 font-bold">
                            {{ $zona->status }}
                        </span> 
                    </x-cell>
                    <x-cell> {{ $zona->created_at->locale('es')->isoFormat('D / MMMM / YYYY H:mm:ss a') }} </x-cell>
                    <x-cell>
                        <div class="flex gap-2 justify-center items-center">
                            <div>
                                @if ($valid->pivot->ed == 1)
                                    @livewire('zonas.zona-edit', ['zona_id' => $zona->id], key('ed'.$zona->id))
                                @endif
                            </div>
                            <div>
                                @if ($valid->pivot->vermas == 1)
                                    @livewire('zonas.show-zona', ['zona_show_id' => $zona->id], key('show'.$zona->id))
                                @endif
                            </div>
                            <div>
                                @if ($valid->pivot->de == 1)
                                    @livewire('zonas.zona-delete', ['zonaID' => $zona->id], key('del'.$zona->id))
                                @endif
                            </div>
                        </div>
                    </x-cell>
                </x-row>
                @empty
                <x-row>
                    <x-cell colspan="5">
                        <div class="flex justify-center items-center space-x-2">
                            <x-icons.inbox class="w-8 h-8 text-gray-300"/>
                            <span class="py-8 font-medium text-gray-400 text-xl">No se encontraron resultados...</span>
                        </div>
                    </x-cell>
                </x-row>
                @endforelse
            </x-slot>
        </x-table>
        <div class="py-4 px-3">
            <div class="flex space-x-4 items-center mb3">
                <x-label class="text-sm font-medium text-gray-600">Mostrar</x-label>
                <select wire:model.live="perPage" class="bg-gray-50 border border-gray-300 text-gray-400 text-sm rounded-lg focus:ring-indigo-500">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            {{ $zonas->links() }}
        </div>
      </div>
    </div>
</div>
