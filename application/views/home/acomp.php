<a href='<?=base_url("home/acompanhar")?>'><div class='solicsHovered'>
<div class='num' style='float:right;margin:16px 15px 0 10px'><?=$solicitacoesNum?></div>
<h1>Acompanhar minhas solicitações</h1>
</div></a><!--solics-->

<?php if (!$solicitacoes) {?>
<div class='j-alert-error' style="float:left;margin:25px 0 0 15px">
    Nenhuma solicitação foi enviada.
    <a href='<?=base_url("home/enviar_foto")?>'>
        <button class="btn-conf-iza">Enviar solicitação</button>
    </a>
</div>
<?php } else {?>
<div class='situacao-box'>

<h1>Situação</h1>
<?php if(isset($msgAlteracaoEmail)): ?>
    <div class='wm-alert'><?=$msgAlteracaoEmail?></div>
<?php endif ?>

<?php foreach ($solicitacoes as $solicitacao) {?>
<div class='situacao-inset-box'>

    <div style='float:left'>
        <div style='float:left;margin:30px 0 0 30px'>
            <div style='width:300px;height:192px;background:url(<?=base_url("static/img/frente-carteira_" . $user->tbl_modelos_cod_modelo . ".png")?>) no-repeat;float:left'>
                <img src='<?=base_url("static/imagens/" . $solicitacao->foto)?>' width='82' height='110' style='float:right;margin:12px 14px 0 0;border-radius:.3em' />
            </div>
            <img src='<?=base_url("static/img/verso-carteira_" . $user->tbl_modelos_cod_modelo . ".png")?>' width='300' height='192' style='float:left;margin:0 0 0 15px' />

            <div style='border-left:1px solid #aaaaaa;background:#0061B2;margin:0px 0 0 0;float:left;margin:0 0 0 30px;padding:20px 8px'>
                <img src='<?=base_url("static/img/alert.png")?>' style='float:left' />

                <div style='float:left;margin:0 0 0 12px;width:180px'>
                    <p style='font:12px arial;color:#ffffff'>e-mail cadastrado:</p>
                    <p style='font:12px arial;color:#ffffff;font-weight:bold'><?= !empty($solicitacao->email) ? $solicitacao->email : 'Nenhum' ?></p>
                    <div id="box-edit-mail-of-solicitation">
                        <form id="frm-email-update" method="post">
                            <input name='email' class="wm-input" id="change-mail-of-solicitation" value="<?=$solicitacao->email?>" />
                            <input type='hidden' name="solicitacao" value="<?=$solicitacao->cod_solicitacao?>" />
                            <button class='wm-btn wm-btn-blue'>&raquo;</button>
                        </form>
                    </div>
                    <p style='font:12px arial;color:#ffffff;margin:15px 0 0 0'>Todas as notificações serão enviadas para este endereço</p>
                    <p id="btn-edit-mail-of-solicitation">Editar</p>
                </div>
            </div>
        </div>
        <img src='<?=base_url("static/img/linha-tempo-" . $solicitacao->tbl_status_cod_status . ".png")?>' style='float:left;margin:30px 0 30px 39px' />
    </div>

    <div class='clear'></div>

</div><!--situacao-inset-box-->
<?php }?>

</div><!--situacao-box-->
<?php }?>

<?= $this->element('common-alert') ?>

<?php
    $this->script(['wm-modal'], false);
    $this->script(['home/acompanhar_solicitacao'], false);
    $this->style(['wm-modal'], false);
?>