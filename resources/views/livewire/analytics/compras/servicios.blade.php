<div  class="w-full py-2 px-3 border rounded-md bg-white dark:bg-dark-eval-1 dark:border-0 shadow-sm" 
wire:ignore x-data="{ data:@entangle('data'),labels:@entangle('labels'),
init(){
    const data = {
                labels:this.labels.map((label)=>label.split(' ')),
                datasets: [{
                    label: 'cantidad',
                    data: this.data,
                    borderColor:'rgba(240,63,63)',
                    backgroundColor:'rgba(240,63,63,0.5)',
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
              beginAtZero: true,
              ticks:{
                beginAtZero: true,
                stepSize:1,
                }
            },
            axisX:{
                labelWrap:true,
                labelMaxWidth: 100,
            }
          }
    };
   const mychart= new Chart(this.$refs.producto, config);
    Livewire.on('updateChart',() => {
        mychart.data.datasets[0].data=this.data;
        mychart.data.labels=this.labels.map((label)=>label.split(' '));
        mychart.update();
    });
}}" >
    <div class="flex flex-wrap gap-2 items-center py-2">
        <div>
            <x-label value="{{__('Seleccionar mes')}}"/>
            <x-input type="month" wire:model='mes' wire:change='updateData()'/>
        </div>
        <h2 class=" flex-auto text-center">Servicios más solicitados</h2>
    </div>
    <div class="flex justify-center items-center h-96">
        <canvas  x-ref="producto"></canvas>
    </div>
</div>
