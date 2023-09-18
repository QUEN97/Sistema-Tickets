<div class="w-full h-full text-center flex flex-wrap justify-center items-center gap-6">

    <div class="flex flex-wrap justify-center gap-5">
        {{-- @auth
            @if (Auth::user()->permiso_id == 1)
                <div class="bg-white dark:bg-gray-500  rounded-xl p-4 shadow-xl">
                    {!! $chartTickets->container() !!}
                </div>

                <div class="bg-white dark:bg-gray-500 rounded-xl p-4 shadow-xl flex items-center justify-center">
                    {!! $chartTicketsAsignados->container() !!}
                </div>
                <div class="bg-white dark:bg-gray-500 rounded-xl p-4 shadow-xl flex items-center justify-center">
                    {!! $chartTicketsHora->container() !!}
                </div>
                <div class="bg-white dark:bg-gray-500 rounded-xl p-4 shadow-xl flex items-center justify-center">
                    {!! $chartTicketsDeptos->container() !!}
                </div>
                <script src="{{ $chartTicketsHora->cdn() }}"></script>
                <script src="{{ $chartTicketsDeptos->cdn() }}"></script>
                <script src="{{ $chartTickets->cdn() }}"></script>

                {{ $chartTickets->script() }}
                {{ $chartTicketsHora->script() }}
                {{ $chartTicketsDeptos->script() }}
                {{ $chartTicketsAsignados->script() }}
            @endif
        @endauth --}}

        <div class="bg-white dark:bg-gray-500 rounded-xl p-4 shadow-xl">
            {!! $chartTicketsPrioridad->container() !!}
        </div>

        <div class="bg-white dark:bg-gray-500 rounded-xl p-4 shadow-xl flex items-center justify-center">
            {!! $chartTicketsStatus->container() !!}
        </div>

    </div>


    <script src="{{ $chartTicketsPrioridad->cdn() }}"></script>




    {{ $chartTicketsPrioridad->script() }}
    {{ $chartTicketsStatus->script() }}

</div>
