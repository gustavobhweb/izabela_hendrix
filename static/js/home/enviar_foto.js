function refreshImg(_this)
{
    var imageFile = _this.files[0];
    var url = window.URL.createObjectURL(imageFile);
   	$('.userPhoto').attr({'src': url, 'data-selected': 'true'});
   	$('.modal-photo').fadeOut();
}

$(function(){
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
        $('#webcam').fadeOut(400, function(){
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