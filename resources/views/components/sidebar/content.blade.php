@php
    $valid = Auth::user()->permiso->panels;
    
    $modul = 'hidden';
    
    $produc = 'hidden';
    
    $sistem = 'hidden';
    
    $tck = 'hidden';
    
    foreach ($valid as $permis) {
        for ($i = 4; $i <= 7; $i++) {
            if ($permis->pivot->re == 1 && $permis->pivot->panel_id == $i) {
                $modul = 'block';
            }
        }
    
        for ($i = 8; $i <= 9; $i++) {
            if ($permis->pivot->re == 1 && $permis->pivot->panel_id == $i) {
                $produc = 'block';
            }
        }
    }
@endphp
<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
              </svg>
        </x-slot>
    </x-sidebar.link>

    {{-- Tickets --}}
    <div class="{{ $modul }}">
        <x-sidebar.dropdown title="Tickets" :active="Str::startsWith(
            request()
                ->route()
                ->uri(),
            'buttons',
        )">
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                </svg>
            </x-slot>

            <x-sidebar.sublink title="Listado" href="{{ route('tickets') }}" :active="request()->routeIs('tickets')" />
            <x-sidebar.sublink title="Tareas" href="{{ route('tareas') }}" :active="request()->routeIs('tareas')" />
            <x-sidebar.sublink title="Fallas" href="{{ route('fallas') }}" :active="request()->routeIs('fallas')" />
            <x-sidebar.sublink title="Servicios" href="{{ route('servicios') }}" :active="request()->routeIs('servicios')" />
            <x-sidebar.sublink title="Prioridades" href="{{ route('prioridades') }}" :active="request()->routeIs('prioridades')" />
            <x-sidebar.sublink title="Tipos" href="{{ route('tipos') }}" :active="request()->routeIs('tipos')" />
        </x-sidebar.dropdown>
    </div>

    {{-- Productos --}}
    <div class="{{ $produc }}">
        <x-sidebar.dropdown title="Compras" :active="Str::startsWith(
            request()
                ->route()
                ->uri(),
            'buttons',
        )">
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                  </svg>
                {{-- <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> --}}
            </x-slot>
            @foreach ($valid as $item)
                @if ($item->pivot->panel_id == 8 && $item->pivot->re == 1)
                <x-sidebar.sublink title="Requisiciones" href="{{ route('requisiciones') }}" :active="request()->routeIs('requisiciones')"/>
                @endif
                @if ($item->pivot->panel_id == 9 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Categorías" href="{{ route('categorias') }}" :active="request()->routeIs('categorias')" />
                @endif
                @if ($item->pivot->panel_id == 8 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Marcas" href="{{ route('marcas') }}" :active="request()->routeIs('marcas')" />
                @endif
                @if ($item->pivot->panel_id == 8 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Productos" href="{{ route('productos') }}" :active="request()->routeIs('productos')" />
                @endif
            @endforeach
        </x-sidebar.dropdown>
    </div>

     {{-- Almácenes --}}
     <x-sidebar.link title="Almácenes" href="#" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
              </svg>
              
        </x-slot>
    </x-sidebar.link>

    {{-- Modúlos --}}
    <div class="{{ $modul }}">
        <x-sidebar.dropdown title="Ajustes" :active="Str::startsWith(
            request()
                ->route()
                ->uri(),
            'buttons',
        )">
            <x-slot name="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </x-slot>

            @foreach ($valid as $item)
                @if ($item->pivot->panel_id == 4 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Regiones" href="{{ route('regiones') }}" :active="request()->routeIs('regiones')" />
                @endif
                @if ($item->pivot->panel_id == 4 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Departamentos" href="{{ route('departamentos') }}" :active="request()->routeIs('departamentos')" />
                @endif
                @if ($item->pivot->panel_id == 4 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Áreas" href="{{ route('areas') }}" :active="request()->routeIs('areas')" />
                @endif
                @if ($item->pivot->panel_id == 4 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Usuarios" href="{{ route('users') }}" :active="request()->routeIs('users')" />
                @endif
                @if ($item->pivot->panel_id == 5 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Roles" href="{{ route('roles') }}" :active="request()->routeIs('roles')" />
                @endif
                @if ($item->pivot->panel_id == 6 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Zonas" href="{{ route('zonas') }}" :active="request()->routeIs('zonas')" />
                @endif
                @if ($item->pivot->panel_id == 7 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Estaciones" href="{{ route('estaciones') }}" :active="request()->routeIs('estaciones')" />
                @endif
            @endforeach
        </x-sidebar.dropdown>
    </div>

    {{-- Sistema --}}
    <x-sidebar.dropdown title="Sistema" :active="Str::startsWith(request() ->route()->uri(), 'buttons',)">
        <x-slot name="icon">
            {{-- <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> --}}
            <svg class="flex-shrink-0 w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25">
                </path>
            </svg>
        </x-slot>

        @foreach ($valid as $item)
            @if ($item->pivot->panel_id == 10 && $item->pivot->re == 1)
                <x-sidebar.sublink title="Manuales" href="{{ route('manuales') }}" :active="request()->routeIs('manuales')" />
            @endif
        @endforeach
        <x-sidebar.sublink title="Versiones" href="{{ route('versiones') }}" :active="request()->routeIs('versiones')" />

    </x-sidebar.dropdown>

</x-perfect-scrollbar>
