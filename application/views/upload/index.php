<a href='<?=base_url("home/acompanhar")?>'>
    <div class='solics' style="width:190px">
        <h1>Envio de Carga</h1>
    </div>
</a><!--solics-->
<div class='clear'></div>
<br>
<section class="right-container">
    <div data-color='gray'>
        Selecione o arquivo e clique em <b>Enviar Carga</b>.<br>
        O <b>relatório da carga enviada</b> será exibido logo após o envio dos dados.
    </div>

    <form id="xls-upload-form" enctype="multipart/form-data" action="<?=base_url('excelparser/carga_usuario')?>" target="response_frame" method="post">
        <div style="margin:5px 0">
            <input type="file" name="xls" class='wm-input'>
            <button id="xls-submit" type="submit" class='wm-btn wm-btn-blue'>Enviar Carga</button>
        </div>
    </form>
    <div>
        <a href="<?=base_url('static/download/carga_aluno.xls')?>"></a>
    </div>
    <iframe name="response_frame" frameborder="0" id="response-frame"></iframe>
</section>

<?php $this->script(['upload/index'], false) ?>