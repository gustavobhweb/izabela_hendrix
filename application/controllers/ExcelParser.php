<?php

include_once __DIR__ . '/../third_party/PHPExcel/PHPExcel.php';

class ExcelParser extends WG_Controller
{
    public $allowedActions = ['get_json', 'get_serial', 'listar'];

    private function _getUpload($name, $fields)
    {
        $filename =& $_FILES[$name]['name'];

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $validExtensions = in_array($extension, ['xlsx'], true);

        if (isset($_FILES[$name]) && $validExtensions) {

            $xlsFile = $_FILES[$name]['tmp_name'];

            $excel = new PHPExcel();

            $reader = new PHPExcel_Reader_Excel2007();
            $reader->setReadDataOnly(true);
            $phpexcel = $reader->load($xlsFile);
            $phpexcel->setActiveSheetIndex(0);

            $array = $phpexcel->getActiveSheet()->toArray(null,true,true,true);
            $phpexcel = null;

            /* 
                Remove elementos inválidos do array 
                Inválidos, por exemplo, seria um excel que o cliente enviou de 5 colunas,
                cujo uma linha possui 6 colunas //
                Essa linha seria removida ;)
            */

            $callbackFilter = function($array) use($fields) {
                return count($array) == count($fields);
            };

            $array = array_filter($array, $callbackFilter);     

            if (!empty($array)) {
                foreach($array as &$reference) {
                    $reference = array_combine($fields, $reference);
                }

                unset($reference);

                return $array;
            }
        }

        return array(); 
    }


    public function get_json()
    {
        $this->load->file(APPPATH . 'libraries/JsonSerialize.php');

        return (new JsonSerialize($this->_getUpload('xls')))->serialize();      
    }

    public function get_serial()
    {
        $this->load->file(APPPATH . 'libraries/PHPSerialize.php');

        return (new PHPSerialize($this->_getUpload('xls')))->serialize();           
    }


    public function carga_usuario()
    {
        $this->load->model('Usuario_Model');
        $this->load->model('Solicitacao_Model');

        $fields = ['nome', 'matricula', 'cpf', 'curso'];

        $upload_data = $this->_getUpload('xls', $fields);

        $dadosSegundaVia = [];

        foreach ($upload_data as $key => &$data) {
            // Verifica se existe no banco para fazer a inserção
            $existe_usuario = $this->db
                        ->where(['matricula' => $data['matricula']])
                        ->get($this->Usuario_Model->table)
                        ->row();


            if (!$existe_usuario && is_numeric($data['matricula']) ) {
                $data['tbl_niveis_cod_nivel'] = 1;
            } else {
                
                unset($upload_data[$key]);

                $existe_segunda_via = $this->db
                          ->where([
                                'tbl_usuarios_cod_usuario' => $existe_usuario->cod_usuario,
                                'via' => 2
                            ])
                          ->get($this->Solicitacao_Model->table)
                          ->num_rows;

                if ($existe_segunda_via) continue;

                $dadosSegundaVia[] = [
                    'tbl_status_cod_status' => 1,
                    'tbl_modelos_cod_modelo' => 1,
                    'tbl_usuarios_cod_usuario' => $existe_usuario->cod_usuario,
                    'via' => 2
                ];

            }
        }

        $this->viewData['upload_data'] =& $upload_data;
        $this->viewData['segunda_via'] =& $dadosSegundaVia;


        if(!empty($upload_data))
            $this->db->insert_batch($this->Usuario_Model->table, $upload_data);

        if(!empty($dadosSegundaVia)) 
            $this->db->insert_batch($this->Solicitacao_Model->table, $dadosSegundaVia);

        $this->load->view('excelparser/listar', $this->viewData);
    }


    public function carga_solicitacao()
    {
        // Qual é o sentido disso ?
    }

}