<div class="py-2 px-3 border rounded-md bg-white dark:bg-dark-eval-1 dark:border-0 shadow-sm" 
    wire:ignore x-data="{ data:@entangle('data'),labels:@entangle('labels'),
    init(){
            const data = {
                        labels:this.labels,
                        datasets: [{
                            label: 'tickets',
                            data: this.data,
                            fill:true,
                            }]
                        };
            const config = {
                type: 'bar',
                data: data,
                options:{
                    responsive: true,
                    maintainAspectRatio:false,
                    scales:{
                        y:{
                            ticks:{
                                stepSize:1,
                            }
                        }
                    },
                }
            };
           const mychart= new Chart(this.$refs.canvas, config);
           console.log(mychart);
            Livewire.on('updateChart',() => {
                mychart.data.datasets[0].data=this.data;
                mychart.data.labels=this.labels;
                mychart.update();
            });
    }
}">
    <div class="flex flex-wrap gap-2 items-center">
        <div>
            <x-label value="{{__('Seleccionar mes')}}"/>
            <x-input type="month" wire:model='mes' wire:change='change()' {{-- @change="selectMonth(event)" --}}/>
        </div>
        <h2 class=" flex-auto text-center">Cantidad de tickets por categoría</h2>
    </div>
    <div class=" h-96">
        <canvas id="myChart" x-ref="canvas"></canvas>
    </div>
</div>
