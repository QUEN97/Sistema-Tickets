<x-app-layout>
    @section('title', 'Horarios')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('HORARIOS') }}
            </h2>
        </div>
    </x-slot>
    <div class="flex flex-wrap justify-center items-center gap-3 py-3">
        <div class="p-2 w-full">
            <div class="w-full">
                <div class="flex flex-wrap justify-center gap-5">
                    @if (Auth::user()->permiso_id == 1)
                        <div>
                            @livewire('sistema.meals.meal-schedule-create')
                        </div>
                        <div>
                            @livewire('sistema.meals.meal-asignment')
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex flex-wrap justify-center gap-5">
            <div>
                @livewire('sistema.holiday.holiday-component')
            </div>
            <div>
                <x-action-section>
                    <x-slot name="title">
                        {{ __('Guardias') }}
                    </x-slot>
                    <x-slot name="description">
                    </x-slot>
                    <x-slot name="content">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                @livewire('usuarios.guardias.new-user-guardia')
                            </div>
                            <div>
                                @livewire('usuarios.guardias.edit-orden')
                            </div>
                        </div>
                    </x-slot>
                </x-action-section>
            </div>
        </div>
    </div>
</x-app-layout>
