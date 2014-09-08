<div class='modal-photo'>
    <div class='box-photo'>
        <div class='btn-close-box'></div>
        <div class='header-modal-photo'>
            Envio da foto
        </div><!--header-modal-photo-->
        <div class='content-modal-photo'>
            <div id='enviar-foto' style='float:left;width:430px;margin:50px 0 0 50px'>
                <p style='font:13px arial;margin:0 0 10px 0'>Selecione o tipo de envio da foto de sua preferência:</p>
                <button type='button' id='btn-take-photo' class='btn-take-photo'></button>
                <button type='button' onclick='$("#userfile").click();' class='btn-file-photo'></button>
                <button type='button' class='btn-fb-photo'></button>
            </div>

            <div id='webcam' style='display:none'>

                <div id="imgselect_container">
                    <button type="button" class="btn btn-success imgs-webcam" style="display:none">Webcam</button> <!-- .imgs-webcam -->

                    <div style="position:relative;width:287px;height:215px;margin:0 auto">
                        <div class="imgs-webcam-container"></div> <!-- .imgs-webcam-container -->
                        <div style="position:absolute;background:#EEEEEF;left:0;top:0;width:69px;height:215px"></div>
                        <div style="position:absolute;background:#EEEEEF;right:0;top:0;width:69px;height:215px"></div>
                    </div>

                    <div style="width:100%;float:left;margin: 10px 0 0 0;position:relative;z-index:999999">
                        <button class="btn-conf-iza imgs-capture btn-capture">Tirar foto</button>
                        <button class="btn-cancel-iza imgs-cancel btn-cancel-webcam return-modal-menu">Voltar</button>
                    </div>
                </div>
            </div>
            <div class='clear'></div>
        </div><!--content-modal-photo-->
    </div><!--box-photo-->
</div><!--modal-photo-->

<div class='content-box'>
    <div class='main-content'>
        <a href='<?=base_url("home/enviar_foto")?>'>
            <div class='solicsHovered' style='width:150px;background-position:-60px 0'>
                <h1 style='margin-right:13px'>Enviar foto</h1>
            </div>
        </a><!--solics-->
        <div style='width:100%;float:left'>
            <div class='box-img-pessoa' style='float:left'>
                <p>Nenhuma foto cadastrada</p>
                <img class='userPhoto after-choice' width='155' height='155' src='<?= ($tmp_image = $this->input->post('tmp_image')) ? $tmp_image : base_url("static/img/user.png")?>' />
                <button class='btn-img-pessoa'>Enviar foto</button>
            </div><!--box-img-pessoa-->

            <div style='float:left;width:75%;margin:35px 0 0 10px'>
                <div class='alert-send-image'>
                    <img src='<?=base_url("static/img/alert.png")?>' />
                    <p>Faça abaixo o upload da foto para confecção do
                    documento. A carteirinha de identificação acadêmica te
                    acompanhará durante todo o curso, por isso é importante
                    o upload de uma foto recente e que essa siga as
                    especificações abaixo.</p>
                </div><!--alert-send-image-->
                <img src='<?=base_url("static/img/especifica.png")?>' />
                <form id="form-cadastrar-solicitacao" method='post' enctype='multipart/form-data' style='width:780px;margin:5px 0 0 0;float:left'>
                    <input type='file' onchange='refreshImg(this)' name='userfile' id='userfile' style='display:none' />
                    <div style='float:left;width:300px'>
                        <input type='checkbox' name='ckb' id='ckb' />
                        <label for='ckb' style='font:13px Arial'>Eu me <b>responsabilizo</b> pela
                        <b>veracidade</b> desta foto e concordo com o <b><u>termo de uso</u></b> do sistema</label>
                    </div>
                    <input type='hidden' name='webcam-upload' value='<?=$user->matricula.".png"?>' />
                    <button type='submit' name='btn-submit' class='btn-conf-iza'>ENVIAR SOLICITAÇÃO DA CARTEIRA</button>
                    <button type='button' onclick='document.location.href="<?=base_url('home/inicial')?>"' class='btn-cancel-iza'>CANCELAR</button>
                    <input type="hidden" name='tmp_image' value="<?=$this->input->post('tmp_image')?>" />
                </form>
            </div>
        </div>
    </div><!--main-content-->
    <div class='clear'></div>
</div><!--content-box-->
<div class='clearfix'></div>
<?php 

    $this->script(
        [
            'home/enviar_foto',
            'home/jquery.webcam',
            'home/webcam',
            'wm-modal'
        ], 
        false
    );
?>

<?php $this->style(['wm-modal'], false) ?>

<?= $this->element('common-alert') ?>

<?php  if (isset($message)): ?>
<script>
var text = <?=json_encode($message)?>

$(function(){
    var alert = new wmDialog(text);
    alert.btnCancelEnabled = false;
    alert.open();
});
</script>
<?php endif ?>