<?php

class Adm extends CI_Controller{
	
	public function inicial()
	{
		if($this->session->userdata('tbl_niveis_cod_nivel')==1)
		{
			redirect('home/inicial');
			exit;
		}
		$this->load->model('Solicitacao_Model');

		$viewData = array();

		$viewData['user'] = (object)$this->session->all_userdata();
		$viewData['fotos'] = $this->Solicitacao_Model->selectFotosAprovar();

		$this->load->view('adm/inicial', $viewData);
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