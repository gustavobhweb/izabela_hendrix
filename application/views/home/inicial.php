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
				    <h1 style='font:22px Arial;color:#0865AE'>Olá, Tiago!</h1>
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

		    	<a href='#'><div class='solics'>
		    		<div class='num' style='float:right;margin:16px 15px 0 10px'>0</div>
		    		<h1>Acompanhar minhas solicitações</h1>
		    	</div></a><!--solics-->

		    	<div style='float:left;margin:20px 0 0 20px'>
			    	<h2 style='margin:20px 0 0 0;font:26px Arial;color:black'>Avisos</h2>

			    	<a href='#'><div class='item-aviso'>
	    				<div class='item-line-aviso'>
	    					<p style='font:14px arial;color:#0060B2;font-weight:bold;margin:8px 0 0 0'>Não lido</p>
	    					<img src='<?=base_url("static/img/msg.png")?>' />
	    				</div>
	    				<div class='item-line-aviso'>
	    					<p style='font:14px Arial;color:black;font-weight:bold;width:180px;margin:30px 0 0 0'>Seus creditos estão acabando</p>
	    				</div>
	    				<div class='item-line-aviso'>
	    					<p style='font:14px Arial;color:black;font-weight:bold;max-width:180px;margin:30px 0 0 0'>Grupo TMT</p>
	    				</div>
	    				<div class='item-line-aviso'>
	    					<p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0;;width:180px;font-style:italic'>Seus creditos estão acabando...</p>
	    				</div>
	    				<div class='item-line-aviso' style='border:none'><button style='margin:24px 0 0 6px' class='btn-conf-iza'>CONTINUAR ></button></div>
	    				<div class='clearG'></div>
	    			</div></a>

			    	<h2 style='margin:40px 0 0 0;font:26px Arial;color:black'>Solicitação da carteira de identidade acadêmica</h2>
			    	<a href='#'><div class='item-solics'>
	    				<div class='item-line-aviso'>
	    					<p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0;width:180px'>Carteira de identidade acadêmica</p>
	    				</div>
	    				<div class='item-line-aviso'>
	    					<p style='font:14px Arial;color:black;font-weight:bold;margin:30px 0 0 0'>Aluno</p>
	    				</div>
	    				<div class='item-line-aviso'>
	    					<img src='<?=base_url("static/img/carteira.png")?>' style='margin:-6px 0 0 0' />
	    				</div>
	    				<div class='item-line-aviso'>
	    					<p style='font:14px Arial;color:#0060B2;font-weight:bold;margin:30px 0 0 0;font-style:italic'>Liberado</p>
	    				</div>
	    				<div class='item-line-aviso' style='border:none'><button style='margin:24px 0 0 0' class='btn-conf-iza'>CONTINUAR ></button></div>
	    				<div class='clearG'></div>
	    			</div></a>
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
		    		<p>Tiago Magalhães</p>
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