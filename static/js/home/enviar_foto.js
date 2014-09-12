function refreshImg(_this)
{
    $('#enviar-foto').fadeOut(400, function(){
        $('#crop').fadeIn();
        var imageFile = _this.files[0];
        var url = window.URL.createObjectURL(imageFile);

        one = new CROP();
        one.init('.jcrop');
        one.loadImg(url);

        $('.btn-make-crop').click(function(){
            var reader = new window.FileReader();
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
                            $('.userPhoto.after-choice').attr('src', data.url);
                        });
                    },
                    error: function()
                    {
                        alert('Problemas na conexão!');
                    }
                });
            }
        });
    });
}

$(function(){
    window.one;
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
        	$('.userPhoto.after-choice').attr('src', src);
        	$(':hidden[name=tmp_image]').val(src);
        });
    });

    $(document).on('click', '.return-modal-menu', function(){
        $('#webcam').fadeOut(400, function(){
            $('#enviar-foto').fadeIn();
        });
        $('#crop').fadeOut(400, function(){
            $('#enviar-foto').fadeIn();
        });
    });

    $('.btn-fb-photo').click(function(){
        $.getScript('/static/js/fb.js');
    });

    $('#form-cadastrar-solicitacao').submit(function(e){
        e.preventDefault();

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