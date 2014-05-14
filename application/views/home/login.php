<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <script type="text/javascript" src="<?=base_url('static/bootstrap/js/jquery-1.10.2.min.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('static/bootstrap/js/jquery.mask.min.js');?>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#txt_cpf").mask("999.999.999-99");
            });
        </script>
        <link rel="stylesheet" type="text/css" href="<?=base_url('static/bootstrap/css/style_izabela.css');?>" />
        <title>Izabela Hendrix</title>
    </head>
    <body>
        <div class='login'>
            
            <div class='header-login'>
                <img class='logo-izabela' src='<?=base_url("static/img/izabela.png")?>' />
                <img class='logo-tmt' src='<?=base_url("static/img/logo-tmt.png")?>' width='200' />
                <div class='clear'></div>
            </div><!--header-login-->

            <div class='body-login'>
                <h1>Seja bem vindo ao sistema web</h1>
                <h5>Para acessar sua conta digite no campo abaixo o seu CPF e matrícula.</h5>

                <div class='login-box'>
                    <form method='post' style='width:385px;float:left;margin:0 0 0 25px'>
                        <p>CPF</p>
                        <input type='text' id='txt_cpf' name='txt_cpf' />
                        <p style='float:left;width:100%;margin:10px 0 0 0'>Matrícula</p>
                        <input type='text' id='txt_matricula' name='txt_matricula' />
                        <button class='btn-login' type='submit'>CONTINUAR ></button>
                        <h5 style='float:left;width:auto;text-align:left;margin:7px 0 0 0'><input type='checkbox' name='ckb_manter' /> Mantenha-me conectado</h5>
                    </form>
                    <div class='clear'></div>
                </div><!--login-box-->

            </div><!--body-login-->

            <div class='footer-login'>
                <div style='float:left;margin:50px 0 0 15px;width:330px'>
                    <p style='font:13px arial;color:#ffffff'>Termos de Uso | Política de Privacidade</p>
                    <b style='font:11px arial;color:#ffffff;font-weight:bold'>© 2014 GrupoTMT.com.br. Todos os direitos reservados.</b>
                </div>
                <img src='<?=base_url("static/img/footer.png")?>' />
            </div><!--footer-login-->

        </div><!--login-->
    </body>
</html>