<x-app-layout>
    @section('title', 'Tickets')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('TICKETS') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                @if ($pendientes > 0 && Auth::user()->permiso_id == 1)
                    <a href="{{ route('tck.abierto') }}"
                        class="rounded-md px-2 py-1 flex justify-center items-center text-white bg-gray-400">
                        Pendientes
                        <div class="mx-1 rounded-full bg-white text-black w-7 h-7 flex justify-center items-center">
                            {{ $pendientes }}
                        </div>
                    </a>
                @endif
                @if ($valid->pivot->wr == 1)
                    @livewire('tickets.new-ticket')
                @endif
            </div>
        </div>
    </x-slot>
    @livewire('tickets.tickets')
</x-app-layout>
