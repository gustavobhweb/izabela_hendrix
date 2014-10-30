<a href='<?=base_url("adm_izabela/carga_aluno")?>'>
    <div class='solicsHovered'>
        <h1>Envio de Carga de Alunos</h1>
    </div>
</a><!--solics-->
<div class='clear'></div>
<br>
<section class="right-container">
    <div data-color='gray'>
        Selecione o arquivo e clique em <b>Enviar Carga</b>.
    </div>
    <br/>
    <div>
        Os campos devem conter, respectivamente, as colunas:<br>
        <b>nome, matricula, curso, cpf e modelo</b><br><br>
        Os campos <b>matricula</b> e <b>cpf</b> devem conter <b>apenas números</b>.<br><br>
        Para baixar o modelo do arquivo XLSX, <a href='<?=base_url("/static/modelo.xlsx")?>' class='iza-link'>clique aqui</a>.
    </div>
    <br/>
    <div>
    O formato do arquivo dever ser <strong>XLSX</strong>
    </div>

    <form id="xls-upload-form" enctype="multipart/form-data" action="<?=base_url('excelparser/carga_usuario')?>" target="response_frame" method="post">
        <div style="margin:5px 0">
            <input type="file" name="xls" class='wm-input'>
            <button id="xls-submit" type="submit" class='wm-btn wm-btn-blue'>Enviar Carga</button>
        </div>
    </form>
    <br/>
    <iframe name="response_frame" frameborder="0" seamless id="response-frame"></iframe>

</section>
<?= $this->element('common-alert') ?>
<?php 
    $this->style(array(
        'jquery-ui',
        'wm-modal'
    ), false);
    $this->script([
        'jquery-ui',
        'wm-modal',
        'upload/index'
    ], false);

?>