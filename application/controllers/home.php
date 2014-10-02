<?php

class Home extends WG_Controller {

    public $viewVars = array();
    public $allowedActions = ['login', 'sair', 'cadastrar'];

    public function __construct()
    {
        parent::__construct();
        if (isset($this->viewVars['user']->tbl_modelos_cod_modelo)) {
            $qr = 'SELECT * FROM tbl_modelos WHERE cod_modelo = ?';
            $bind = array($this->viewVars['user']->tbl_modelos_cod_modelo);
            $this->viewVars['user']->modelo = $this->db->query($qr, $bind)->row()->titulo;
        }
    }

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
        $viewData['solicitacoes'] = $this   ->Solicitacao_Model->select($cod_usuario);

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
        if($this->input->post('sended')) {

            $ds = DIRECTORY_SEPARATOR;
            $tempFile = FCPATH . "{$ds}static{$ds}imagens{$ds}" . $viewData['user']->matricula . "{$ds}temp.png";
            $nameFile = md5(microtime()) . '.png';
            $newName = FCPATH . "{$ds}static{$ds}imagens{$ds}" . $viewData['user']->matricula . "{$ds}" . $nameFile;
            rename($tempFile, $newName);

            $solicitacao = array(
                'foto' => $viewData['user']->matricula . '/' . $nameFile,
                'email' => $this->input->post('email'),
                'tbl_modelos_cod_modelo' => $viewData['user']->tbl_modelos_cod_modelo,
                'data' => date('Y-m-d H:i:s')
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
        $user1['cpf'] = '22222222222';
        $user1['matricula'] = '222222';
        $user1['nome'] = 'Gustavo Carmo';
        $user1['nivel'] = 2;
        $this->Usuario_Model->save($user1);

        $user2 = [
            'cpf' => '33333333333',
            'matricula' => '333333',
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

        $newW = 358;
        $newH = 478;

        $dest = imagecreatetruecolor($newW, $newH);
        $im = imagecreatefromstring($imgstr);
        $nw = ($newH * $width) / $height;

        if ($this->input->post('flash')) {
            imagecopyresampled($dest, $im, 0, 0, 70, 0, $nw, $newH, $nw, $newH);
        } else {
            imagecopyresampled($dest, $im, 0, 0, 138, 0, $nw, $newH, $width, $height);
        }

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

        exit(
            new JsonResponse(array('url' => $fbImage, 'base64' => base64_encode(file_get_contents($fbImage))))
        );
    }

    public function cropimage()
    {
        header('Content-Type: application/json');

        $imgstr = base64_decode($this->input->post('img'));
        $ext = $this->input->post('ext');

        $ds = DIRECTORY_SEPARATOR;
        $matricula = $this->session->userdata('matricula');
        $dir = "static{$ds}imagens{$ds}{$matricula}{$ds}";
        $filename = 'temp.png';
        $fullpath = $dir .  $filename;

        if (!is_dir($dir)) mkdir($dir);

        list($width, $height) = getimagesizefromstring($imgstr);

        $widthVar = 358;
        $heightVar = 478;
        $dest = imagecreatetruecolor($widthVar, $heightVar);

        $im = null;
        $tempbmppngfile = md5(uniqid() . time()) . '.bmp';
        if (!is_dir(FCPATH . '/static/imagens/tempbmp/')) mkdir(FCPATH . '/static/imagens/tempbmp/');
        if ($ext == 'bmp') {
            file_put_contents(FCPATH . '/static/imagens/tempbmp/' . $tempbmppngfile, $imgstr);
            $im = $this->imagecreatefrombmp(FCPATH . '/static/imagens/tempbmp/' . $tempbmppngfile);
            @unlink(FCPATH . '/static/imagens/tempbmp/' . $tempbmppngfile);
        } else {
            $im = imagecreatefromstring($imgstr);
        }

        $x = $this->input->get('x');
        $y = $this->input->get('y');
        $w = $this->input->get('w');
        $h = $this->input->get('h');

        $nh = 215;
        $nw = ($nh * $width) / $height;

        imagecopyresampled($dest, $im, 0, 0, $x, $y, $widthVar, $heightVar, $w, $h);

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

    private function imagecreatefrombmp($filename)
    {
    //Ouverture du fichier en mode binaire
       if (! $f1 = fopen($filename,"rb")) return FALSE;

    //1 : Chargement des ent�tes FICHIER
       $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
       if ($FILE['file_type'] != 19778) return FALSE;

    //2 : Chargement des ent�tes BMP
       $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
                     '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
                     '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
       $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
       if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
       $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
       $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
       $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
       $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
       $BMP['decal'] = 4-(4*$BMP['decal']);
       if ($BMP['decal'] == 4) $BMP['decal'] = 0;

    //3 : Chargement des couleurs de la palette
       $PALETTE = array();
       if ($BMP['colors'] < 16777216)
       {
        $PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
       }

    //4 : Cr�ation de l'image
       $IMG = fread($f1,$BMP['size_bitmap']);
       $VIDE = chr(0);

       $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
       $P = 0;
       $Y = $BMP['height']-1;
       while ($Y >= 0)
       {
        $X=0;
        while ($X < $BMP['width'])
        {
         if ($BMP['bits_per_pixel'] == 24)
            $COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
         elseif ($BMP['bits_per_pixel'] == 16)
         {
            $COLOR = unpack("n",substr($IMG,$P,2));
            $COLOR[1] = $PALETTE[$COLOR[1]+1];
         }
         elseif ($BMP['bits_per_pixel'] == 8)
         {
            $COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
            $COLOR[1] = $PALETTE[$COLOR[1]+1];
         }
         elseif ($BMP['bits_per_pixel'] == 4)
         {
            $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
            if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
            $COLOR[1] = $PALETTE[$COLOR[1]+1];
         }
         elseif ($BMP['bits_per_pixel'] == 1)
         {
            $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
            if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
            elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
            elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
            elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
            elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
            elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
            elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
            elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
            $COLOR[1] = $PALETTE[$COLOR[1]+1];
         }
         else
            return FALSE;
         imagesetpixel($res,$X,$Y,$COLOR[1]);
         $X++;
         $P += $BMP['bytes_per_pixel'];
        }
        $Y--;
        $P+=$BMP['decal'];
       }

    //Fermeture du fichier
       fclose($f1);

    return $res;
    }

    public function atualizarCaptcha()
    {
        header('Content-Type: application/json');

        $response = false;

        if (isset($_SESSION['random_number'], $_POST['capcha_text'])) {
           $response = $_SESSION['random_number'] == $_POST['capcha_text'];
        }

        echo json_encode($response);
    }

    public function getCaptcha()
    {
        $word_1 = '';
        $word_2 = '';
            
        for ($i = 0; $i < 4; $i++) {
            $word_1 .= chr(rand(97, 122));
        }

        for ($i = 0; $i < 4; $i++) {
            $word_2 .= chr(rand(97, 122));
        }
        
        $this->session->set_userdata(array(
            'random_number' => $word_1.' '.$word_2
        ));

        $dir = FCPATH.'/static/recaptcha/fonts/';
        $image = imagecreatetruecolor(172, 50);

        $font = "recaptchaFont.ttf";
        $color = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, 709, 99, $white);
        imagettftext($image, 25, 0, 5, 35, $color, $dir.$font, $this->session->userdata('random_number'));
            
        header("Content-type: image/png");
        imagepng($image);
    }

    public function verifyCaptcha()
    {
        header('Content-type: application/json');
        $captcha = $this->session->userdata('random_number');
        $text = $this->input->post('text');

        echo json_encode(array(
            'status' => ($captcha == $text),
            'session' => $captcha,
            'user' => $text
        ));
    }

}