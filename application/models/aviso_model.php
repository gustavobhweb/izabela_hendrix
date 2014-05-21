<?php

class Aviso_Model extends CI_Model{

	/**
		* Gustavo, no padrão de projeto é sempre bom definir um nome em um lugar só
		* para que quando haja alterações no nome de tabela não ter que alterar todo o código
	*/

	public $table = 'tbl_avisos';
	public $primaryKey = 'cod_aviso';


	public function find($pk_value)
	{
		$result = $this->db
						->where($this->primaryKey, $pk_value)
						->get($this->table);

		return isset($result->num_rows) ? $result->row() : false;
	}

	public function notReadCount($user_id)
	{		
		return $this->db
					->where('tbl_usuarios_cod_usuario', $user_id)
					->where('lido', 0)
					->get($this->table)
					->num_rows();
	}
	
	public function select($args, $num=null)
	{
		if(is_null($args))
		{
			if($num)
			{
				return $this->db->query("SELECT * FROM {$this->table}")->num_rows();
			}
			else
			{
				return $this->db->query("SELECT * FROM {$this->table}")->result();
			}
		}
		else
		{
			$args = (int)$args;
			$qr = "SELECT * FROM {$this->table} WHERE tbl_usuarios_cod_usuario = ?";
			$bind = array($args);

			if($num) {
				return $this->db->query($qr, $bind)->num_rows();
			} else {
				return $this->db->query($qr, $bind)->result();
			}
		}
	}

	public function save($aviso)
	{
		$aviso = (object)$aviso;
		$aviso->usuario = (object)$aviso->usuario;
		if(isset($aviso->cod_aviso))
		{
			$qr = "UPDATE {$this->table} SET assunto = ?, remetente = ?, mensagem = ?, tbl_usuarios_cod_usuario = ? WHERE cod_aviso = ?";
			$bind = array($aviso->assunto, $aviso->remetente, $aviso->mensagem, $aviso->cod_aviso, $aviso->usuario->cod_usuario);
		}
		else
		{
			$qr = "INSERT INTO {$this->table} VALUES(NULL, ?, ?, ?, 0, ?)";
			$bind = array($aviso->assunto, $aviso->remetente, $aviso->mensagem, (int)$aviso->usuario->cod_usuario);
		}
		return $this->db->query($qr, $bind);
	}

	public function delete($args)
	{
		$qr = "DELETE FROM {$this->table} WHERE cod_aviso = ?";
		$bind = array($args);
		return $this->db->query($qr, $bind);
	}

}