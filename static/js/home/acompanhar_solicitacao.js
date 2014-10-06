$(document).ready(function(){
	var $btnChangeMail = $('#btn-edit-mail-of-solicitation');
	var $boxEditMail = $('#box-edit-mail-of-solicitation');

	$btnChangeMail.click(function(){
		// if(!$boxEditMail.is(':visible')){
		// 	$boxEditMail.fadeIn();
		// } else {
		// 	$boxEditMail.fadeOut();
		// }
		

        var html = '<small>Insira seu <b>e-mail válido</b> para realizar o acompanhamento da entrega da sua\
                    solicitação de carteira de identificação acadêmica.</small><br><br>'
            html += '<input type="email" id="confirm-send-with-mail" placeholder="Digite seu e-mail" class="wm-input input-large" >';
            html += '<input style="margin-top:8px" type="email" id="reconfirm-send-with-mail" placeholder="Confirme o e-mail" class="wm-input input-large" >';
            html += '<div style="width:100%">';
                html += '<div id="captcha-wrap">';
                    html += '<div class="captcha-box">';
                        html += '<img src="/home/getCaptcha" alt="" id="captcha" style="width:100px; height: 30px; margin-top:3px;" />';
                    html += '</div>';
                    html += '<div class="text-box">';
                        html += '<label><strong style="float:left; margin-left:10px; font-size:11px;">Digite o código acima:</strong></label>';
                        html += '<input name="captcha-code" type="text" id="captcha-code" style="height:27px !important;" autocomplete="off">';
                    html += '</div>';
                    html += '<div class="captcha-action" style="width:10px !important; float:left;">';
                        html += '<img src="/static/recaptcha/refresh.jpg"  alt="" id="captcha-refresh" />';
                    html += '</div>';
                html += '</div>';
                html += '<div style="clear:both"></div>';
            html += '</div>';

        var dialog = new wmDialog(html, {
            isHTML: true,
            width: 350,
            height: 390,
            title: 'Insira o seu e-mail',
            onConfirm: function(btn) {
                var $input = $('#confirm-send-with-mail');
                var $confirm = $('#reconfirm-send-with-mail');
                var $email = $("#change-mail-of-solicitation");
                var value = $input.val();
                var value1 = $confirm.val();
                var $form = $("#frm-email-update");

                if (value == '' || value == null) {
                    new wmDialog('Complete o campo e-mail para continuar!', {
                        height:230,
                        width: 330,
                        btnCancelEnabled: false
                    }).open();
                } else if (value && $input.is(':valid') && value == value1) {
                    $.ajax({
                        url: '/home/verifyCaptcha',
                        type: 'POST',
                        dataType: 'json',
                        data: { 
                            text: $('#captcha-code').val()
                        },
                        success: function(response){
                            if (response.status) {
                                $email.val(value);
                                $form.submit();
                            } else {
                                new wmDialog('O texto não confere.', {
                                    height:230,
                                    width: 330,
                                    btnCancelEnabled: false
                                }).open();
                                get_captcha();
                                $("#captcha-code").val('');
                            }
                        },
                        error: function(){
                            new wmDialog('Problemas de conexão! Atualize a página e tente novamente.', {
                                height:230,
                                width: 330,
                                btnCancelEnabled: false
                            }).open();
                        }
                    });
                } else if($input != $confirm) {
                    new wmDialog('O e-mail não confere!', {
                        height:230,
                        width: 330,
                        btnCancelEnabled: false
                    }).open();
                } else {
                    $input.focus();
                }
            }
        });

        dialog.open();
        get_captcha();
        $('#captcha-refresh').on('click', function(){
            get_captcha();
        });
	});
});

function get_captcha()
{
    $('#captcha').attr('src', '/home/getCaptcha/?' + new Date().getTime());
}