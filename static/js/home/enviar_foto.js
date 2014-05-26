function refreshImg(_this)
{
    var imageFile = _this.files[0];
    var url = window.URL.createObjectURL(imageFile);
   	$('.userPhoto').attr('src', url);
   	$('.modal-photo').fadeOut();
}

$(document).ready(function(){
	$('.btn-img-pessoa').click(function(){
		$('.modal-photo').fadeIn();
	});
	$('.btn-close-box').click(function(){
		$('.modal-photo').fadeOut();
	});
});