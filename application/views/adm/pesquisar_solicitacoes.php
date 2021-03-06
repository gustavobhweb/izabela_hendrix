<?php
    
    $inputs_filter = [
        'matricula' => 'Matrícula',
        'cpf' => 'CPF',
        'nome' => 'Nome',
        'via' => 'Via'
    ];

?>
<a href='#'>
    <div class='solics' style="width:300px;">
        <h1 style="margin:0 20px">Pesquisar Solicitações</h1>
    </div>
</a>
<div class='clear'></div>
<div style="margin:30px">
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
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Matrícula</th>
                        <th>CPF</th>
                        <th>Via</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($search_results as $result): ?>
                        <tr>
                            <td style="position:relative;">
                                <img class='img-preview' height="70" width="60" src="<?=base_url("/static/imagens/{$result['foto']}");?>"/>
                                <div class='img-show'>
                                    <div class='img-show--close'>&times;</div>
                                </div>
                            </td>
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