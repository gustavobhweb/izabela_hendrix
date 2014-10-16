$(document).ready(function(){

	var $pesquisar_admin = $('#admin-formulario-pesquisa-aluno');
	var $keyword_input = $pesquisar_admin.find('#keyworkd-search');

	$('.wm-input').on('change', function(){
		$keyword_input.focus();
		switch ($(this).val()) {
			default:
			case 'nome':
				$keyword_input.attr('placeholder', 'Pesquisar pelo nome');
				break;
			case 'cpf':
				$keyword_input.attr('placeholder', 'Pesquisar pelo CPF');
				break;
			case 'matricula':
                $keyword_input.attr('placeholder', 'Pesquisar pela matrícula');
                break;
            case 'remessa':
                $keyword_input.attr('placeholder', 'Pesquisar pela remessa');
                break;
		}
	});

	$pesquisar_admin.submit(function(){
		var value = $keyword_input.val();
	});

	$('.imgTooltip').tooltip({
        content: function() {
            return "<img width='200' height='267' src='" + $(this).attr('src') + "' />";
        },
        track: true
    });

    $('.btn-mais-info').on('click', function(){
    	var $thisContext = $(this);
    	$.ajax({
    		url: 'ajaxGetDataFromUser',
    		type: 'POST',
    		dataType: 'json',
    		data: {
    			cod_usuario: $thisContext.data('id')
    		},
    		success: function(response){
                var dataResponse = {
                    nome: (response.nome != null) ? response.nome : '-',
                    matricula: (response.matricula != null) ? response.matricula : '-',
                    cpf: (response.cpf != null) ? response.cpf : '-',
                    curso: (response.curso != null) ? response.curso : '-',
                    modelo: (response.modelo != null) ? response.modelo : '-',
                    status: (response.status != null) ? response.status : 'Aguardando solicitação'
                }
    			var html = '<div class="infouser-modal">';
    			    	html += '<div style="float:left;width:50%;text-align:left">';
    						html += '<img onerror="this.src = \'/static/img/user.png\'" src="/static/imagens/'+response.foto+'" height="300" width="225" />';
    					html += '</div>';

    					html += '<table>';
                            html += '<tr>';
                                html += '<td>Nome</td>';
                                html += '<td>' + dataResponse.nome + '</td>';
                            html += '</tr>';
    						html += '<tr>';
    							html += '<td>Matrícula</td>';
    							html += '<td>' + dataResponse.matricula + '</td>';
    						html += '</tr>';
    						html += '<tr>';
    							html += '<td>CPF</td>';
    							html += '<td>' + dataResponse.cpf + '</td>';
    						html += '</tr>';
    						html += '<tr>';
    							html += '<td>Curso</td>';
    							html += '<td>' + dataResponse.curso + '</td>';
    						html += '</tr>';
    						html += '<tr>';
    							html += '<td>Modelo</td>';
    							html += '<td>' + dataResponse.modelo + '</td>';
    						html += '</tr>';
    						html += '<tr>';
    							html += '<td>Status</td>';
    							html += '<td>' + dataResponse.status + '</td>';
    						html += '</tr>';
    					html += '</table>';

    					html += '<div style="clear:both"></div>';
    				html += '</div>';
    			new wmDialog(html, {
    				width: 520,
    				height: 440,
    				isHTML: true,
    				title: response.nome
    			}).open();
    		},
    		error: function(){
    			new wmDialog('Problemas na conexão! Atualize a página e tente novamente.', {
    				width: 320,
    				height: 130
    			}).open();
    		}
    	});
    });

});