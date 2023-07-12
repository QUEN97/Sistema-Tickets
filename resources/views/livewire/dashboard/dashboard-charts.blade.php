<div class="w-full h-full text-center flex flex-wrap justify-center items-center gap-6">

<div class="flex flex-wrap justify-center gap-5">
    <div class="bg-white rounded-xl p-4 shadow-xl">
        {!! $chartTickets->container() !!}
    </div>

    <div class="bg-white rounded-xl p-4 shadow-xl flex items-center justify-center">
        {!! $chartTicketsAsignados->container() !!}
    </div>

    <div class="bg-white rounded-xl p-4 shadow-xl">
        {!! $chartTicketsPrioridad->container() !!}
    </div>
</div>
    
    <script src="{{ $chartTickets->cdn() }}"></script>
    <script src="{{ $chartTicketsPrioridad->cdn() }}"></script>
    {{ $chartTickets->script() }}
    {{ $chartTicketsAsignados->script() }}
    {{ $chartTicketsPrioridad->script() }}
</div>