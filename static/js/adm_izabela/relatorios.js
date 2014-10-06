var conf = 220;

$(function(){
    /**
    * Ajax para buscar valores para gerar os gráficos
    */
    $.ajax({
        url: 'adm_izabela/ajaxGetDataGraph',
        type: 'POST',
        dataType: 'json',
        success: function(response){
            showPieChart(response);
            showDxChart(response);
            setDataValues(response);
        },
        error: function(){
            alert('Problemas na conexão! Atualize a página e tente novamente.');
        }
    });

});

/**
* Mostra gráfico de pizza de status das solicitações
* Passar os valores inteiros como parâmetro
*/
function showPieChart(data)
{
    var pieChartDataSource = [
        {category: 'Análise da foto', value: data.analise},
        {category: 'Fabricação', value: data.fabricacao},
        {category: 'Conferência', value: data.conferecia},
        {category: 'Disponível para entrega', value: data.disponivel},
        {category: 'Entregue', value: data.entregue}
    ];

    $("#pieChartContainer").dxPieChart({
        dataSource: pieChartDataSource,
        series: {
            argumentField: 'category',
            valueField: 'value',
            type: 'doughnut',
            label: { visible: true }
        },
        palette: ['#063772', '#C4141B', '#C5C5C3', '#75B5D6', '#FF7373', '#4D7AFF'],
        legend: {
            verticalAlignment: 'bottom',
            horizontalAlignment: 'center'
        },
    });
}

/**
* Mostra gráfico de barras de status das solicitações
* Passar os valores inteiros como parâmetro
*/
function showDxChart(data)
{
    var dataSource = [{ 
        state: '', 
        analise: data.analise,
        fabricacao: data.fabricacao,
        conferencia: data.conferencia,
        disponivel: data.disponivel,
        entregue: data.entregue
    }];

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
            { valueField: 'analise', name: 'Análise' },
            { valueField: 'fabricacao', name: 'Fabricação' },
            { valueField: 'conferencia', name: 'Conferência' },
            { valueField: 'disponivel', name: 'Disponível para entrega' },
            { valueField: 'entregue', name: 'Entregue' }
        ],
        legend: {
            verticalAlignment: 'bottom',
            horizontalAlignment: 'center'
        },
        palette: ['#063772', '#C4141B', '#C5C5C3', '#75B5D6', '#FF7373', '#4D7AFF']
    });
}

function setDataValues(data)
{
    $('#-analise').html(data.analise);
    $('#-fabricacao').html(data.fabricacao);
    $('#-conferencia').html(data.conferencia);
    $('#-disponivel').html(data.disponivel);
    $('#-entregue').html(data.entregue);
}