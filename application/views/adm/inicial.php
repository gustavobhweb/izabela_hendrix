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
			    	<p style='font:13px Arial;color:#777777'>Nivel Administrador TMT</p>
			    	<div class='line' style='margin:10px 0 0 0'></div>
			    	<div class='menu'>
			    		<ul>
			    			<!-- <li><a href='<?=base_url("home/inicial")?>'><img src='<?=base_url("static/img/icon-home.png")?>' /> Página inicial</a></li>
			    			<li><a href='<?=base_url("home/avisos")?>'><img src='<?=base_url("static/img/icon-avisos.png")?>' /> Avisos</a></li>
			    			<li><a href='<?=base_url("home/acompanhar")?>'><img src='<?=base_url("static/img/icon-acomp.png")?>' /> Acompanhar minhas solicitações</a></li> -->
			    		</ul>
			    	</div><!--menu-->
		    	</div>
		    	<img class='logo-izabela-box' src='<?=base_url("static/img/izabela.png")?>' width='200' />
		    </div><!--left-menu-box-->

		    <div class='main-content'>

		    <div style='margin:100px 0 0 0'>

		    	<?php foreach($fotos as $foto){?>	
		    	<div class='item-aviso' style='background:url(<?=base_url("static/img/linear-table-3.png")?>);height:125px'>
		    		<div class='item-line-aviso' style='border:none;width:100px'><img src='<?=base_url("static/imagens/".$foto->foto)?>' width='76' height='100' /></div>
    				<div class='item-line-aviso' style='border:none;width:100px'><button style='margin:24px 0 0 6px' class='btn-cancel-iza bt-n' data-id='<?=$foto->cod_solicitacao?>' data-pessoa='<?=$foto->tbl_usuarios_cod_usuario?>'>REPROVAR</button></div>
    				<div class='item-line-aviso' style='border:none;width:100px'><button style='margin:24px 0 0 6px' class='btn-conf-iza bt-y' data-id='<?=$foto->cod_solicitacao?>' data-pessoa='<?=$foto->tbl_usuarios_cod_usuario?>'>APROVAR</button></div>
    				<div class='clearG'></div>
	    		</div>
	    		<?php }?>

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
<script type='text/javascript'>
$('.bt-y').click(function(){
	var _this = $(this);
	$.ajax({
		url: '<?=base_url("adm/aprovar")?>',
		type: 'POST',
		data: {cod: _this.attr('data-id'), pessoa: _this.attr('data-pessoa')},
		success: function(){ document.location.reload() },
		error: function(){ alert('Problemas na conexão!') }
	});
});

$('.bt-n').click(function(){
	var _this = $(this);
	$.ajax({
		url: '<?=base_url("adm/reprovar")?>',
		type: 'POST',
		data: {cod: _this.attr('data-id'), pessoa: _this.attr('data-pessoa')},
		success: function(){ 
			document.location.reload() 
		},
		error: function(){ alert('Problemas na conexão!') }
	});
});
</script>