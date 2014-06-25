<a href='<?=base_url("home/acompanhar")?>'>
    <div class='solics' style="width:225px">
        <h1 style='margin:5px'>Cadastro de Aluno</h1>
    </div>
</a><!--solics-->
<div class='clear'></div>
<section class="right-container">

<div id="form-cadastrar-aluno">
    <form method="post" action="#">
        <h3>Dados do aluno</h3>
        <?php if(isset($post_status)): ?>
            <div><small class='alert'><i><?=$post_status?></i></small></div>
        <?php endif ?>
        <div style="margin:10px 0">
            <input 
                value="<?php isset($post_data['nome']) and print($post_data['nome']) ?>"
                size='50' 
                placeholder="Nome Completo" 
                type="text" 
                required name="nome" 
                class="wm-input"
                pattern="[a-zA-Z ]+"
                title='Insira um nome completo válido.'
            />
        </div>
        <div style="margin:10px 0">
            <input 
                value="<?php isset($post_data['matricula']) and print($post_data['matricula']) ?>" 
                size='50' placeholder="Matrícula" 
                type="text" 
                required name="matricula" class="wm-input" pattern="\d+" title="A matrícula deve conter apenas números." />
        </div>
            
        <div style="margin:10px 0">
            <input 
                value="<?php isset($post_data['curso']) and print($post_data['curso']) ?>"
                size="50" placeholder="Curso" 
                type="text" 
                required 
                name="curso" class="wm-input" pattern="[a-zA-Z0-9 ]{3,}" 
                title="Para o curso, será aceito apenas letras e números e deve conter mais de três caracteres."
            />
        </div>
        <div style="margin:10px 0">
            <input value="<?php isset($post_data['cpf']) and print($post_data['cpf']) ?>" size="50" maxlength="14" placeholder="CPF" type="text" required name="cpf" class="wm-input" pattern="\d{3}\.\d{3}.\d{3}-\d{2}" />
        </div>
        <div>   
            <button type="submit" class='wm-btn wm-btn-blue'>Cadastrar</button>
        </div>
    </form>
</div>
</section>

<?php $this->script(['jquery.mask.min', 'adm_izabela/cadastrar_aluno'], false) ?>