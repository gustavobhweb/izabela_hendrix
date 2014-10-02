var i =0;
var reader = new window.FileReader();
function refreshImg(_this)
{
    $('.box-photo').animate({margin: '2% auto'});
    $('.btn-make-crop').removeAttr('disabled');
    $('.btn-make-crop').html('Salvar');
    $('.return-modal-menu').show();
    var ext = _this.val().split('.').slice(-1)[0];
    regexpExtension = /(png|jpg|jpeg|bmp|gif)/gi;
    if (regexpExtension.test(ext)) {

        $('#enviar-foto').fadeOut(400, function(){
            $('#crop').fadeIn();
            var imageFile = _this.prop('files')[0];
            var url = window.URL.createObjectURL(imageFile);

            $('.jcrop').html('<div class="cropMain"></div><p>Ajustar o zoom:</p><div class="cropSlider"></div>');
            var one = new CROP();
            one.init('.jcrop');
            one.loadImg(url);
            var reader = new window.FileReader();
            $('.btn-make-crop').click(function(){
                var _thisBtn = $(this);
                $('.return-modal-menu').hide(0, function(){
                    _thisBtn.html('Salvando...');
                    _thisBtn.attr('disabled', 'disabled');
                });
                if (typeof(imageFile) == 'undefined' || imageFile == null) imageFile = _this.prop('files')[0];
                reader.readAsDataURL(imageFile);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    base64data = base64data.replace(/data:image\/.+;base64,/, '');

                    $.ajax({
                        url: '/home/cropimage/?' + $.param(coordinates(one)),
                        type: 'POST',
                        data: {
                            img: base64data,
                            ext: ext
                        },
                        success: function(data) {
                            $('.modal-photo').fadeOut(500, function(){
                                $('#crop').hide();
                                $('#enviar-foto').show();
                                $('.userPhoto.after-choice').attr({
                                    'src': data.url + '?' + new Date().getTime(),
                                    'data-selected': 'true'
                                });
                            });
                        },
                        error: function()
                        {
                            new wmDialog('Problemas de conexão! Atualize a página e tente novamente.', {
                                height:230,
                                width: 330,
                                btnCancelEnabled: false
                            }).open();
                        }
                    });
                    imageFile = null;
                }
            });
        });

    } else {
        new wmDialog('A extensão do arquivo escolhido é inválida.', {
                height:230,
                width: 330,
                btnCancelEnabled: false
            }).open();
    }
}

function get_captcha(obj)
{
    $('#captcha').attr('src', '/home/getCaptcha/?' + new Date().getTime());
}

$(function(){

    $('.box-photo').draggable({
        handle: '.header-modal-photo'
    });
	$('.btn-img-pessoa').click(function(){
		$('.modal-photo').fadeIn();
        $('#avisopermitir').hide();
	});

	$('.btn-close-box').click(function(){
        $('.return-modal-menu').click();
		$('.modal-photo').fadeOut();
	});

	$('#save-photo').click(function(){
        var src = $('.userPhoto.preview-modal').attr('src');

        $('.modal-photo').fadeOut(400, function(){
        	$('.userPhoto').attr({
                'src': src + '?' + new Date().getTime(),
                'data-selected' : 'true'
            });
        	$(':hidden[name=tmp_image]').val(src);
        });
    });

    $(document).on('click', '.return-modal-menu', function(){
        $('.box-photo').animate({margin: '8% auto'});
        $('#webcam, #crop, #flashcam').fadeOut(0, function(){
            $('#enviar-foto').fadeIn();
        });
    });

    $('#submit-solicitacao').click(function(e){
        e.preventDefault();

        var $form = $('#form-cadastrar-solicitacao');
        if (!$('#ckb').is(':checked')) {
            new wmDialog('Você deve concordar deve os termos', {
                height:230,
                width: 330,
                btnCancelEnabled: false
            }).open();

            return false;
        }

        if ($('.userPhoto').attr('data-selected') == 'false') {
            new wmDialog('Você deve selecionar a foto', {
                height:230,
                width: 330,
                btnCancelEnabled: false
            }).open();

            return false;
        }

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
                var $email = $("#hidden-email");
                var value = $input.val();
                var value1 = $confirm.val();

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