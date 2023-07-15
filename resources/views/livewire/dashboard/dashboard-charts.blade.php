<div class="w-full h-full text-center flex flex-wrap justify-center items-center gap-6">

    <div class="flex flex-wrap justify-center gap-5">
        @if (Auth::user()->permiso_id == 1)
            <div class="bg-white dark:bg-dark-eval-1 rounded-xl p-4 shadow-xl">
                {!! $chartTickets->container() !!}
            </div>

            <div class="bg-white dark:bg-dark-eval-1 rounded-xl p-4 shadow-xl flex items-center justify-center">
                {!! $chartTicketsAsignados->container() !!}
            </div>
        @endif

        <div class="bg-white dark:bg-dark-eval-1 rounded-xl p-4 shadow-xl">
            {!! $chartTicketsPrioridad->container() !!}
        </div>

        <div class="bg-white dark:bg-dark-eval-1 rounded-xl p-4 shadow-xl flex items-center justify-center">
            {!! $chartTicketsStatus->container() !!}
        </div>
    </div>

    <script src="{{ $chartTickets->cdn() }}"></script>
    <script src="{{ $chartTicketsPrioridad->cdn() }}"></script>
    {{ $chartTickets->script() }}
    {{ $chartTicketsAsignados->script() }}
    {{ $chartTicketsPrioridad->script() }}
    {{ $chartTicketsStatus->script() }}
</div>
