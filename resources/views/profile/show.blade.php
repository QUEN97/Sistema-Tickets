<x-app-layout>
    @section('title', 'Perfil')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h3 class="text-xl font-bold">
                {{ __('AJUSTES DE PERFIL') }}
            </h3>
        </div>
    </x-slot>

    <div class="grid gap-8">

        @if (Auth::user()->permiso_id == 1)
        <div class="grid grid-cols-2 space-x-2">
            <div>
                @livewire('sistema.meals.meal-schedule-create')
            </div>
            <div>
                @livewire('sistema.meals.meal-asignment')
            </div>
        </div>
        @endif

        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            @livewire('profile.update-profile-information-form')
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            @livewire('profile.update-password-form')
        @endif

        {{-- @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            @livewire('profile.two-factor-authentication-form')
        @endif --}}

        @livewire('profile.logout-other-browser-sessions-form')

        {{-- @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            @livewire('profile.delete-user-form')
        @endif  --}}
    </div>
</x-app-layout>
