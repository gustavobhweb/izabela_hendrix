<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <script src="/home/js_info?varname=_INFO_"></script>
        <script>_INFO_ = _INFO_ || {};</script>
        <?php

            echo $this->script(array(
                    'jquery-1.11.0.min',
                    'jquery.mask.min',
                    'jquery.Jcrop.min',
                    'imgSelect.min',
                    'crop',
                    'jquery-ui'
                ));

            echo $this->fetch('scripts');

            echo $this->style(array(
                    'style_izabela',
                    'imgSelect',
                    'crop'
                ));

            echo $this->fetch('styles');
        ?>
        <script language="JavaScript" src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
        <script language="JavaScript" src="/static/js/scriptcam.js"></script>
        <script type="text/javascript">
        $(function(){
            var sair = 0;
            $('.minha-conta').click(function(){
                if(sair) {
                    sair = 0;
                    $('.sair-link').fadeOut();
                } else {
                    sair = 1;
                    $('.sair-link').fadeIn();
                }
            });

            if(!_INFO_.numero_solicitacoes){
                $('.contador.solicitacoes').hide();
            } else {
                $('.contador.solicitacoes').html(_INFO_.numero_solicitacoes);
            }

        });
        </script>
        <link rel="shortcut icon" type="image/png" href="/static/img/favicon.png"/>
        <title>Izabela Hendrix</title>
    </head>
    <body>

        <div class='content-box'>

            <div class='left-menu-box'>
                <a href="<?=base_url('home/inicial');?>">
                    <!-- <img class='logo-tmt-box' src='<?=base_url("static/img/logo-tmt.png")?>' width='200' /> -->
                    <img class='logo-izabela-box' src='<?=base_url("static/img/izabela.png")?>' width='200' />
                </a>
                <div style='width:220px;float:left;margin:30px 0 0 40px'>
                    <h1 style='font:22px Arial;color:#0865AE'>Olá, <?=$user->nome?>!</h1>
                    <p style='font:13px Arial;color:#777777'>Nível aluno (<?=$user->modelo?>)</p>
                    <div class='line' style='margin:10px 0 0 0'></div>
                    <div class='menu'>
                        <ul>
                            <li><a href='<?=base_url("home/inicial")?>'><img src='<?=base_url("static/img/icon-home.png")?>' /> Página inicial</a></li>
                            <li><a href='<?=base_url("home/avisos")?>'><img src='<?=base_url("static/img/icon-avisos.png")?>' /> Avisos</a></li>
                            <li><a href='<?=base_url("home/acompanhar")?>'><img src='<?=base_url("static/img/icon-acomp.png")?>' /> Acompanhar solicitações <span class="contador solicitacoes"></span></a></li>
                        </ul>
                    </div><!--menu-->
                    <img src='<?=base_url("static/img/carteira_" . $user->tbl_modelos_cod_modelo . ".png")?>' style='margin:20px 0 0 0' width='220' />
                </div>
            </div><!--left-menu-box-->

            <div class='main-content'>
                    <div class='menu-usuario' style="width: 480px;">
                    <div id="descricao-nome-curso">
                        <div><?=$user->nome?></div>
                        <?php if(!empty($user->curso)): ?>
                            <div style="font-size:15px">Curso: <?=$user->curso?></div>
                        <?php endif ?>
                    </div>

                    <div style="width:175px;float:right">
                        <a style='text-decoration:none' href='<?=base_url("home/inicial")?>'><div class='pagina-inicial'>
                            <p>Página inicial</p>
                            <img src='<?=base_url("static/img/home-blue.png")?>' />
                        </div></a>
                        <div class='minha-conta'>
                            <img src='<?=base_url("static/img/arrow-down.png")?>' class='arrow-icon' />
                            <p><?=$user->nome?></p>
                        </div><!--minha-conta-->

                        <a class='sair-link' href='<?=base_url("home/sair")?>'>
                            <span class="sair-icone"></span>
                            <span style='margin:5px'>Sair</span>
                        </a>
                    </div>
                </div><!--menu-usuario-->
                <?=$this->fetch('content')?>
            </div><!--main-content-->

            <div class='clear'></div>

        </div><!--content-box-->

        <div class='clearfix'></div>

        <div class='footer'>
            <div style='float:left;margin:30px 0 0 15px;width:330px'>
                <p style='font:13px arial;color:#888888'>Termos de Uso | Política de Privacidade</p>
                <b style='font:11px arial;color:#888888;font-weight:bold'>© 2014 GrupoTMT.com.br. Todos os direitos reservados.</b>
            </div>
            <img src='<?=base_url("static/img/footer-login.png")?>' />
            <div class='clearfix'></div>
        </div><!--footer-->

    </body>
</html>