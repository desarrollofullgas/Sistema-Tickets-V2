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
                    borderColor:'rgba(240,63,63)',
                    backgroundColor:'rgba(240,63,63,0.3)',
                    }]
                };
    const config = {
        type: 'line',
        data: data,
        options:{
            responsive: true,
            maintainAspectRatio:false,
        },
        scales:{
            y:{
                ticks:{
                    beginAtZero: true,
                    stepSize:1,
                }
            }
        }
    };
   const mychart= new Chart(this.$refs.fallas, config);
   console.log(mychart);
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
        <h2 class=" flex-auto text-center">Cantidad de tickets por falla</h2>
    </div>
    <div class="flex justify-center items-center h-96">
        <canvas  x-ref="fallas"></canvas>
    </div>
</div>
