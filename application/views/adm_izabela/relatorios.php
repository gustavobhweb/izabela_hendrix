<div class='content-box'>
        <a href='<?=base_url("adm_izabela/")?>'>
            <div class='solicsHovered' style='width:150px;background-position:-60px 0'>
                <h1 style='margin-right:13px'>Relatórios</h1>
            </div>
        </a><!--solics-->
    <div class='clear'></div>
</div><!--content-box-->

<div style="margin:0 0 0 10px">
    <div style="float:left;margin:20px 0 0 30px">
        <div id="pieChartContainer"></div>
    </div>
    <div style="float:left;margin:40px 0 0 30px">
        <div id="chartContainer"></div>
        <dl class="dl-horizontal">
            <a href='#'>
                <dt id="-analise"></dt>
                    <dd>análise</dd>
            </a>
            <a href='#'>
                <dt id="-fabricacao"></dt>
                    <dd>fabricação</dd>
            </a>
            <a href='#'>
                <dt id="-conferencia"></dt>
                    <dd>conferência</dd>
            </a>
            <a href='#'>
                <dt id="-disponivel"></dt>
                    <dd>disponível para entrega</dd>
            </a>
            <a href='#'>
                <dt id="-entregue"></dt>
                    <dd>entregue</dd>
            </a>
        </dl>
    </div>
</div>

<?php 
    $this->script(array(
        'globalize.min',
        'dx.chartjs',
        'adm_izabela/relatorios'
    ), false);

    $this->style(array(
        'adm_izabela/relatorios'
    ), false);
?>