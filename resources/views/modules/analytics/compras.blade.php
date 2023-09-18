<x-app-layout>
    @section('title', 'Graficas de compras')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('GRAFICAS DE REQUISICIONES') }}
            </h2>
        </div>
        <div class="mt-10 mb-2 flex flex-wrap gap-2 justify-center">
            @livewire('analytics.compras.clases')
        </div>
    </x-slot>
    {{-- script de ChartsJS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</x-app-layout>