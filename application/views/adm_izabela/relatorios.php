<div class='content-box'>
        <a href='<?=base_url("adm_izabela/")?>'>
            <div class='solicsHovered'>
                <h1>Relatórios</h1>
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
            <a href='<?=base_url("adm_izabela/relatorio/?status=1")?>'>
                <dt id="-analise"></dt>
                    <dd>análise</dd>
            </a>
            <a href='<?=base_url("adm_izabela/relatorio/?status=2")?>'>
                <dt id="-fabricacao"></dt>
                    <dd>fabricação</dd>
            </a>
            <a href='<?=base_url("adm_izabela/relatorio/?status=3")?>'>
                <dt id="-conferencia"></dt>
                    <dd>conferência</dd>
            </a>
            <a href='<?=base_url("adm_izabela/relatorio/?status=4")?>'>
                <dt id="-disponivel"></dt>
                    <dd>disponível para entrega</dd>
            </a>
            <a href='<?=base_url("adm_izabela/relatorio/?status=5")?>'>
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