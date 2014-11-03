$(document).ready(function(){
	var $frame = $('iframe[name=response_frame]');
	var $formXLS = $('#xls-upload-form');
	var $btn = $('#xls-submit');
	var $xlsFile = $(':file[name=xls]');

	$formXLS.submit(function(event) {
		if ($xlsFile.val() == '') {
			new wmDialog('Selecione um arquivo XLSX para enviar a carga.', {
    				width: 320,
    				height: 240,
    				isHTML: true,
    				title: 'Atenção'
    			}).open();
			return false;
		}

		$btn.html('Carregando...').attr('disabled', true);

		$frame.fadeIn(1500, function(){
			$btn.html('Enviar Carga').attr('disabled', false);
		});
	});
});