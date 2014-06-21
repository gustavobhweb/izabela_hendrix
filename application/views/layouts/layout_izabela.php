<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <?php

            echo $this->script(array(
                    'jquery-1.10.2.min',
                    'jquery.mask.min'
                ));

            echo $this->fetch('scripts');

            echo $this->style(array(
                    'style_izabela'
                ));
            
            echo $this->fetch('styles');
        ?>
        <script type="text/javascript">
        $(document).ready(function(){
            var sair = 0;
            $('.minha-conta').click(function(){
                if(sair)
                {
                    sair = 0;
                    $('.sair-link').fadeOut();
                }
                else
                {
                    sair = 1;
                    $('.sair-link').fadeIn();
                }
            });
        });
        </script>

        <title>Izabela Hendrix</title>
    </head>
    <body>

        <div class='content-box'>

            <div class='left-menu-box'>
                <a href="<?=base_url('home/inicial');?>">
                    <img class='logo-tmt-box' src='<?=base_url("static/img/logo-tmt.png")?>' width='200' />
                </a>
                <div style='width:220px;float:left;margin:30px 0 0 40px'>
                    <h1 style='font:22px Arial;color:#0865AE'>Olá, <?=$user->nome?>!</h1>
                    <p style='font:13px Arial;color:#777777'>Nivel Aluno</p>
                    <div class='line' style='margin:10px 0 0 0'></div>
                    <div class='menu'>
                        <ul>
                            <li><a href='<?=base_url("adm_izabela")?>'><img src='<?=base_url("static/img/icon-home.png")?>' /> Página inicial</a></li>
                            <li><a href='<?=base_url("adm_izabela/pesquisar_alunos")?>'><img src='<?=base_url("static/img/icon-acomp.png")?>' /> Pesquisar Aluno</a></li>
                        </ul>
                    </div><!--menu-->
                </div>
                <img class='logo-izabela-box' src='<?=base_url("static/img/izabela.png")?>' width='200' />
            </div><!--left-menu-box-->

            <div class='main-content'>
                <?=$this->fetch('content') ?>
            </div><!--main-content-->

            <div class='clear'></div>

            <div class='menu-usuario' style="width: 480px;">
                <div id="descricao-nome-curso">
                    <div><?=$user->nome?></div>
                    <div style="font-size:15px">Curso: Analista de sistemas PHP</div>
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

        </div><!--content-box-->

        <div class='clearfix'></div>

        <div class='footer'>
            <div style='float:left;margin:30px 0 0 15px;width:330px'>
                <p style='font:13px arial;color:#ffffff'>Termos de Uso | Política de Privacidade</p>
                <b style='font:11px arial;color:#ffffff;font-weight:bold'>© 2014 GrupoTMT.com.br. Todos os direitos reservados.</b>
            </div>
            <img src='<?=base_url("static/img/footer.png")?>' />
            <div class='clearfix'></div>
        </div><!--footer-->

    </body>
</html>