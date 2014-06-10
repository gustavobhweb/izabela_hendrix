<table class='tbl-aprovacoes'>
	<thead>
		<tr>
			<th>Foto</th>
			<th colspan='2'>Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($fotos as $foto){?>
		<tr>
			<td><img src='<?=base_url("static/imagens/".$foto->foto)?>' width='76' height='100' /></td>
			<td><button style='margin:0px 0 0 6px' class='btn-cancel-iza bt-n' data-id='<?=$foto->cod_solicitacao?>' data-pessoa='<?=$foto->tbl_usuarios_cod_usuario?>'>REPROVAR</button></td>
			<td><button style='margin:0px 0 0 6px' class='btn-conf-iza bt-y' data-id='<?=$foto->cod_solicitacao?>' data-pessoa='<?=$foto->tbl_usuarios_cod_usuario?>'>APROVAR</button></td>
		</tr>
		<?php }?>
	</tbody>
</table>