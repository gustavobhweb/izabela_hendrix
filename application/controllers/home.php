<?php


class Home extends WG_Controller {

    public $viewVars = array();
    public $allowedActions = ['login', 'sair', 'cadastrar'];


    public function index()
    {
        redirect('home/inicial');
    }


    public function login()
    {
        $this->layout = 'login';
        $viewData = array();
        $this->load->model('Usuario_Model');

        if($this->input->post('txt_cpf')) {
            $user = array();
            $user['cpf'] = str_replace('.', '', $this->input->post('txt_cpf'));
            $user['cpf'] = str_replace('-', '', $user['cpf']);
            $user['matricula'] = $this->input->post('txt_matricula');

            if($this->Usuario_Model->verify($user)) {
                $this->session->set_userdata($this->Usuario_Model->select($user));
                redirect('home/inicial');
            } else {
                $viewData['error'] = 'CPF ou matrícula estão incorretos.';
            }
        }

        $this->output->render('home/login', $viewData);
    }

    public function inicial()
    {
        $this->load->model('Usuario_Model');
        $this->load->model('Aviso_Model');
        $this->load->model('Solicitacao_Model');

        $this->Usuario_Model->authenticate();

        $cod_usuario = $this->session->userdata('cod_usuario');

        $viewData = array();
        $viewData['avisos'] = $this->Aviso_Model->select($cod_usuario);
        $viewData['avisosNum'] = count($viewData['avisos']);
        $viewData['solicitacoes'] = $this->Solicitacao_Model->select($cod_usuario);

        foreach ($viewData['solicitacoes'] as $k => $v) {
            $viewData['solicitacoes'][$k]->status = $this->Solicitacao_Model->selectNameStatus($viewData['solicitacoes'][$k]->tbl_status_cod_status);
        }

        $viewData['solicitacoesNum'] = $this->Solicitacao_Model->select($this->session->userdata('cod_usuario'), true);

        $this->output->render('home/inicial', $viewData);
    }

    public function avisos()
    {
        $this->load->model('Usuario_Model');
        $this->load->model('Aviso_Model');

        $this->Usuario_Model->authenticate();

        $cod_usuario = $this->session->userdata('cod_usuario');

        $viewData = array();
        $viewData['avisos'] = $this->Aviso_Model->select($cod_usuario);
        $viewData['avisosNum'] = $this->Aviso_Model->notReadCount($cod_usuario);

        $this->output->render('home/avisos', $viewData);
    }

    public function acompanhar()
    {
        $this->load->model('Usuario_Model');
        $this->load->model('Solicitacao_Model');

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $solicitacao = filter_input(INPUT_POST, 'solicitacao', FILTER_VALIDATE_INT);

            if (!$email || !$solicitacao) {
                $viewData['msgAlteracaoEmail'] = 'Informe um e-mail válido';
            } else {

                $this->db->update(
                    $this->Solicitacao_Model->table,
                    array('email' => $email),
                    array($this->Solicitacao_Model->primaryKey => $solicitacao)
                );

                $viewData['msgAlteracaoEmail'] = 'O e-mail foi atualizado com sucesso.';
            }
        }

        $this->Usuario_Model->authenticate();

        $viewData['solicitacoes'] = $this->Solicitacao_Model->select($this->session->userdata('cod_usuario'));
        $viewData['user'] = (object)$this->session->all_userdata();

        $viewData['solicitacoesNum'] = $this->Solicitacao_Model->select($this->session->userdata('cod_usuario'), true);

        $this->output->render('home/acomp', $viewData);
    }

    public function enviar_foto()
    {
        $this->load->model('Usuario_Model');
        $this->load->model('Solicitacao_Model');
        $this->load->model('Aviso_Model');

        if($this->Solicitacao_Model->select($this->session->userdata('cod_usuario'), true))
        {
            redirect('home/acompanhar');
        }

        $this->Usuario_Model->authenticate();

        $viewData = array();
        $viewData['user'] = (object)$this->session->all_userdata();


        $DS = DIRECTORY_SEPARATOR;
        $configs =  array(
          'upload_path'     => FCPATH . "static{$DS}imagens",
          'allowed_types'   => 'jpg|png|jpeg',
          'overwrite'       => true,
          'file_name'       => $this->session->userdata('matricula')
        );

        $this->load->library('upload', $configs);

        if($_POST && !$this->input->post('ckb')) {
            $viewData['message'] = 'Aceite os termos de uso!';
        } elseif(isset($_FILES['userfile'])) {
            $_FILES['userfile']['name'] = strtolower($_FILES['userfile']['name']);

            if(!$this->upload->do_upload('userfile')) {
               $nameFile = $this->input->post('webcam-upload');
                $solicitacao = array('foto' => $nameFile, 'email' => $this->input->post('email'));
                $this->Solicitacao_Model->save($solicitacao);
                redirect('home/acompanhar');
            } else {
                $nameFile = $this->session->userdata('matricula').'.'.pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
                $solicitacao = array('foto' => $nameFile, 'email' => $this->input->post('email'));
                $this->Solicitacao_Model->save($solicitacao);

                $aviso = array();
                $aviso['assunto'] = 'Solicitação realizada';
                $aviso['remetente'] = 'Grupo TMT';
                $aviso['mensagem'] = 'A sua solicitação de carteira estudantil foi enviada com sucesso! Aguarde pela aprovação de sua foto.';
                $aviso['usuario'] = $this->Usuario_Model->select($this->session->userdata('cod_usuario'));
                //$this->Aviso_Model->save($aviso);

                redirect('home/acompanhar');
                exit;
            }
        } elseif($this->input->post('webcam-upload')) {
            $nameFile = $this->input->post('webcam-upload');
            $solicitacao = array('foto' => $nameFile, 'email' => $this->input->post('email'));
            $this->Solicitacao_Model->save($solicitacao);
        }

        $this->output->render('home/enviar_foto', $viewData);
    }

    public function upload_webcam_image()
    {
        if ($this->input->post('type') == 'pixel') {
            $im = imagecreatetruecolor(320, 240);

            foreach (explode("|", $this->input->post('image')) as $y => $csv) {
                foreach (explode(";", $csv) as $x => $color) {
                    imagesetpixel($im, $x, $y, $color);
                }
            }
        } else {
            $im = imagecreatefrompng($this->input->post('image'));
        }

        $authID = $this->session->userdata('matricula');

        $path =  FCPATH . '/static/imagens/';

        if (!is_dir($path)) mkdir($path, 0777);

        $imageFormatName = $path . $authID . '.png';

        $imageName = sprintf($imageFormatName, '');

        imagepng($im, $imageName);
        imagedestroy($im);
    }

    public function aviso($cod)
    {
        $this->load->model('Usuario_Model');
        $this->load->model('Aviso_Model');

        $this->Usuario_Model->authenticate();

        $viewData = array();

        $viewData['aviso'] = $this->Aviso_Model->find($cod);

        $this->Aviso_Model->update(
            ['lido' => true],
            [$this->Aviso_Model->primaryKey => $cod]
        );

        $this->output->render('home/aviso', $viewData);
    }

    public function sair()
    {
        $this->session->unset_userdata(array('cpf', 'matricula'));
        $this->session->sess_destroy();
        redirect('home/login');
    }

    public function cadastrar()
    {
        $this->load->model('Usuario_Model');

        $user = array();
        $user['cpf'] = '11111111111';
        $user['matricula'] = '111111';
        $user['nome'] = 'Gustavo Carmo';
        $user['nivel'] = 1;
        $this->Usuario_Model->save($user);

        $user1 = array();
        $user1['cpf'] = '11111111122';
        $user1['matricula'] = '111122';
        $user1['nome'] = 'Gustavo Carmo';
        $user1['nivel'] = 2;
        $this->Usuario_Model->save($user1);

        $user2 = [
            'cpf' => '11111111133',
            'matricula' => '222222',
            'nome' => 'Wallace de souza',
            'tbl_niveis_cod_nivel' => 3,
            'curso' => 'Programador PHP'
        ];

        $this->Usuario_Model->save($user2);
    }

    public function snapwebcam()
    {
        $matricula = $this->session->userdata('matricula');

        $dir = 'static/imagens/' . $matricula . '/';
        if (!is_dir($dir)) mkdir($dir, 0777);
        $filename = 'temp.png';
        $fullurl = $dir.$filename;

        list($width, $height) = getimagesize($fullurl);

        $im = imagecreatefromstring(base64_decode($this->input->post('file')));

        $dest = imagecreatetruecolor(width, height);
        // imagecopyresampled($dest, $im, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);

        imagepng($im, $dir . $filename);
    }

}