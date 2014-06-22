<table class='tbl-aprovacoes' style="margin:30px 0 0 30px">
	<!-- <thead>
		<tr>
			<th>Foto</th>
			<th colspan='2'>Ações</th>
		</tr>
	</thead> -->
	<tbody>
		<?php foreach($fotos as $foto){?>
		<tr>
			<td><img onclick='openImage($(this))' src='<?=base_url("static/imagens/".$foto->foto)?>' width='76' height='100' /></td>
			<td><button style='margin:0px 0 0 6px' class='btn-cancel-iza bt-n' data-id='<?=$foto->cod_solicitacao?>' data-pessoa='<?=$foto->tbl_usuarios_cod_usuario?>'>REPROVAR</button></td>
			<td><button style='margin:0px 0 0 6px' class='btn-conf-iza bt-y' data-id='<?=$foto->cod_solicitacao?>' data-pessoa='<?=$foto->tbl_usuarios_cod_usuario?>'>APROVAR</button></td>
		</tr>
		<?php }?>
	</tbody>
</table>
<div id='imageShow' onclick='$(this).fadeOut();' style="display:none;position:fixed;z-index:1000;background:rgba(51,51,51,0.6);width:100%;height:100%;left:0;top:0">
	<img width="280" height="340" id='imageShowImg' style="margin:150px 0 0 540px" />
</div>
<script>
function openImage(obj)
{
	var src = obj.attr('src');
	$('#imageShow').find('img').attr('src', src);
	$('#imageShow').fadeIn();
}
</script>