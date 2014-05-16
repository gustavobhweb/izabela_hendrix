<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <script type="text/javascript" src="<?=base_url('static/bootstrap/js/jquery-1.10.2.min.js');?>"></script>
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
        <link rel="stylesheet" type="text/css" href="<?=base_url('static/bootstrap/css/style_izabela.css');?>" />
        <title>Izabela Hendrix</title>
    </head>
    <body>

    	<div class='content-box'>

	    	<div class='left-menu-box'>
			    <img class='logo-tmt-box' src='<?=base_url("static/img/logo-tmt.png")?>' width='200' />
			    <div style='width:220px;float:left;margin:30px 0 0 40px'>
				    <h1 style='font:22px Arial;color:#0865AE'>Olá, <?=$user->nome?>!</h1>
			    	<p style='font:13px Arial;color:#777777'>Nivel Aluno</p>
			    	<div class='line' style='margin:10px 0 0 0'></div>
			    	<div class='menu'>
			    		<ul>
			    			<li><a href='<?=base_url("home/inicial")?>'><img src='<?=base_url("static/img/icon-home.png")?>' /> Página inicial</a></li>
			    			<li><a href='<?=base_url("home/avisos")?>'><img src='<?=base_url("static/img/icon-avisos.png")?>' /> Avisos</a></li>
			    			<li><a href='<?=base_url("home/acompanhar")?>'><img src='<?=base_url("static/img/icon-acomp.png")?>' /> Acompanhar minhas solicitações</a></li>
			    		</ul>
			    	</div><!--menu-->
		    	</div>
		    	<img class='logo-izabela-box' src='<?=base_url("static/img/izabela.png")?>' width='200' />
		    </div><!--left-menu-box-->

		    <div class='main-content'>

		    	<a href='<?=base_url("home/avisos")?>'><div class='solicsHovered' style='width:135px;background-position:-60px 0'>
		    		<div class='num' style='float:right;margin:16px 15px 0 10px;'><?=$avisosNum?></div>
		    		<h1>Avisos</h1>
		    	</div></a><!--solics-->

		    	<div style='float:left;margin:20px 0 0 20px;width:90%'>

		    		<?php if($avisosNum<=0){?>
			    	<div class='j-alert-error'>Nenhum aviso foi encontrado.</div>
			    	<?php }else{?>
			    	<div style='margin:10px 0 0 0'>
	    				<div class='head-item' style='width:100px'>Status</div>
	    				<div class='head-item' style='width:180px'>Assunto</div>
	    				<div class='head-item' style='width:90px'>Remetente</div>
	    				<div class='head-item' style='width:180px'>Mensagem</div>
	    				<div class='head-item' style='width:150px'>Selecionar</div>
	    				<div class='clearG'></div>
	    			</div><br>

	    			<?php foreach($avisos as $aviso){?>
			    	<a href='<?=base_url("aviso/".$aviso->cod_aviso)?>'><div class='item-aviso'>
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
	    					<p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0;width:180px;font-style:italic'><?php
	    						if(strlen($aviso->mensagem) > 30)
	    						{
									$aviso->mensagem = substr($aviso->mensagem, 0, 30).'...';
	    						}
	    						echo $aviso->mensagem;
	    					?></p>
	    				</div>
	    				<div class='item-line-aviso' style='border:none;width:150px'><button style='margin:24px 0 0 6px' class='btn-conf-iza'>CONTINUAR ></button></div>
	    				<div class='clearG'></div>
	    			</div></a>
	    			<?php }}?>

		    	</div>

		    </div><!--main-content-->

		    <div class='clear'></div>

		    <div class='menu-usuario'>
		    	<a style='text-decoration:none' href='<?=base_url("home/inicial")?>'><div class='pagina-inicial'>
		    		<p>Página inicial</p>
		    		<img src='<?=base_url("static/img/home-blue.png")?>' />
		    	</div></a>
		    	<div class='minha-conta'>
		    		<img src='<?=base_url("static/img/arrow-down.png")?>' class='arrow-icon' />
		    		<p><?=$user->nome?></p>
		    	</div><!--minha-conta-->
		    	<a class='sair-link' href='<?=base_url("home/sair")?>'>Sair</a>
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