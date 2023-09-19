<x-app-layout>
    @section('title', 'Horarios')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('HORARIOS') }}
            </h2>
        </div>
    </x-slot>
    <div class="flex flex-wrap justify-center items-center gap-3 pb-3">
        <div class="p-2 w-full">
            <div class="w-full">
                <div class="flex flex-wrap justify-center gap-5">
                    @if (Auth::user()->permiso_id == 1)
                    <div class="w-full flex flex-col gap-5 bg-white rounded-md p-4 shadow-md dark:shadow-none dark:bg-dark-eval-1">
                        <h1 class="text-center text-2xl font-bold border-b pb-2 mb-1 dark:border-gray-600">{{__('Comidas')}}</h1>
                        @livewire('sistema.meals.meal-schedule-create')
                        <hr class="dark:border-gray-600">
                        @livewire('sistema.meals.meal-asignment')
                    </div>
                    <div class="w-full flex flex-col gap-5 bg-white rounded-md p-4 shadow-md dark:shadow-none dark:bg-dark-eval-1">
                        <h1 class="text-center text-2xl font-bold border-b pb-2 mb-1 dark:border-gray-600">{{__('Días no laborales')}}</h1>
                        @livewire('sistema.holiday.holiday-component')
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
   {{--  @livewire('usuarios.guardias.edit-orden') --}}
    
</x-app-layout>
