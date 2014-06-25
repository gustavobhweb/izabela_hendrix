<div style="margin:100px 0 0 10px">
    <div style="float:left">
        <div id="pieChartContainer" style="max-width:400px;height: 200px;"></div>
    </div>
    <div style="float:left;margin:0 0 0 10px">
        <div id="chartContainer" style="height:200px; max-width:400px;"></div>
    </div>
</div>

<script type='text/javascript'>
var producaoN = 2230;
var conferenciaN = 2332;
var finalizadoN = 3434;
var saiuN = 23;
var entregueN = 1212;
var refazerN = 1234;
var conf = 220;

var pieChartDataSource = [
    {category: 'Produção', value: producaoN},
    {category: 'Conferência', value: conferenciaN},
    {category: 'Finalizados', value: finalizadoN},
    {category: 'Saiu para entrega', value: saiuN},
    {category: 'Entregues', value: entregueN},
    {category: 'A refazer', value: refazerN}    
];
var dataSource = [
    { state: '', producao: producaoN, conferencia: conferenciaN, finalizados: finalizadoN, saiu: saiuN, entregues: entregueN, refazer: refazerN }
];

    $(function () {             
        $("#pieChartContainer").dxPieChart({
            dataSource: pieChartDataSource,
            series: {
                argumentField: 'category',
                valueField: 'value',
                type: 'doughnut',
                label: { visible: true }
            },
            palette: ['#F2CA84', '#FFA953', '#96FF73', '#75B5D6', '#FF7373', '#006699']
        });
    });
     
    $(function () {
        $("#chartContainer").dxChart({
            dataSource: dataSource,
            commonSeriesSettings: {
                argumentField: 'state',
                type: 'bar',
                label: {
                    visible: true,
                    format: "fixedPoint",
                    precision: 2
                }
            },
            series: [
                { valueField: 'producao', name: 'Produção' },
                { valueField: 'conferencia', name: 'Conferência' },
                { valueField: 'finalizados', name: 'Finalizados' },
                { valueField: 'saiu', name: 'Saiu para entrega' },
                { valueField: 'entregues', name: 'Entregues' },
                { valueField: 'refazer', name: 'Refazer' }
            ],
            legend: {
                verticalAlignment: 'bottom',
                horizontalAlignment: 'center'
            }
        });
    });
    
</script>
<?php 
    $this->script(array('globalize.min'), false);
    $this->script(array('dx.chartjs'), false);
?>