<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <body style="width: 100%;min-width:100%;max-width:100%">
        <div class='login'>

            <div class='header-login'>
                <img class='logo-izabela' src='<?=base_url("static/img/izabela.png")?>' />
                <div class='clear'></div>
            </div><!--header-login-->

            <div>
            	<?=$this->fetch('content') ?>
            </div>

            <div class='footer-login'>
                <div class="footer-login-logos"></div>
            </div><!--footer-login-->

        </div><!--login-->
    </body>
</html>