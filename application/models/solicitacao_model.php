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
        if (is_null($args)) {
            if($num) {
                return $this->db->query("SELECT * FROM {$this->table}")->num_rows();
            } else {
                return $this->db->query("SELECT * FROM {$this->table}")->result();
            }
        } else {
            $args = (int)$args;
            $qr = "SELECT * FROM {$this->table} WHERE tbl_usuarios_cod_usuario = ?";
            $bind = array($args);
            if ($num) {
                return $this->db->query($qr, $bind)->num_rows();
            } else {
                return $this->db->query($qr, $bind)->result();
            }
        }
    }

    public function ___save(array $data)
    {
        $pk_value = $data[$this->tableUser['primaryKey']];
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
                                          tbl_usuarios_cod_usuario,
                                          dataSolicitacao)
              VALUES(NULL, ?, ?, 1, 1, 1, ?, ?)";
        $bind = array(
            $solicitacao->foto, 
            $solicitacao->email, 
            (int)$this->session->userdata('cod_usuario'),
            $solicitacao->data
        );

        return $this->db->query($qr, $bind);
    }

    public function selectNameStatus($cod)
    {
        $qr = 'SELECT titulo FROM tbl_status WHERE cod_status = ?';
        $bind = array($cod);
        return $this->db->query($qr, $bind)->row()->titulo;
    }

    public function selectNameModelo($cod)
    {
        $qr = 'SELECT titulo FROM tbl_modelos WHERE cod_modelo = ?';
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

    public function countStatus($cod_status)
    {
        $qr = 'SELECT COUNT(*) as count FROM tbl_solicitacoes WHERE tbl_status_cod_status = ?';
        $bind = array($cod_status);
        return $this->db->query($qr, $bind)->row()->count;
    }

    public function byStatus($cod_status, $num = false, $paginate = false)
    {
        $qr = 'SELECT tbl_solicitacoes.cod_solicitacao as cod_solicitacao,
                      tbl_solicitacoes.foto as foto,
                      tbl_solicitacoes.email as email,
                      tbl_solicitacoes.via as via,
                      tbl_solicitacoes.dataSolicitacao as dataSolicitacao,
                      tbl_solicitacoes.dataFabricacao as dataFabricacao,
                      tbl_solicitacoes.dataConferencia as dataConferencia,
                      tbl_solicitacoes.dataDisponivel as dataDisponivel,
                      tbl_solicitacoes.dataEntregue as dataEntregue,
                      tbl_status.titulo as status,
                      tbl_modelos.titulo as modelo,
                      tbl_usuarios.nome as nome,
                      tbl_usuarios.curso as curso,
                      tbl_usuarios.matricula as matricula,
                      tbl_usuarios.cpf as cpf,
                      tbl_usuarios.cod_usuario as cod_usuario
                      FROM tbl_solicitacoes JOIN tbl_status 
                      ON tbl_status.cod_status = tbl_solicitacoes.tbl_status_cod_status
                      JOIN tbl_modelos ON tbl_modelos.cod_modelo = tbl_solicitacoes.tbl_modelos_cod_modelo
                      JOIN tbl_usuarios ON tbl_usuarios.cod_usuario = tbl_solicitacoes.tbl_usuarios_cod_usuario 
                      WHERE tbl_solicitacoes.tbl_status_cod_status = ? 
                      LIMIT ?, ?';

        if (!$paginate) {
            $paginate = new stdClass;
            $paginate->start = 0;
            $paginate->limit = 100000000000;
        }


        $bind = [
            $cod_status, 
            $paginate->start,  
            $paginate->limit
        ];

        if (!$num) {
            return $this->db->query($qr, $bind)->result();
        } else {
            return $this->db->query($qr, $bind)->num_rows();
        }
    }

}