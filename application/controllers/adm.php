<?php

class Adm extends CI_Controller{


	public $layout = 'layout_admin';

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Usuario_Model');

		$this->viewVars['user'] = (object) $this->session->all_userdata();
	}
	
	public function inicial()
	{
		if ($this->session->userdata('tbl_niveis_cod_nivel') == 1) {
			redirect('home/inicial');
			exit;
		}
		
		$this->load->model('Solicitacao_Model');

		$viewData = array();

		$viewData['user'] = (object)$this->session->all_userdata();
		$viewData['fotos'] = $this->Solicitacao_Model->selectFotosAprovar();

		$this->output->render('adm/inicial', $viewData);
	}

	public function pesquisar()
	{
		$viewData = [];


		$filter_name = filter_input(INPUT_GET, 'filtro', FILTER_SANITIZE_STRING);


		// Deixemos assim, porque não sabemos se terá mais opçoes futuramente //
		if ($filter_name == 'matricula') {

			$filter_options = [
				'valor' => [
					'filter' => FILTER_SANITIZE_STRING
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
					'filter' => FILTER_SANITIZE_STRING
				]
			];

		}

		// Significa que a pesquisa é válida //
		if (isset($filter_options)) {

			$filter = filter_input_array(INPUT_GET, $filter_options);

			$viewData['filter_name'] = $filter_name;
			$viewData['search_results'] = $this->Usuario_Model->search($filter_name, $filter['valor']);

		}

		$this->output->render('adm/pesquisar', $viewData);

		unset($viewData);
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
		$aviso['usuario'] = $this->Usuario_Model->select($this->input->post('pessoa'))	;
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

}