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

    	<div class='modal-photo'>
    		<div class='box-photo'>
    			<div class='btn-close-box'></div>
    			<div class='header-modal-photo'>
    				Envio da foto	
    			</div><!--header-modal-photo-->
    			<div class='content-modal-photo'>
    				<div style='float:left;padding:20px 40px;border-right:1px solid #aaa;margin:30px 0 0 0'>
    					<p style='font:12px arial;font-weight:bold;font-style:italic;color:#005FB2;margin:0 0 10px 4px'>Nenhuma foto cadastrada</p>
    					<img class='userPhoto' width='155' height='155' src='<?=base_url("static/img/user.png")?>' />
    				</div>
    				<div style='float:left;width:430px;margin:50px 0 0 50px'>
    					<p style='font:13px arial;margin:0 0 10px 0'>Selecione o tipo de envio da foto de sua preferência:</p>
    					<button type='button' id='btn-take-photo' class='btn-take-photo'></button>
    					<button type='button' onclick='$("#userfile").click();' class='btn-file-photo'></button>
    				</div>
    				<div class='clear'></div>
    			</div><!--content-modal-photo-->
    		</div><!--box-photo-->
	    </div><!--modal-photo-->

    	<div class='content-box'>

	    	<div class='left-menu-box'>
			    <img class='logo-tmt-box' src='<?=base_url("static/img/logo-tmt.png")?>' width='200' />
			    <div style='width:220px;float:left;margin:30px 0 0 40px'>
				    <h1 style='font:22px Arial;color:#0865AE'>Olá, <?=$user->nome?></h1>
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

		    	<a href='<?=base_url("home/enviar_foto")?>'><div class='solicsHovered' style='width:150px;background-position:-60px 0'>
		    		<h1 style='margin-right:13px'>Enviar foto</h1>
		    	</div></a><!--solics-->

		    	<div style='width:100%;float:left'>

			    	<div class='box-img-pessoa' style='float:left'>
			    		<p>Nenhuma foto cadastrada</p>
			    		<img class='userPhoto' width='155' height='155' src='<?=base_url("static/img/user.png")?>' />
			    		<button class='btn-img-pessoa'>Enviar foto</button>
			    	</div><!--box-img-pessoa-->

			    	<div style='float:left;width:75%;margin:35px 0 0 10px'>
			    		<div class='alert-send-image'>
			    			<img src='<?=base_url("static/img/alert.png")?>' />
			    			<p>Faça abaixo o upload da foto para confecção do 
			    			documento. A carteirinha de identificação acadêmica te 
			    			acompanhará durante todo o curso, por isso é importante 
			    			o upload de uma foto recente e que essa siga as 
			    			especificações abaixo.</p>
			    		</div><!--alert-send-image-->
			    		<img src='<?=base_url("static/img/especifica.png")?>' />
			    		<form method='post' enctype='multipart/form-data' style='width:780px;margin:5px 0 0 0;float:left'>
			    			<input type='file' onchange='refreshImg(this)' name='userfile' id='userfile' style='display:none' />
			    			<div style='float:left;width:300px'>
			    				<input type='checkbox' name='ckb' id='ckb' />
			    				<label for='ckb' style='font:13px Arial'>Eu me <b>responsabilizo</b> pela 
			    				<b>veracidade</b> desta foto e concordo com os <b><u>termo de uso</u></b> do sistema</label>
			    			</div>
			    			<button type='submit' name='btn-submit' class='btn-conf-iza'>ENVIAR SOLICITAÇÃO DA CARTEIRA</button>
			    			<button type='button' onclick='document.location.href="<?=base_url('home/inicial')?>"' class='btn-cancel-iza'>CANCELAR</button>
			    		</form>
			    	</div>

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
function refreshImg(_this)
{
    var imageFile = _this.files[0];
    var url = window.URL.createObjectURL(imageFile);
   	$('.userPhoto').attr('src', url);
   	$('.modal-photo').fadeOut();
}
$('.btn-img-pessoa').click(function(){
	$('.modal-photo').fadeIn();
});
$('.btn-close-box').click(function(){
	$('.modal-photo').fadeOut();
});
</script>
<?php if(isset($message)){
	echo '<script type="text/javascript">alert("'.$message.'")</script>';
}?>