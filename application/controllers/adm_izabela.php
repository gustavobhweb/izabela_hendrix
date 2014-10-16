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
            'curso' =>['filter' => FILTER_SANITIZE_STRING],
            'modelo' =>['filter' => FILTER_VALIDATE_INT]
        ];

        $data = filter_input_array(INPUT_POST, $filter_options);


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vars['post_data'] = $data;

            if (is_array($data) && !in_array(false, $data)) {

                $data['nivel'] = 1;


                $exists = $this->Usuario_Model->findByMatricula($data['matricula']);
                $existsCpf = $this->Usuario_Model->findByCpf($data['cpf']);

                if ($exists) {
                	$vars['post_status'] = 'A matrícula requisitada já existe no sistema.';
                } elseif ($existsCpf) {
                	$vars['post_status'] = 'O CPF informado já foi cadastrado no sistema.';
                } else {
                    $this->Usuario_Model->save($data);
                	$vars['post_status'] = 'Aluno cadastrado com sucesso.';
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
        $this->load->library([
            'Utility',
            'Paginate'
        ]);

        $filter_name = filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_STRING);

        // Deixemos assim, porque não sabemos se terá mais opçoes futuramente //
        if ($filter_name == 'matricula') {
            $filter_options = [
                'valor' => [
                    'filter' => FILTER_SANITIZE_STRING | FILTER_SANITIZE_ENCODED
                ]
            ];
        } elseif ($filter_name == 'cpf') {
            $filter_options = [
                'valor' => [
                    'filter' => FILTER_SANITIZE_NUMBER_INT
                ]
            ];
        } elseif ($filter_name == 'nome') {
            $filter_options = [
                'valor' => [
                    'filter' => FILTER_SANITIZE_STRING | FILTER_SANITIZE_ENCODED
                ]
            ];
        } elseif ($filter_name == 'remessa'){
            $filter_options = [
                'valor' => [
                    'filter' => FILTER_SANITIZE_NUMBER_INT
                ]
            ];
        }

        // Significa que a pesquisa é válida //
        if (isset($filter_options)) {

            $filter = filter_input_array(INPUT_GET, $filter_options);

            $viewData['filter_name'] = $filter_name;
            $viewData['search_keyword'] = $filter['valor'];

            $viewData['paginate'] = new Paginate();
            $viewData['paginateMake'] = $viewData['paginate']->make($this->Usuario_Model->getAlunos($filter_name, $filter['valor'], true));

            $viewData['alunos'] = $this->Usuario_Model->getAlunos($filter_name, $filter['valor'], false, $viewData['paginate']->getData());
            $viewData['Utility'] = new Utility();

        }

        $viewData['backBtn'] = ($this->input->get('voltar')) ? filter_var($this->input->get('voltar'), FILTER_VALIDATE_BOOLEAN) : $this->input->get('voltar');

        $this->output->render('adm_izabela/pesquisar_alunos', $viewData);
    }

    public function ajaxGetDataGraph()
    {
        $this->load->library('JsonResponse');
        $this->load->model('Solicitacao_Model');

        $response = [
            'analise' => (int) $this->Solicitacao_Model->countStatus(1),
            'fabricacao' => (int) $this->Solicitacao_Model->countStatus(2),
            'conferencia' => (int) $this->Solicitacao_Model->countStatus(3),
            'disponivel' => (int) $this->Solicitacao_Model->countStatus(4),
            'entregue' => (int) $this->Solicitacao_Model->countStatus(5)
        ];

        echo new JsonResponse($response);
    }

    public function relatorio()
    {
        $this->load->model('Solicitacao_Model');
        $this->load->library(['Utility', 'Paginate']);
        $viewData = array();
        $status = $this->input->get('status');

        $viewData['paginate'] = new Paginate();
        $viewData['paginateMake'] = $viewData['paginate']->make($this->Solicitacao_Model->byStatus($status, true));

        $viewData['status'] = ucfirst($this->Solicitacao_Model->selectNameStatus($status));
        $viewData['solicitacoes'] = $this->Solicitacao_Model->byStatus($status, false, $viewData['paginate']->getData());
        $viewData['Utility'] = new Utility();

        $this->output->render('adm_izabela/relatorio', $viewData);
    }
    
    public function ajaxGetDataFromUser()
    {
    	$this->load->library('JsonResponse');
    	$this->load->model('Usuario_Model');

    	echo new JsonResponse($this->Usuario_Model->getData($this->input->post('cod_usuario')));
    }

    public function cargas_enviadas()
    {
        $this->load->library('Paginate');
        $this->load->model('Usuario_Model');

        $viewData['paginate'] = new Paginate();
        $viewData['paginateMake'] = $viewData['paginate']->make($this->Usuario_Model->getRemessas(true));

        $viewData['remessas'] = $this->Usuario_Model->getRemessas(false, $viewData['paginate']->getData());

        $this->output->render('adm_izabela/cargas_enviadas', $viewData);
    }

}