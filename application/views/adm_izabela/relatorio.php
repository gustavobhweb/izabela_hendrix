<div class='content-box'>
        <a href='<?=base_url("adm_izabela/")?>'>
            <div class='solicsHovered' style='width:auto;background-position:-60px 0;padding-left:10px'>
                <h1 style='margin-right:13px'><?=$status?></h1>
            </div>
        </a><!--solics-->
    <div class='clear'></div>
</div><!--content-box-->

<?php if (!count($solicitacoes)) {?>
<div class='j-alert-error' style='float:left;margin:20px'>Nenhuma solicitação para o status <?=mb_strtolower($status, 'utf-8')?>.</div>
<?php } else {?>
<div id='jtable' class='jtable' style="float:left;margin:20px 0 0 20px;width:95%">
	<div data-section='header'>
		<p>Resgistro por página: <select id="slc-limit">
			<option data-limit='5' value='<?=$paginate->changeQueryString("limit", 5)?>'>5</option>
			<option data-limit='10' value='<?=$paginate->changeQueryString("limit", 10)?>'>10</option>
			<option data-limit='20' value='<?=$paginate->changeQueryString("limit", 20)?>'>20</option>
			<option data-limit='30' value='<?=$paginate->changeQueryString("limit", 30)?>'>30</option>
			<option data-limit='40' value='<?=$paginate->changeQueryString("limit", 40)?>'>40</option>
			<option data-limit='50' value='<?=$paginate->changeQueryString("limit", 50)?>'>50</option>
			<option data-limit='60' value='<?=$paginate->changeQueryString("limit", 60)?>'>60</option>
		</select></p>
		<!-- <form id='jsearch'>
			<input type='text' placeholder='Faça uma pesquisa' />
			<button type='button'><i class='glyphicon glyphicon-search'></i></button>
		</form> -->
		<div style="clear:both"></div>
	</div><!-- header -->
	<table>
		<thead>
			<tr>
				<th colspan="2">Aluno</th>
				<th>Matrícula</th>
				<th>CPF</th>
				<th>Curso</th>
				<th>Modelo</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($solicitacoes as $solicitacao) {?>
			<tr>
				<td><img title='<?=$solicitacao->nome?>' class='imgSolic' src='<?=base_url('static/imagens/' . $solicitacao->foto)?>' height="50" /></td>
				<td><?=$solicitacao->nome?></td>
				<td><?=$solicitacao->matricula?></td>
				<td><?=$Utility->mask($solicitacao->cpf, '###.###.###-##')?></td>
				<td><?=$solicitacao->curso?></td>
				<td><?=$solicitacao->modelo?></td>
				<td><?=$solicitacao->status?></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<?=$paginateMake?>
</div><!-- .jtable -->
<?php }?>

<?php
$this->style(array(
	'jtable',
	'jquery-ui'
), false);

$this->script(array(
	'jquery-ui',
	'adm_izabela/relatorio',
	'jtable'
), false);

?>