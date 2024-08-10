<div  class="w-full py-2 px-3 border rounded-2xl bg-white dark:bg-dark-eval-1 dark:border-0 shadow-lg" 
wire:ignore x-data="{ data:@entangle('data'),labels:@entangle('labels'),
init(){
    const data = {
                labels:this.labels,
                datasets: [{
                    label: 'TICKETS',
                    data: this.data,
                    fill:true,
                    }]
                };
    const config = {
        type: 'doughnut',
        data: data,
        options:{
            responsive: true,
            maintainAspectRatio:false,
        }
    };
   const mychart= new Chart(this.$refs.estado, config);
   
}}" >
    <div class="flex flex-wrap gap-2 items-center">
        <h2 class=" flex-auto text-center text-gray-700 dark:text-gray-400">TICKETS POR ESTADO</h2>
    </div>
    <div class="flex justify-center items-center h-96">
        <canvas  x-ref="estado"></canvas>
    </div>
</div>