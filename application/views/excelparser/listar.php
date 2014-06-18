<!DOCTYPE html>
<html>
<head>
	<title>Dados Enviados</title>
	<style type="text/css">
	body{
		font-family: Arial;
	}
	table{
		width: 100%;
		border:thin solid #aaa;
		border-collapse: collapse;
		font-size: 12px;
	}
	table th{
		text-align: left;
		background: #ccc;
	}
	table th, table td{
		border:thin solid #aaa;	
		padding:10px;
	}
	table tr:nth-child(even){
		background: #CAE0EB;
	}
	table tr:hover{
		background: whitesmoke;
		color:#454;
	}
	</style>
</head>
<body>
 	<div class='container'>
 		<h2>Relatório da carga enviada</h2>
 		<?php if(!empty($upload_data)): ?>
 			<table>
 				<tr>
 					<th>Nome</th>
 					<th>Matrícula</th>
 					<th>CPF</th>
 					<th>Curso</th>
 				</tr>
 				<?php foreach($upload_data as $data): ?>
 					<tr>
 						<td>
 							<?=$data['nome']?>
 						</td>
 						<td>
 							<?=$data['matricula']?>
 						</td>
 						<td>
 							<?=$data['cpf']?>
 						</td>
 						<td>
 							<?=$data['curso']?>
 						</td>
 					</tr>
 				<?php endforeach ?>
 			</table>
 		<?php else: ?>
 			<div>
 				Nenhum dado foi recebido, porque são inválidos.<br>
 				Por favor, selecione outro arquivo e tente novamente.
 			</div>
 		<?php endif ?>
 	</div>
</body>
</html>
