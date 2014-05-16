<?php

class Solicitacao_Model extends CI_Model{
	
	public function select($args, $num=null)
	{
		if(is_null($args))
		{
			if($num)
			{
				return $this->db->query('SELECT * FROM tbl_solicitacoes')->num_rows();
			}
			else
			{
				return $this->db->query('SELECT * FROM tbl_solicitacoes')->result();
			}
		}
		else
		{
			$args = (int)$args;
			$qr = 'SELECT * FROM tbl_solicitacoes WHERE tbl_usuarios_cod_usuario = ?';
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

	public function save($solicitacao)
	{
		$solicitacao = (object)$solicitacao;
		
		$qr = 'INSERT INTO tbl_solicitacoes VALUES(NULL, ?, ?, 1, 1, ?)';
		$bind = array($solicitacao->foto, '', (int)$this->session->userdata('cod_usuario'));

		return $this->db->query($qr, $bind);
	}

	public function selectNameStatus($cod)
	{
		$qr = 'SELECT titulo FROM tbl_status WHERE cod_status = ?';
		$bind = array($cod);
		return $this->db->query($qr, $bind)->row()->titulo;
	}

	public function selectFotosAprovar()
	{
		return $this->db->query('SELECT * FROM tbl_solicitacoes WHERE tbl_status_cod_status = 1')->result();
	}

	public function aprovar($cod)
	{
		return $this->db->query('UPDATE tbl_solicitacoes SET tbl_status_cod_status = 2 WHERE cod_solicitacao = ?', array($cod));
	}

	public function reprovar($cod)
	{
		return $this->db->query('DELETE FROM tbl_solicitacoes WHERE cod_solicitacao = ?', array($cod));
	}

}