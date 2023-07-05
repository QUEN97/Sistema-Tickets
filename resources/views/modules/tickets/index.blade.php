<x-app-layout>
    @section('title', 'Tickets')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('TICKETS') }}
            </h2>
            @livewire('tickets.new-ticket')
        </div>
    </x-slot>
    @livewire('tickets.tickets')

</x-app-layout>