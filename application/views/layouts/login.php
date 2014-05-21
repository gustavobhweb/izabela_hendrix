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
        <title>Izabela Hendrix</title>
    </head>
    <body>
        <div class='login'>
            
            <div class='header-login'>
                <img class='logo-izabela' src='<?=base_url("static/img/izabela.png")?>' />
                <img class='logo-tmt' src='<?=base_url("static/img/logo-tmt.png")?>' width='200' />
                <div class='clear'></div>
            </div><!--header-login-->

            <div>
            	<?=$this->fetch('content') ?>
            </div>

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