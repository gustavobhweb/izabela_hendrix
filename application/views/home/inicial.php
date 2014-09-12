<a href='<?=base_url("home/acompanhar")?>'>
    <div class='solics'>
        <div class='num' style='float:right;margin:16px 15px 0 10px'><?=$solicitacoesNum?></div>
            <h1>Acompanhar minhas solicitações</h1>
    </div>
</a><!--solics-->
<div style='float:left;margin:20px 0 0 20px'>

    <?php if(!empty($avisos)): ?>
        <h2 style='margin:20px 0 0 0;font:26px Arial;color:black'>Avisos</h2>

        <div style='margin:10px 0 0 0'>
            <div class='head-item' style='width:100px'>Status</div>
            <div class='head-item' style='width:180px'>Assunto</div>
            <div class='head-item' style='width:90px'>Remetente</div>
            <div class='head-item' style='width:180px'>Mensagem</div>
            <div class='head-item' style='width:150px'>Selecionar</div>
            <div class='clearG'></div>
        </div><br>

        <?php foreach($avisos as $aviso): ?>
        <a href='<?=base_url("home/aviso/".$aviso->cod_aviso)?>'><div class='item-aviso'>
            <div class='item-line-aviso' style='width:100px'>
                <?php if($aviso->lido):?>
                    <p style='font:14px arial;color:#0060B2;font-weight:bold;margin:8px 0 0 0'>Lido</p>
                <?php else:?>
                    <p style='font:14px arial;color:#0060B2;font-weight:bold;margin:8px 0 0 0'>Não lido</p>
                <?php endif;?>
                <img src='<?=base_url("static/img/msg.png")?>' />
            </div>
            <div class='item-line-aviso' style='width:180px'>
                <p style='font:14px Arial;color:black;font-weight:bold;width:180px;margin:30px 0 0 0'><?=$aviso->assunto?></p>
            </div>
            <div class='item-line-aviso' style='width:90px'>
                <p style='font:14px Arial;color:black;font-weight:bold;max-width:180px;margin:30px 0 0 0'><?=$aviso->remetente?></p>
            </div>
            <div class='item-line-aviso' style='width:180px'>
                <p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0;width:180px;font-style:italic'>
                    <?php
                        if(mb_strlen($aviso->mensagem, 'utf-8') > 30) {
                            $aviso->mensagem = substr($aviso->mensagem, 0, 30) . '...';
                        }
                    ?>
                    <?= $aviso->mensagem ?>
                </p>
            </div>
            <div class='item-line-aviso' style='border:none;width:150px'><button style='margin:24px 0 0 6px' class='btn-conf-iza'>CONTINUAR ></button></div>
            <div class='clearG'></div>
        </div></a>
        <?php endforeach;?>
    <?php endif ?>

    <h2 style='margin:40px 0 0 0;font:26px Arial;color:black'>Solicitação da carteira de identidade acadêmica</h2>

    <div style='margin:10px 0 0 0'>
        <div class='head-item' style='width:180px'>Produto</div>
        <div class='head-item' style='width:80px'>Modelo</div>
        <div class='head-item' style='width:240px'>Imagem</div>
        <div class='head-item' style='width:100px'>Situação</div>
        <div class='head-item' style='width:100px'>Selecionar</div>
        <div class='clearG'></div>
    </div><br>

        <a href='<?=base_url("home/enviar_foto")?>'><div class='item-solics'>
            <div class='item-line-aviso' style='width:180px'>
                <p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0;width:180px'>Carteira de identidade acadêmica</p>
            </div>
            <div class='item-line-aviso' style='width:80px'>
                <p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0'>Aluno</p>
            </div>
            <div class='item-line-aviso' style='width:240px'>
                <img src='<?=base_url("static/img/carteira.png")?>' style='margin:-6px 0 0 0' />
            </div>
            <div class='item-line-aviso' style='width:100px'>
                <p style='font:14px Arial;color:#0060B2;font-weight:bold;margin:30px 0 0 0;font-style:italic'>
                    <?= $solicitacoesNum ? "Solicitado" : "Liberado" ?>
                </p>
            </div>
            <div class='item-line-aviso' style='border:none' style='width:100px'><button style='margin:24px 0 0 0' class='btn-conf-iza' onclick='document.location.href="<?=base_url('home/acompanhar')?>"'>CONTINUAR ></button></div>
            <div class='clearG'></div>
        </div></a>
</div>