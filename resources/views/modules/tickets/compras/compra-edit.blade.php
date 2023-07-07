<x-app-layout>
    @section('title', 'Requisiciones')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('REQUISICIÓN #').$compraID }}
            </h2>
        </div>
    </x-slot>
    <div>
        @livewire('tickets.compras.compra-edit',['compraID' => $compraID])
    </div>
</x-app-layout>