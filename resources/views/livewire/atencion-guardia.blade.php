<div>
    @if($showPopup)
    <div class="popup" x-data="{ isOpen: false }" x-show="isOpen" x-init=" setTimeout(() => {isOpen = true;}, 300)" x-on:show-popup.window="isOpen = true"
        x-on:hide-popup.window="isOpen = false">
        <div class="popup-content">
            <span class="close tooltip" wire:click="closePopup">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  <span class="tooltiptext">Cerrar</span>
              </span>
            <img src="{{ asset('img/logo/aviso-guardias.jpg') }}" alt="Atención Guardias" style="width: 550px">
        </div>
    </div>
@endif
</div>
