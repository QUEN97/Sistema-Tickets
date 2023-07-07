<div>
    @if ($status=="Solicitado")
        <button type="button" wire:click="aprobar({{$compraID}})" class="tooltip">
             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-check h-6 w-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                <path d="M9 14l2 2l4 -4"></path>
             </svg>
             <span class="tooltiptext">Aprobar</span>
        </button>
    @endif
    @if ($status == "Aprobado")
        <button type="button" wire:click="enviar({{$compraID}})" class="tooltip">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-forward h-6 w-6 text-gray-400 hover:text-indigo-500 transition duration-300"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5"></path>
                <path d="M3 6l9 6l9 -6"></path>
                <path d="M15 18h6"></path>
                <path d="M18 15l3 3l-3 3"></path>
            </svg>
            <span class="tooltiptext">Enviar a compras</span>
        </button>
    @endif
    @if ($status == "Enviado a compras")
    <button type="button" wire:click="finish({{$compraID}})" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-flag h-6 w-6 text-gray-400 hover:text-indigo-500 transition duration-300"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 5a5 5 0 0 1 7 0a5 5 0 0 0 7 0v9a5 5 0 0 1 -7 0a5 5 0 0 0 -7 0v-9z"></path>
            <path d="M5 21v-7"></path>
         </svg>
        <span class="tooltiptext">Completar</span>
    </button>
    @endif
</div>
