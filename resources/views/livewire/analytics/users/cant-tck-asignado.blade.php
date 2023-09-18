<div  class="py-2 px-3 border rounded-md bg-white dark:bg-dark-eval-1 dark:border-0 shadow-sm" 
wire:ignore x-data="{ data:@entangle('data'),labels:@entangle('labels'),
init(){
    const data = {
                labels:this.labels,
                datasets: [{
                    label: 'tickets',
                    data: this.data,
                    fill:true,
                    tension: 0.2,
                    backgroundColor:'rgba(240,154,63,0.5)',
                    borderColor:'rgba(240,154,63,1)',
                    borderWidth:2,
                    }]
                };
    const config = {
        type: 'bar',
        data: data,
        options:{
            responsive: true,
            maintainAspectRatio:false,
        },
        scales: {
            y: {
              beginAtZero: true
            }
          }
    };
   const mychart= new Chart(this.$refs.carga, config);
    Livewire.on('updateChart',() => {
        mychart.data.datasets[0].data=this.data;
        mychart.data.labels=this.labels;
        mychart.update();
    });
}}" >
    <div class="flex flex-wrap gap-2 items-center">
        <div>
            <x-label value="{{__('Seleccionar mes')}}"/>
            <x-input type="month" wire:model='mes' wire:change='updateData()'/>
        </div>
        <h2 class=" flex-auto text-center">Carga de trabajo por usuario</h2>
    </div>
    <div class="flex justify-center items-center h-96">
        <canvas  x-ref="carga"></canvas>
    </div>
</div>
