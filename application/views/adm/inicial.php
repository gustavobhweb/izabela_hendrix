<div style='margin:10px 10px'>
    <?php foreach($fotos as $foto): ?>  
        <div class='item-aviso' style='background:url(<?=base_url("static/img/linear-table-3.png")?>);height:125px'>
            <div class='item-line-aviso' style='border:none;width:100px'><img src='<?=base_url("static/imagens/".$foto->foto)?>' width='76' height='100' /></div>
            <div class='item-line-aviso' style='border:none;width:100px'><button style='margin:24px 0 0 6px' class='btn-cancel-iza bt-n' data-id='<?=$foto->cod_solicitacao?>' data-pessoa='<?=$foto->tbl_usuarios_cod_usuario?>'>REPROVAR</button></div>
            <div class='item-line-aviso' style='border:none;width:100px'><button style='margin:24px 0 0 6px' class='btn-conf-iza bt-y' data-id='<?=$foto->cod_solicitacao?>' data-pessoa='<?=$foto->tbl_usuarios_cod_usuario?>'>APROVAR</button></div>
            <div class='clearG'></div>
        </div>
    <?php endforeach ?>
</div>