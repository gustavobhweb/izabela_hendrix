<?php
    
    $inputs_filter = [
    	'nome' => 'Nome',
        'matricula' => 'Matrícula',
        'cpf' => 'CPF',
        'remessa' => 'Remessa'
    ];

?>
<a href='#'>
    <div class='solicsHovered'>
        <h1>Pesquisar Alunos</h1>
    </div>
</a>
<div class='clear'></div>
<div style="margin:30px">
    <form id="admin-formulario-pesquisa-aluno" method="get">
        <select class="wm-input" name="filtro">
            <?php foreach($inputs_filter as $fieldname => $name): ?>
                <?php  $selected = (isset($filter_name) && $fieldname == $filter_name) ? 'selected="selected"' : '';?>
                <option <?=$selected?> value="<?=$fieldname?>"><?=$name?></option>
            <?php endforeach ?>
        </select>
        <input placeholder="Entre com uma palavra-chave" class="wm-input input-large" type="text" name="valor" id="keyworkd-search" />
        <button type='submit' class='wm-btn wm-btn-blue'>Pesquisar</button>
        <?php if ($backBtn) {?>
        <a href="<?=base_url('adm_izabela/cargas_enviadas/')?>"><button type='button' class='wm-btn wm-btn-blue' style="float:right"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</button></a>
        <?php } ?>
    </form>

    <br/>
    <?php if(isset($filter_name)): ?>
        <?php if(!empty($alunos)): ?>
            <div id='jtable' class='jtable' style="float:left;width:100%;margin-bottom:30px">
				<div data-section='header'>
					<p>Resgistro por página: <select id='slc-limit'>
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
							<th>Data da remessa</th>
							<th>Mais informações</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($alunos as $aluno) {?>
						<tr>
							<td><img style='border-radius:4px' onerror='this.src="/static/img/user.png"' title='<?=$aluno->nome?>' class='imgTooltip' src='<?= base_url("static/imagens/" . $aluno->foto)?>' width='50' height='67' /></td>
							<td><?=$aluno->nome?></td>
							<td><?=$aluno->matricula?></td>
							<td><?=$Utility->mask($aluno->cpf, '###.###.###-##')?></td>
							<td><?=($aluno->curso) ? $aluno->curso : '-'?></td>
							<td><?=($aluno->modelo) ? $aluno->modelo : '-'?></td>
							<td><?=($aluno->status) ? $aluno->status : 'Aguardando solicitação'?></td>
							<td><?=strftime("%d de %B de %Y", strtotime($aluno->dataRemessa));?></td>
							<td><button data-id="<?=$aluno->cod_usuario?>" class='wm-btn wm-btn-blue btn-mais-info'><i class='glyphicon glyphicon-plus'></i></button></td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<?=$paginateMake?>
			</div><!-- .jtable -->
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
<?= $this->element('common-alert') ?>
<?php 
    $this->style(array(
    	'jquery-ui',
		'wm-modal',
		'jtable'
	), false);

	$this->script(array(
		'jquery-ui',
		'wm-modal',
		'adm_izabela/pesquisar',
		'jtable'
	), false);
?>