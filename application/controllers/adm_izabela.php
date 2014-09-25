<?php

class Adm_Izabela extends WG_Controller
{
	public $layout = 'layout_izabela';


    public function index()
    {
       $this->output->render('adm_izabela/relatorios');
    }

    /**
        * Renderiza a página de upload de Excel (XLSX) que cadastrar o aluno
    */
	public function carga_aluno()
	{
		$this->output->render('adm_izabela/carga_aluno');
	}

    /**
        * Formulário de Cadastro de alunos
    */
    public function cadastrar_aluno()
    {
        $vars = [];

        $this->load->model('Usuario_Model');

        $filter_options = [
            'nome' => ['filter' => FILTER_SANITIZE_STRING ],
            'cpf' => [
                'filter' => FILTER_CALLBACK,
                'options' => function($cpf){
                    $is_valid = preg_match('/\d{3}\.\d{3}\.\d{3}-\d{2}/', $cpf);
                    return $is_valid ? preg_replace('/[^0-9]/', '', $cpf) : $data;
                }
            ],
            'matricula' => ['filter' => FILTER_VALIDATE_INT],
            'curso' =>['filter' => FILTER_SANITIZE_STRING]
        ];

        $data = filter_input_array(INPUT_POST, $filter_options);


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vars['post_data'] = $data;

            if (is_array($data) && !in_array(false, $data)) {

                $data['nivel'] = 1;


                $exists = $this->Usuario_Model->findByMatricula($data['matricula']);

                if (!$exists) {

                    $this->Usuario_Model->save($data);
                    $vars['post_status'] = 'Aluno cadastrado com sucesso.';

                } else {
                    $vars['post_status'] = 'A matrícula requisitada já existe no sistema.';
                }

            } else {
                $vars['post_status'] = 'Alguns campos apresentam dados inválidos.';
            }
        }

        $this->output->render('adm_izabela/cadastrar_aluno', $vars);

    }


	/**
        * Pesquisa de alunos do usuário Administrador do Izabela Hendrix
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
    }

}