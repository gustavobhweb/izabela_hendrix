<div class='body-login'>
    <h1>Seja bem vindo ao sistema web</h1>
    <h5>Para acessar sua conta digite no campo abaixo o seu CPF e matrícula.</h5>

    <div class='login-box'>
        <?php if (isset($error)) {?>
        <div style='width:373px;padding:5px;margin:0 0 10px 25px;float:left'><?=$error?></div>
        <?php }?>
        <form method='post' style='width:385px;float:left;margin:0 0 0 25px'>
            <p>CPF</p>
            <input type='text' id='txt_cpf' name='txt_cpf' value="<?=$this->input->post('txt_cpf') ?>" />
            <p style='float:left;width:100%;margin:10px 0 0 0'>Matrícula</p>
            <input type='text' id='txt_matricula' name='txt_matricula' value="" />
            <button class='btn-login' type='submit'>ENTRAR ></button>
            <h5 style='float:left;width:auto;text-align:left;margin:7px 0 0 0'><input type='checkbox' name='ckb_manter' /> Mantenha-me conectado</h5>
        </form>
        <div class='clear'></div>
    </div><!--login-box-->
</div><!--body-login-->

<?php $this->script(array('home/login'), false) ?>