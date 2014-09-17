$(function(){

	new ImgSelect( $('#imgselect_container') );

	$('#btn-take-photo').click(function(){
		$('#enviar-foto').fadeOut(function(){
			$('#webcam').show(0, function(){
				$('.imgs-webcam').click();
                $('#imgselect_container').fadeOut();
                $('#waitcam').fadeIn();
                $('#avisopermitir').fadeIn();
			});
		});
	});

});