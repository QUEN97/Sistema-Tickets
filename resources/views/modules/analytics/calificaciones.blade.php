<x-app-layout>
    @section('title', 'Ranking')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('RANKING DE CALIFICACIONES') }}
            </h2>
        </div>
    </x-slot>
    <div>
        @livewire('analytics.calificaciones.ranking')
    </div>
</x-app-layout>