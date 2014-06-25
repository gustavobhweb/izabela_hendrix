<?php

class Adm_Izabela extends WG_Controller
{
	public $layout = 'layout_izabela';

	public function index()
	{
		$this->output->render('adm_Izabela/relatorios');
	}

    public function enviar_carga()
    {
        $this->output->render('adm_Izabela/index');
    }

    
	/**
        * Segundo o Gustavo, esse método não faz parte dessa classe :(
        * @author Wallace de Souza Vizerra
    */

    public function pesquisar_alunos()
    {
        $viewData = [];

        $this->load->model('Usuario_Model');

        $filter_name = filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_STRING);

        // Deixemos assim, porque não sabemos se terá mais opçoes futuramente //
        if ($filter_name == 'matricula') {

            $filter_options = [
                'valor' => [
                    'filter' => FILTER_SANITIZE_STRING | FILTER_SANITIZE_ENCODED
                ]
            ];

        } elseif($filter_name == 'cpf') {

            $filter_options = [
                'valor' => [
                    'filter' => FILTER_SANITIZE_NUMBER_INT
                ]
            ];

        } elseif($filter_name == 'nome') {
            $filter_options = [
                'valor' => [
                    'filter' => FILTER_SANITIZE_STRING | FILTER_SANITIZE_ENCODED
                ]
            ];

        }

        // Significa que a pesquisa é válida //
        if (isset($filter_options)) {

            $filter = filter_input_array(INPUT_GET, $filter_options);

            $viewData['filter_name'] = $filter_name;
            $viewData['search_keyword'] = $filter['valor'];
            $viewData['search_results'] = $this->Usuario_Model->search($filter_name, $filter['valor']);

        }

        $this->output->render('adm_izabela/pesquisar_alunos', $viewData);

        unset($viewData);
    }

}