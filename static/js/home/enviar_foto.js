function refreshImg(_this)
{
    var imageFile = _this.files[0];
    var url = window.URL.createObjectURL(imageFile);
   	$('.userPhoto').attr('src', url);
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
});