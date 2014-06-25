<?php

class Usuario_Model extends CI_Model{


    public $table = 'tbl_usuarios';
    public $primaryKey = 'cod_usuario';


    public function findByMatricula($matricula)
    {
        return $this->db->get_where($this->table, ['matricula' => $matricula])->row();
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
            unset($usuario['nivel']);
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

}