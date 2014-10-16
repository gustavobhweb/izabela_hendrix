<a href='<?=base_url("adm_izabela/carga_aluno")?>'>
    <div class='solicsHovered'>
        <h1>Cargas enviadas</h1>
    </div>
</a><!--solics-->

<?php if (!count($remessas)) {?>
<div class='j-alert-error' style='float:left;margin:20px'>Nenhuma remessa encontrada!</div>
<?php } else {?>
<div id='jtable' class='jtable' style="float:left;margin:20px 0 0 20px;width:95%">
    <div data-section='header'>
        <p>Resgistro por página: <select id="slc-limit">
            <option data-limit='5' value='<?=$paginate->changeQueryString("limit", 5)?>'>5</option>
            <option data-limit='10' value='<?=$paginate->changeQueryString("limit", 10)?>'>10</option>
            <option data-limit='20' value='<?=$paginate->changeQueryString("limit", 20)?>'>20</option>
            <option data-limit='30' value='<?=$paginate->changeQueryString("limit", 30)?>'>30</option>
            <option data-limit='40' value='<?=$paginate->changeQueryString("limit", 40)?>'>40</option>
            <option data-limit='50' value='<?=$paginate->changeQueryString("limit", 50)?>'>50</option>
            <option data-limit='60' value='<?=$paginate->changeQueryString("limit", 60)?>'>60</option>
        </select></p>
        <div style="clear:both"></div>
    </div><!-- header -->
    <table>
        <thead>
            <tr>
                <th>Remessa</th>
                <th>Data/Hora</th>
                <th>Quantidade de registros</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($remessas as $remessa) {?>
            <tr>
                <td><?=$remessa->remessa?></td>
                <td><?=$remessa->dataRemessa?></td>
                <td><?=$remessa->count?></td>
                <td>
                    <a href='<?=base_url("adm_izabela/pesquisar_alunos?voltar=true&filtro=remessa&valor=" . $remessa->remessa)?>'>
                        <button data-id="<?=$remessa->remessa?>" class='wm-btn wm-btn-blue btn-mais-info'>
                            <i class='glyphicon glyphicon-plus'></i>
                        </button>
                    </a>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
    <?=$paginateMake?>
</div><!-- .jtable -->
<?php }?>

<?= $this->element('common-alert') ?>
<?php 
    $this->style(array(
        'jquery-ui',
        'wm-modal',
        'jtable'
    ), false);
    $this->script([
        'jquery-ui',
        'wm-modal',
        'upload/index',
        'jtable'
    ], false);

?>