$(document).ready(function(){

	var $pesquisar_admin = $('#admin-formulario-pesquisa-aluno');
	var $keyword_input = $pesquisar_admin.find('#keyworkd-search');

	$pesquisar_admin.submit(function(){
		var value = $keyword_input.val();
		if (value == '') {
			alert('Informe um valor para efetuar a pesquisa.');
			return false;
		}
	});

});