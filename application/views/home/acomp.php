<a href='<?=base_url("home/acompanhar")?>'><div class='solicsHovered'>
		    		<div class='num' style='float:right;margin:16px 15px 0 10px'>0</div>
		    		<h1>Acompanhar minhas solicitações</h1>
		    	</div></a><!--solics-->

		    	<div class='situacao-box'>

	    			<h1>Situação</h1>

	    			<?php foreach ($solicitacoes as $solicitacao) {?>
	    			<div class='situacao-inset-box'>

	    				<div style='float:left'>
		    				<div style='float:left;margin:30px 0 0 30px'>
			    				<div style='width:300px;height:189px;background:url(<?=base_url("static/img/frente-carteira.png")?>) no-repeat;float:left'>

			    					<img src='<?=base_url("static/imagens/".$solicitacao->foto)?>' width='78' height='102' style='float:right;margin:8px 10px 0 0;border-radius:.3em' />

			    				</div>
			    				<img src='<?=base_url("static/img/verso-carteira.png")?>' style='float:left;margin:0 0 0 15px' />

			    				<div style='border-left:1px solid #aaaaaa;background:#0061B2;margin:0px 0 0 0;float:left;margin:0 0 0 30px;padding:20px 8px'>
			    					<img src='<?=base_url("static/img/alert.png")?>' style='float:left' />

			    					<div style='float:left;margin:0 0 0 12px;width:180px'>
			    						<p style='font:12px arial;color:#ffffff'>e-mail cadastrado:</p>
			    						<p style='font:12px arial;color:#ffffff;font-weight:bold'>tiago@grupotmt.com.br</p>

			    						<p style='font:12px arial;color:#ffffff;margin:15px 0 0 0'>Todas as notificações serão enviadas para este endereço</p>
			    						<p style='font:20px arial;cursor:pointer;color:#ffffff;font-weight:bold;margin:11px 0 0 0'>Editar</p>
			    					</div>

			    				</div>
		    				</div>
		    				<img src='<?=base_url("static/img/linha-tempo-".$solicitacao->tbl_status_cod_status.".png")?>' style='float:left;margin:30px 0 30px 39px' />
	    				</div>

	    				<div class='clear'></div>

	    			</div><!--situacao-inset-box-->
	    			<?php }?>

	    		</div><!--situacao-box-->