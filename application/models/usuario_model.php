<?php

class Usuario_Model extends CI_Model{

	public function select($args=null, $num=false)
	{
		if(is_null($args))
		{
			if($num)
			{
				return $this->db->query('SELECT * FROM tbl_usuarios')->num_rows();
			}
			else
			{
				return $this->db->query('SELECT * FROM tbl_usuarios')->result();
			}
		}
		else if(is_array($args))
		{
			$args = (object)$args;
			$qr = 'SELECT * FROM tbl_usuarios WHERE cpf = ? AND matricula = ?';
			$bind = array($args->cpf, $args->matricula);
			if($num)
			{
				return $this->db->query($qr, $bind)->num_rows();
			}
			else
			{
				return $this->db->query($qr, $bind)->row();
			}	
		}
		else
		{
			$args = (int)$args;
			$qr = 'SELECT * FROM tbl_usuarios WHERE cod_usuario = ?';
			$bind = array($args);
			if($num)
			{
				return $this->db->query($qr, $bind)->num_rows();
			}
			else
			{
				return $this->db->query($qr, $bind)->row();
			}
		}
	}

	public function save($usuario)
	{
		$usuario = (object)$usuario;
		if(isset($usuario->cod_usuario))
		{
			$qr = 'UPDATE tbl_usuarios SET matricula = ?, cpf = ?, nome = ?, tbl_niveis_cod_nivel = ? WHERE cod_usuario = ?';
			$bind = array($usario->matricula, $usuario->cpf, $usuario->nome, $usuario->cod_usuario, $usuario->nivel);
		}
		else
		{
			$qr = 'INSERT INTO tbl_usuarios VALUES(NULL, ?, ?, ?, ?)';
			$bind = array($usuario->matricula, $usuario->cpf, $usuario->nome, (int)$usuario->nivel);
		}
		return $this->db->query($qr, $bind);
	}

	public function delete($args)
	{
		$qr = 'DELETE FROM tbl_usuarios WHERE cod_usuario = ?';
		$bind = array($args);
		return $this->db->query($qr, $bind);
	}

	public function verify($args)
	{
		$args = (object)$args;
		$qr = 'SELECT * FROM tbl_usuarios WHERE cpf = ? AND matricula = ?';
		$bind = array($args->cpf, $args->matricula);
		return $this->db->query($qr, $bind)->num_rows();
	}

	public function authenticate()
	{
		if(!$this->session->userdata('cpf') || !$this->session->userdata('matricula'))
		{
			redirect('home/login');
		}
		else
		{
			$cpf = $this->session->userdata('cpf');
			$matricula = $this->session->userdata('matricula');
			$user = array('cpf' => $cpf, 'matricula' => $matricula);
			if(!$this->verify($user))
			{
				redirect('home/login');
			}
			else if($this->session->userdata('tbl_niveis_cod_nivel')==2)
			{
				redirect('adm/inicial');
			}
		}
	}

}