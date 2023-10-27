<x-app-layout>
    @section('title', 'Folios de Salida')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('SALIDA #').$id }}
            </h2>
        </div>
        <div>
         @livewire('folios.salida.edit-salida',['salidaID'=>$id])
        </div>
    </x-slot>
</x-app-layout>