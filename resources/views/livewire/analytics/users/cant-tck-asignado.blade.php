{{-- <div  class="py-2 px-3 border rounded-md bg-white dark:bg-dark-eval-1 dark:border-0 shadow-sm" 
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
</div> --}}
<div wire:ignore class="py-2 px-3 border rounded-md bg-white dark:bg-dark-eval-1 dark:border-0 shadow-sm flex items-center justify-center flex-col" 
 x-data="{ labels:@entangle('labels'),groups:@entangle('groups'),dataGroups:@entangle('dataGroups'),
    setDataChartUser(){
        var dom = document.getElementById('chart-users');
        var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
        });
        var app = {};

        var option;

        option = {
            color: ['rgba(243, 147,0, 0.7)'],
            title:{
                text:'Carga de trabajo por usuario',
                textStyle:{
                    color:'#9CA3AF'
                }
            },
            tooltip: {},
            xAxis: {
                data: this.labels,
                axisLabel: {
                    rotate: 30
                },
            },
            yAxis: {},
            dataGroupId: '',
            animationDurationUpdate: 500,
            series: {
                type: 'bar',
                barWidth: 20,
                id: 'sales',
                data: this.groups,
                universalTransition: {
                enabled: true,
                divideShape: 'clone'
                },
                itemStyle:{
                    borderRadius:10,
                    borderWidth: 2,
                    borderColor: '#F39300',
                }
            }
        };
        const drilldownData = this.dataGroups;
        myChart.on('click', function (event) {
           
        if (event.data) {
            var subData = drilldownData.find(function (data) {
            return data.dataGroupId == event.data.groupId;
            });
            console.log(event.data,subData);
            if (!subData) {
            return;
            }
            myChart.setOption({
            xAxis: {
                data: subData.data.map(function (item) {
                return item[0];
                })
            },
            series: {
                type: 'bar',
                id: 'sales',
                dataGroupId: subData.dataGroupId,
                data: subData.data.map(function (item) {
                return item[1];
                }),
                universalTransition: {
                enabled: true,
                divideShape: 'clone'
                }
            },
            graphic: [
                {
                type: 'text',
                left: 50,
                top: 33,
                style: {
                    text: 'Back',
                    fontSize: 18,
                    fill:'#9CA3AF',
                },
                onclick: function () {
                    myChart.setOption(option);
                }
                }
            ]
            });
        }
        });


        if (option && typeof option === 'object') {
        myChart.setOption(option);
        }

        window.addEventListener('resize', myChart.resize);
    },
    init(){
        this.setDataChartUser();
        Livewire.on('updateChartUser',() => {
            //console.log(this.dataGroups);
            this.setDataChartUser();
        });
    }
        
 }">
 
 <div>
    <x-label value="{{__('Seleccionar mes')}}"/>
    <x-input type="month" wire:model='mes' wire:change='updateData()'/>
</div>
 <div id="chart-users" class="w-72 md:w-[600px] lg:w-[800px] xl:w-[1000px] h-96"></div>
 <script>
    
 </script>
</div>