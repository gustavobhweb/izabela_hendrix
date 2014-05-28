<?php
	
	$inputs_filter = [
		'matricula' => 'Matrícula',
		'cpf' => 'CPF',
		'nome' => 'Nome'
	];

?>

<div style="margin:30px">
	<form id="admin-formulario-pesquisa-aluno" method="get">
		<select name="filtro">
			<?php foreach($inputs_filter as $fieldname => $name): ?>
				<?php 
					$selected = (isset($filter_name) && $fieldname == $filter_name) ? 'selected="selected"' : '';
				?>
				<option <?=$selected?> value="<?=$fieldname?>"><?=$name?></option>
			<?php endforeach ?>
		</select>
		<input type="text" name="valor" id="keyworkd-search" />
		<button>Pesquisar</button>
	</form>

	<br/>
	<?php if(isset($filter_name) && !empty($search_results)): ?>
		<table style="width:100%" class='wm-table'>
			<thead>
				<tr>
					<th>Nome</th>
					<th>Matrícula</th>
					<th>CPF</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($search_results as $result): ?>
					<tr>
						<td><?=$result['nome']?></td>
						<td><?=$result['matricula']?></td>
						<td><?=$result['cpf']?></td>
					</tr>
				<?php endforeach ?>
			</tbody>

		</table>
	<?php endif ?>


</div>
<?php 
	$this->script(['admin/pesquisar'], false)
?>