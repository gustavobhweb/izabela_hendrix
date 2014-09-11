<?php

class Solicitacao_Model extends CI_Model{

    public $table = 'tbl_solicitacoes';
    public $primaryKey = 'cod_solicitacao';
    public $tableUser = [
        'name' => 'tbl_usuarios',
        'foreignKey' => 'tbl_usuarios_cod_usuario',
        'primaryKey' => 'cod_usuario'
    ];
    
    public function select($args, $num = null)
    {
        if(is_null($args))
        {
            if($num) {
                return $this->db->query("SELECT * FROM {$this->table}")->num_rows();
            } else {
                return $this->db->query("SELECT * FROM {$this->table}")->result();
            }
        }
        else
        {
            $args = (int)$args;
            $qr = "SELECT * FROM {$this->table} WHERE tbl_usuarios_cod_usuario = ?";
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

    public function ___save(array $data)
    {
        $pk_value = $data[$this->tableUser['primaryKey']]   ;
        $fk_name = $this->tableUser['foreignKey'];
        $exists = $this->db->get_where($this->table, [$fk_name => $pk_value])->num_rows;

        if (!$exists) {
            return $this->db->insert($this->table, $data);
        } else {
            return $this->db->where([$fk_name => $pk_value])
                            ->update($this->table, $data);
        }

    }

    public function save($solicitacao)
    {
        $solicitacao = (object)$solicitacao;
        
        $qr = "INSERT INTO {$this->table}(cod_solicitacao,
                                          foto,
                                          email,
                                          via,
                                          tbl_status_cod_status,
                                          tbl_modelos_cod_modelo,
                                          tbl_usuarios_cod_usuario)
              VALUES(NULL, ?, ?, 1, 1, 1, ?)";
        $bind = array($solicitacao->foto, $solicitacao->email, (int)$this->session->userdata('cod_usuario'));

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
        return $this->db->query("UPDATE {$this->table} SET tbl_status_cod_status = 2 WHERE {$this->primaryKey} = ?", array($cod));
    }

    public function reprovar($cod)
    {
        return $this->db->query("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?", array($cod));
    }

    private function _whitUser()
    {
        $fk = $this->tableUser['foreignKey'];
        $user = $this->tableUser['name'];       
        $pk = $this->tableUser['primaryKey'];

        $query = "SELECT * FROM {$this->table} as s
        LEFT JOIN {$user} AS u ON s.{$fk} = u.{$pk} ";

        return $query;
    }

    public function likeSearchWithUser($fieldname, $value)
    {
        $value = "%$value%";

        $query = $this->_whitUser();
        $query .= "WHERE {$fieldname} LIKE '{$value}'";

        return $this->db->query($query)->result_array();
    }

    public function searchWithUser($fieldname, $value)
    {
        $query = $this->_whitUser();
        $query .= "WHERE {$fieldname} = '{$value}'";

        return $this->db->query($query)->result_array();    
    }

}