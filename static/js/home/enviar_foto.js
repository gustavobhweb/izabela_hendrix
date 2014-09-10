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
        	$('.userPhoto.after-choice').attr('src', src);
        	$(':hidden[name=tmp_image]').val(src);
        });
    });

    $(document).on('click', '.return-modal-menu', function(){
        $('#webcam').fadeOut(400, function(){
            $('#enviar-foto').fadeIn();
        });
    });
    
    $('.btn-fb-photo').click(function(){
        $.getScript('/static/js/fb.js');
    });

    $('#form-cadastrar-solicitacao').submit(function(e){
        e.preventDefault();


        if (!$('#ckb').is(':checked')) {
            new wmDialog('Você deve concordar deve os termos', {
                height:230,
                width: 330,
                btnCancelEnabled: false
            }).open();

            return;
        }

        if ($('.userPhoto').attr('data-selected') == 'false') {
            new wmDialog('Você deve selecionar a foto', {
                height:230,
                width: 330,
                btnCancelEnabled: false
            }).open();
            return;
        }

        var input = $('<input/>', {
            class: "wm-input input-large",
            placeholder: "Digite o seu e-mail antes de enviar a foto"

        });



        var dialog = new wmDialog(input, {
            isHTML: true, 
            width: 350,
            height: 240,
            btnCancelEnabled: false,
            title: 'Insira o seu e-mail'
        });


        dialog.open();
    })
});