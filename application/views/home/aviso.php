<div style='float:left;margin:20px 0 0 20px;width:90%'>
    <a href='<?=base_url('home/avisos')?>'><button class='btn-conf-iza' style='float:left'>Voltar</button></a>
    <div class='aviso'>
        <div class='aviso-assunto'>
            <?=$aviso->assunto?>
        </div><!--aviso-assunto-->
        <div class='aviso-remetente'>
            <?=$aviso->remetente?>
        </div><!--aviso-remetente-->
        <div class='aviso-msg'>
            <?=$aviso->mensagem?>
        </div><!--aviso-msg-->
        <div class='clear'></div>
    </div><!--aviso-->
</div>