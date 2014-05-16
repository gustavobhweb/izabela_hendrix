<?php

class Aviso_Model extends CI_Model{
	
	public function select($args, $num=null)
	{
		if(is_null($args))
		{
			if($num)
			{
				return $this->db->query('SELECT * FROM tbl_avisos')->num_rows();
			}
			else
			{
				return $this->db->query('SELECT * FROM tbl_avisos')->result();
			}
		}
		else
		{
			$args = (int)$args;
			$qr = 'SELECT * FROM tbl_avisos WHERE tbl_usuarios_cod_usuario = ?';
			$bind = array($args);
			if($num)
			{
				return $this->db->query($qr, $bind)->num_rows();
			}
			else
			{
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
			$qr = 'UPDATE tbl_avisos SET assunto = ?, remetente = ?, mensagem = ?, tbl_usuarios_cod_usuario = ? WHERE cod_aviso = ?';
			$bind = array($aviso->assunto, $aviso->remetente, $aviso->mensagem, $aviso->cod_aviso, $aviso->usuario->cod_usuario);
		}
		else
		{
			$qr = 'INSERT INTO tbl_avisos VALUES(NULL, ?, ?, ?, 0, ?)';
			$bind = array($aviso->assunto, $aviso->remetente, $aviso->mensagem, (int)$aviso->usuario->cod_usuario);
		}
		return $this->db->query($qr, $bind);
	}

	public function delete($args)
	{
		$qr = 'DELETE FROM tbl_avisos WHERE cod_aviso = ?';
		$bind = array($args);
		return $this->db->query($qr, $bind);
	}

}