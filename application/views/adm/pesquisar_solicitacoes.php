<?php
	
	$inputs_filter = [
		'matricula' => 'Matrícula',
		'cpf' => 'CPF',
		'nome' => 'Nome',
		'via' => 'Via'
	];

?>

<div style="margin:30px">
	<h1>Pesquisa Solicitações</h1>
	<form id="admin-formulario-pesquisa-aluno" method="get">
		<select class="wm-input" name="filtro">
			<?php foreach($inputs_filter as $fieldname => $name): ?>
				<?php 
					$selected = (isset($filter_name) && $fieldname == $filter_name) ? 'selected="selected"' : '';
				?>
				<option <?=$selected?> value="<?=$fieldname?>"><?=$name?></option>
			<?php endforeach ?>
		</select>
		<input placeholder="Entre com uma palavra-chave" class="wm-input input-large" type="text" name="valor" id="keyworkd-search" />
		<button class='wm-btn wm-btn-blue'>Pesquisar</button>
	</form>

	<br/>
	<?php if(isset($filter_name)): ?>
		<?php if(!empty($search_results)): ?>
			<table style="width:100%" class='wm-table'>
				<thead>
					<tr>
						<th>Nome</th>
						<th>Matrícula</th>
						<th>CPF</th>
						<th>Via</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($search_results as $result): ?>
						<tr>
							<td><?=$result['nome']?></td>
							<td><?=$result['matricula']?></td>
							<td><?=$result['cpf']?></td>
							<td><?=$result['via']?>ª</td>
						</tr>
					<?php endforeach ?>
				</tbody>

			</table>
		<?php else: ?>
			<div class='wm-text-warning'>
				<?php if(!$search_keyword): ?>
					Sua pesquisa é inválida para o filtro "<strong><?=$filter_name?></strong>"
				<?php else: ?>
					Não há nenhum resultado para "<strong><?=$search_keyword?></strong>"
				<?php endif ?>
			</div>
		<?php endif ?>
	<?php endif ?>


</div>
<?php 
	$this->script(['admin/pesquisar_solicitacoes'], false)
?>