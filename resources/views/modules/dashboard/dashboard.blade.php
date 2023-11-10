<x-app-layout>
    @section('title', 'Dashboard')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <x-card-greet>
                {{ $greeting }}
            </x-card-greet>

            {{-- @if ($valid->pivot->wr == 1)
                @livewire('dashboard.generate-reporte')
            @endif --}}
        </div>
    </x-slot>
    <div class="flex flex-wrap justify-center items-center gap-3 py-3">
        <div class="p-2 w-full">
            <div class="w-full">
                <div class="flex flex-wrap justify-center gap-5">
                    <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                        <!-- Status Abierto-->
                        @livewire('top-tickets.list-abiertos')
                        <!-- End Card List -->
                    </div>
                    <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                        <!-- Status En Proceso -->
                        @livewire('top-tickets.list-en-proceso')
                        <!-- End Card List -->
                    </div>
                    <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                        <!-- Status Cerrado -->
                        @livewire('top-tickets.list-cerrado')
                        <!-- End Card List -->
                    </div>
                </div>
            </div>
        </div>
        <div>
            @livewire('dashboard.dashboard-charts')
        </div>
</x-app-layout>
