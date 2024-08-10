<div wire:ignore class="py-2 px-3 border rounded-md bg-white dark:bg-dark-eval-1 dark:border-0 shadow-sm flex items-center justify-center flex-col" 
 x-data="{ labels:@entangle('labels'),groups:@entangle('groups'),dataGroups:@entangle('dataGroups'),
    setDataChart(){
        var dom = document.getElementById('chart-container');
        var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
        });
        var app = {};

        var option;

        option = {
            color: ['rgba(243, 147,0, 0.7)'],
            title:{
                text:'Tickets por zona',
                textStyle:{
                    color:'#9CA3AF'
                }
            },
        tooltip: {},
        xAxis: {
            data: this.labels
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
            return data.dataGroupId === event.data.groupId;
            });
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
        this.setDataChart();
        Livewire.on('updateChart',() => {
            console.log(this.dataGroups);
            this.setDataChart();
        });
    }
        
 }">
 
 <div>
    <x-label value="{{__('Seleccionar mes')}}"/>
    <x-input type="month" wire:model='mes' wire:change='updateData()'/>
</div>
 <div id="chart-container" class="w-72 md:w-[600px] lg:w-[800px] xl:w-[1000px] h-96"></div>
 <script>
    
 </script>
</div>