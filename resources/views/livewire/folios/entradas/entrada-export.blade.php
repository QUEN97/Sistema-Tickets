<div>
    <button wire:click='download({{$folioID}})' wire:loading.attr="disabled" aria-label="ver servicio" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
            <path d="M7 11l5 5l5 -5"></path>
            <path d="M12 4l0 12"></path>
         </svg>
        <span class="tooltiptext">Descargar historial</span>
    </button>
</div>