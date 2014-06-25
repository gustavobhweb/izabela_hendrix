<?php

class Adm extends WG_Controller
{
    public $layout = 'layout_admin';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Usuario_Model');

        $this->viewVars['user'] = (object) $this->session->all_userdata();
    }

    public function index()
    {
        $this->inicial();
    }
    
    public function inicial()
    {   
        $this->load->model('Solicitacao_Model');

        $viewData = array();

        $viewData['user'] = (object)$this->session->all_userdata();
        $viewData['fotos'] = $this->Solicitacao_Model->selectFotosAprovar();

        $this->output->render('adm/inicial', $viewData);
    }

    public function aprovar()
    {
        header('Content-Type: application/json');

        $this->load->model('Aviso_Model');
        $this->load->model('Usuario_Model');
        $this->load->model('Solicitacao_Model');
        $aviso = array();
        $aviso['assunto'] = 'Foto aprovada';
        $aviso['remetente'] = 'Grupo TMT';
        $aviso['mensagem'] = 'A sua foto de carteira estudantil foi aprovada!';
        $aviso['usuario'] = $this->Usuario_Model->select($this->input->post('pessoa'))  ;
        $this->Aviso_Model->save($aviso);
        $this->Solicitacao_Model->aprovar($this->input->post('cod'));

        echo json_encode(array('success' => true));
    }

    public function reprovar()
    {
        header('Content-Type: application/json');

        $this->load->model('Aviso_Model');
        $this->load->model('Usuario_Model');
        $this->load->model('Solicitacao_Model');
        $aviso = array();
        $aviso['assunto'] = 'Foto reprovada';
        $aviso['remetente'] = 'Grupo TMT';
        $aviso['mensagem'] = 'A sua foto de carteira estudantil foi reprovada! Envie a solicitação novamente.';
        $aviso['usuario'] = $this->Usuario_Model->select($this->input->post('pessoa'));
        $this->Aviso_Model->save($aviso);
        $this->Solicitacao_Model->reprovar($this->input->post('cod'));

        echo json_encode(array('success' => true));
    }

    public function pesquisar_solicitacoes()
    {
        $viewData = [];

        $this->load->model('Solicitacao_Model');

        $filter_name = filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_STRING);

        if (in_array($filter_name, ['matricula', 'nome'] , true)) {

            $filter_options = [
                'valor' => [
                    'filter' => FILTER_SANITIZE_STRING | FILTER_SANITIZE_ENCODED
                ]
            ];

        } elseif (in_array($filter_name, ['cpf', 'via'], true)) {

            $filter_options = [
                'valor' => [
                    'filter' => FILTER_SANITIZE_NUMBER_INT
                ]
            ];

        }

        if (isset($filter_options)) {

            $filter = filter_input_array(INPUT_GET, $filter_options);
            $viewData['filter_name'] = $filter_name;
            $viewData['search_keyword'] = $filter['valor'];
            $viewData['search_results'] = $this->Solicitacao_Model
                                                ->likeSearchWithUser($filter_name, $filter['valor']);
        }


        $this->output->render('adm/pesquisar_solicitacoes', $viewData);
    }

}