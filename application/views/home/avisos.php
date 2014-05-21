<a href='<?=base_url("home/avisos")?>'><div class='solicsHovered' style='width:135px;background-position:-60px 0'>
	<div class='num' style='float:right;margin:16px 15px 0 10px;'><?=$avisosNum?></div>
	<h1>Avisos</h1>
</div>
</a><!--solics-->

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

