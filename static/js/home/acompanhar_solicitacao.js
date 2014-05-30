$(document).ready(function(){
	var $btnChangeMail = $('#btn-edit-mail-of-solicitation');
	var $boxEditMail = $('#box-edit-mail-of-solicitation');

	$btnChangeMail.click(function(){
		if(!$boxEditMail.is(':visible')){
			$boxEditMail.fadeIn();
		} else {
			$boxEditMail.fadeOut();
		}
	});
})