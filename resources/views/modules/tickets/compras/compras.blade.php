<x-app-layout>
    @section('title', 'Requisicion')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Nueva requisición para el ticket #').$ticketID }}
            </h2>
        </div>
    </x-slot>
    <div>
        @livewire('tickets.compras.new-compra',['ticketID' => $ticketID])
    </div>
</x-app-layout>