var i =0;
var reader = new window.FileReader();
function refreshImg(_this)
{
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
                            img: base64data
                        },
                        success: function(data) {
                            $('.modal-photo').fadeOut(500, function(){
                                $('#crop').hide();
                                $('#enviar-foto').show();
                                $('.userPhoto.after-choice').attr({
                                    'src': data.url,
                                    'data-selected': 'true'
                                });
                            });
                        },
                        error: function()
                        {
                            alert('Problemas na conexão!');
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

$(function(){
    $('.box-photo').draggable({
        handle: '.header-modal-photo'
    });
	$('.btn-img-pessoa').click(function(){
		$('.modal-photo').fadeIn();
	});

	$('.btn-close-box').click(function(){
        $('.return-modal-menu').click();
		$('.modal-photo').fadeOut();
	});

	$('#save-photo').click(function(){

        var src = $('.userPhoto.preview-modal').attr('src');

        $('.modal-photo').fadeOut(400, function(){
        	$('.userPhoto').attr({'src': src, 'data-selected' : 'true'});
        	$(':hidden[name=tmp_image]').val(src);
        });
    });

    $(document).on('click', '.return-modal-menu', function(){
        $('#webcam, #crop').fadeOut(0, function(){
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
            html += '<input type="email" id="confirm-send-with-mail" placeholder="seulogin@site.com" class="wm-input input-large" >';


        var dialog = new wmDialog(html, {
            isHTML: true,
            width: 350,
            height: 240,
            btnCancelEnabled: false,
            title: 'Insira o seu e-mail',
            onConfirm: function(btn) {
                var $input = $('#confirm-send-with-mail');
                var $email = $("#hidden-email");
                var value = $input.val();

                if (value && $input.is(':valid')) {
                    $email.val(value);
                    $form.submit();
                } else {
                    $input.focus();
                }
            }
        });


        dialog.open();
    })
});