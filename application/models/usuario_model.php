<?php

class Usuario_Model extends CI_Model{


    public $table = 'tbl_usuarios';
    public $primaryKey = 'cod_usuario';


    public function findByMatricula($matricula)
    {
        return $this->db->get_where($this->table, ['matricula' => $matricula])->row();
    }

    public function findByCpf($cpf)
    {
    	$cpf = str_replace('.', '', $cpf);
    	$cpf = str_replace('-', '', $cpf);

        return $this->db->get_where($this->table, ['cpf' => $cpf])->row();
    }

    public function search($tipo, $valor)
    {
        $where = array($tipo => $valor);

        if($tipo == 'matricula' || $tipo == 'cpf') {
            $result = $this->db->where($where)->get($this->table);
        } elseif($tipo == 'nome') {
            $result = $this->db->like($where)->get($this->table);
        } else {
            return false;
        }

        return !empty($result) ? $result->result_array() : false;
    }

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
        $pk = $this->primaryKey;
        $exists = array_key_exists($pk, $usuario)
                && $this->db->where([$pk => $usuario[$pk]])
                        ->get()
                        ->num_rows;

        if (array_key_exists('nivel', $usuario)) {
            $usuario['tbl_niveis_cod_nivel'] = $usuario['nivel'];
            $usuario['tbl_modelos_cod_modelo'] = $usuario['modelo'];
            $usuario['remessa'] = $this->remessa();
            unset($usuario['nivel']);
            unset($usuario['modelo']);
        }

        if (!$exists) {
            $this->db->insert($this->table, $usuario);
        } else {
            $this->db->update(
                $this->table,
                $usuario,
                [$pk => $usuario[$pk]]
            );
        }

    }

    public function remessa()
    {
        $qr = 'SELECT MAX(remessa) as remessa
               FROM tbl_usuarios
               LIMIT 1';
        $bind = array();

        $remessa = (int) ($this->db->query($qr, $bind)->row()->remessa) + 1;
        return sprintf('%06s', $remessa);
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
        if(!$this->session->userdata('cpf') || !$this->session->userdata('matricula')) {
            redirect('home/login');
        } else {
            $cpf = $this->session->userdata('cpf');
            $matricula = $this->session->userdata('matricula');
            $user = array('cpf' => $cpf, 'matricula' => $matricula);

            if (!$this->verify($user)) {
                redirect('home/login');
            } elseif($this->session->userdata('tbl_niveis_cod_nivel') == 2) {
                redirect('adm/inicial');
            }
        }
    }

    public function getAlunos($searchType, $value, $count = false, $paginate = false)
    {
    	$qrType = '';
    	$bind = array();

        if (!$paginate) {
            $paginate = new stdClass;
            $paginate->start = 0;
            $paginate->limit = 100000000000;
        }

    	switch ($searchType) {
    		default:
    		case 'nome':
    			$qrType = 'tbl_usuarios.nome LIKE ?';
    			$bind = [ 
                    '%' . $value . '%', 
                    $paginate->start, 
                    $paginate->limit 
                ];
    			break;
    		case 'matricula':
    			$qrType = 'tbl_usuarios.matricula = ?';
    			$bind = [
                    (int) $value,
                    $paginate->start, 
                    $paginate->limit 
                ];
    			break;
    		case 'cpf':
                $qrType = 'tbl_usuarios.cpf = ?';
                $bind = [
                    $value,
                    $paginate->start,
                    $paginate->limit
                ];
                break;
            case 'remessa':
                $qrType = 'tbl_usuarios.remessa = ?';
                $bind = [
                    $value,
                    $paginate->start,
                    $paginate->limit
                ];
                break;
    	}

    	$qr = 'SELECT tbl_usuarios.cod_usuario as cod_usuario,
    		   	      tbl_usuarios.matricula as matricula,
    		   	      tbl_usuarios.cpf as cpf,
    		   	      tbl_usuarios.nome as nome,
    		   	      tbl_usuarios.curso as curso,
                      tbl_usuarios.dataRemessa as dataRemessa,
    		   	      tbl_niveis.titulo as nivel,
    		   	      tbl_modelos.titulo as modelo,
    		   	      tbl_status.titulo as status,
    		   	      tbl_solicitacoes.foto as foto
    		   	      FROM tbl_usuarios LEFT JOIN tbl_niveis
    		   	      	ON tbl_niveis.cod_nivel = tbl_usuarios.tbl_niveis_cod_nivel
    		   	      LEFT JOIN tbl_modelos 
    		   	      	ON tbl_modelos.cod_modelo = tbl_usuarios.tbl_modelos_cod_modelo
    		   	      LEFT JOIN tbl_solicitacoes
    		   	      	ON tbl_solicitacoes.tbl_usuarios_cod_usuario = tbl_usuarios.cod_usuario
    		   	      LEFT JOIN tbl_status 
    		   	      	ON tbl_status.cod_status = tbl_solicitacoes.tbl_status_cod_status
    		   	      WHERE tbl_niveis.cod_nivel = 1
    		   	      AND ' . $qrType . '
                      LIMIT ?, ?
                      ';
    	
        if (!$count) {
        	return $this->db->query($qr, $bind)->result();
        } else {
            return $this->db->query($qr, $bind)->num_rows();
        }
    }

    public function getData($cod_usuario)
    {
    	$qr = 'SELECT tbl_usuarios.cod_usuario as cod_usuario,
    		   	      tbl_usuarios.matricula as matricula,
    		   	      tbl_usuarios.cpf as cpf,
    		   	      tbl_usuarios.nome as nome,
    		   	      tbl_usuarios.curso as curso,
    		   	      tbl_niveis.titulo as nivel,
    		   	      tbl_modelos.titulo as modelo,
    		   	      tbl_status.titulo as status,
    		   	      tbl_solicitacoes.foto as foto
    		   	      FROM tbl_usuarios LEFT JOIN tbl_niveis
    		   	      	ON tbl_niveis.cod_nivel = tbl_usuarios.tbl_niveis_cod_nivel
    		   	      LEFT JOIN tbl_modelos 
    		   	      	ON tbl_modelos.cod_modelo = tbl_usuarios.tbl_modelos_cod_modelo
    		   	      LEFT JOIN tbl_solicitacoes
    		   	      	ON tbl_solicitacoes.tbl_usuarios_cod_usuario = tbl_usuarios.cod_usuario
    		   	      LEFT JOIN tbl_status 
    		   	      	ON tbl_status.cod_status = tbl_solicitacoes.tbl_status_cod_status
    		   	      WHERE tbl_usuarios.cod_usuario = ?';
    	$bind = [$cod_usuario];

    	return $this->db->query($qr, $bind)->row();
    }

    public function getRemessas($num = false, $paginate = false)
    {
        if (!$paginate) {
            $paginate = new stdClass;
            $paginate->start = 0;
            $paginate->limit = 100000000000;
        }

        $qr = 'SELECT remessa, dataRemessa, COUNT(cod_usuario) as count
               FROM tbl_usuarios 
               WHERE tbl_niveis_cod_nivel = 1 
               GROUP BY remessa
               LIMIT ?, ?';

        $bind = [$paginate->start, $paginate->limit];

        if ($num) {
            return $this->db->query($qr, $bind)->num_rows();
        } else {
            return $this->db->query($qr, $bind)->result();
        }
    }

}