<?php

class WG_Controller extends CI_Controller
{
	public $autorized = [
		1 => ['home'],
		2 => ['home', 'adm']
	];

	public $loginAction = 'home/login';

	protected function _isAutorized($role_id)
	{	

		if (!isset($this->autorized[$role_id])) {
			return false;
		} else {
			$autorizedControllers = $this->autorized[$role_id];	
			return in_array($this->_name(), $autorizedControllers, true);
		}
	}

	protected function _name()
	{
		return strtolower(get_class($this));
	}

	protected function _isAllowedMethod($method)
	{
		return in_array($method, $this->allowedActions, true);
	}

	public function beforeAction($method = '')
	{	
		$role_id = $this->session->userdata('tbl_niveis_cod_nivel');

		if (!$this->_isAllowedMethod($method) && !$this->_isAutorized($role_id)) {
			redirect($this->loginAction);
			exit;
		}
	}
}