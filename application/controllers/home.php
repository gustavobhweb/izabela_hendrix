<?php 

class Home extends CI_Controller {

	public function login()
	{
		$this->load->view('home/login');
	}

	public function inicial()
	{
		$this->load->view('home/inicial');
	}

	public function avisos()
	{
		$this->load->view('home/avisos');
	}

	public function acompanhar()
	{
		$this->load->view('home/acomp');
	}
	
}