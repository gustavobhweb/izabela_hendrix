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
            $viewData['solicitacoes'][$k]->modelo = $this->Solicitacao_Model->selectNameModelo($viewData['solicitacoes'][$k]->tbl_modelos_cod_modelo);
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

        if($_POST && !$this->input->post('ckb')) {
            $viewData['message'] = 'Aceite os termos de uso!';
        } elseif($this->input->post('sended')) {

            $ds = DIRECTORY_SEPARATOR;
            $tempFile = FCPATH . "{$ds}static{$ds}imagens{$ds}" . $viewData['user']->matricula . "{$ds}temp.png";
            $nameFile = md5(microtime()) . '.png';
            $newName = FCPATH . "{$ds}static{$ds}imagens{$ds}" . $viewData['user']->matricula . "{$ds}" . $nameFile;
            rename($tempFile, $newName);

            $solicitacao = array(
                'foto' => $viewData['user']->matricula . '/' . $nameFile,
                'email' => $this->input->post('email'),
                'tbl_modelos_cod_modelo' => $viewData['user']->tbl_modelos_cod_modelo
            );
            $this->Solicitacao_Model->save($solicitacao);

            $aviso = array();
            $aviso['assunto'] = 'Solicitação realizada';
            $aviso['remetente'] = 'Grupo TMT';
            $aviso['mensagem'] = 'A sua solicitação de carteira estudantil foi enviada com sucesso! Aguarde pela aprovação de sua foto.';
            $aviso['usuario'] = $this->Usuario_Model->select($this->session->userdata('cod_usuario'));

            redirect('home/acompanhar');
            exit;
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
        $user['curso'] = 'Engenharia da computação';
        $user['tbl_modelos_cod_modelo'] = 1;
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
        header('Content-Type: application/json');
        $matricula = $this->session->userdata('matricula');

        $dir = 'static/imagens/' . $matricula . '/';
        if (!is_dir($dir)) mkdir($dir, 0777);
        $filename = 'temp.png';
        $fullurl = $dir . $filename;

        $imgstr = base64_decode($this->input->post('file'));
        list($width, $height) = getimagesizefromstring($imgstr);

        $dest = imagecreatetruecolor(161, 215);
        $im = imagecreatefromstring($imgstr);

        $nw = (215 * $width) / $height;

        imagecopyresampled($dest, $im, 0, 0, 138, 0, 161, 215, $width - $nw, $height);

        imagepng($dest, $fullurl);
        echo json_encode(true);
    }

    public function upload_facebook_photo()
    {

        $this->load->library('JsonResponse');

        $ds = DIRECTORY_SEPARATOR;
        $matricula = $this->session->userdata('matricula');
        $dir = "static{$ds}imagens{$ds}{$matricula}{$ds}";
        $filename = 'temp.png';
        $fullpath = $dir .  $filename;

        $idfacebook = $this->input->post('idfacebook');
        $fbImage = 'https://graph.facebook.com/'.$idfacebook.'/picture?type=large';

        is_dir($dir) ?: mkdir($dir);

        file_put_contents($fullpath, file_get_contents($fbImage));

        exit(
            new JsonResponse(
                compact('fullpath', 'idfacebook')
            )
        );
    }

    public function cropimage()
    {
        header('Content-Type: application/json');

        $imgstr = base64_decode($this->input->post('img'));

        $ds = DIRECTORY_SEPARATOR;
        $matricula = $this->session->userdata('matricula');
        $dir = "static{$ds}imagens{$ds}{$matricula}{$ds}";
        $filename = 'temp.png';
        $fullpath = $dir .  $filename;

        if (!is_dir($dir)) mkdir($dir);

        list($width, $height) = getimagesizefromstring($imgstr);

        $dest = imagecreatetruecolor(161, 215);
        $im = imagecreatefromstring($imgstr);

        $x = $this->input->get('x');
        $y = $this->input->get('y');
        $w = $this->input->get('w');
        $h = $this->input->get('h');

        $nh = 215;
        $nw = ($nh * $width) / $height;

        imagecopyresampled($dest, $im, 0, 0, $x, $y, 161, 215, $w+12, $h);

        imagepng($dest, $fullpath);

        echo json_encode(['url' => base_url($fullpath)]);
    }

    public function js_info()
    {
        $this->load->library('JsonResponse');
        $this->load->model('Solicitacao_Model');

        $cod_usuario = $this->session->userdata('cod_usuario');
        $numero_solicitacoes = $this->Solicitacao_Model->select($cod_usuario, true);

        exit(
            sprintf(
                'var %s = %s',
                $this->input->get('varname') ?: '_GLOBAL_',
                new JsonResponse(get_defined_vars())
            )
        );
    }

}