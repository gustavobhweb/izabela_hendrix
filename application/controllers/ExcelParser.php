<?php

include_once __DIR__ . '/../third_party/PHPExcel/PHPExcel.php';

class ExcelParser extends WG_Controller
{
	public $allowedActions = ['get_json', 'get_serial', 'listar'];

	private function _getUpload($name, $fields)
	{
		$filename =& $_FILES[$name]['name'];

		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

		$validExtensions = in_array($extension, ['xls', 'xlsx'], true);

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

		$this->viewData['upload_data'] =& $upload_data;

		foreach ($upload_data as $key => &$data) {
			// Verifica se existe no banco para fazer a inserção
			$count = $this->db
						->where(array('matricula' => $data['matricula']))
						->get($this->Usuario_Model->table)
						->num_rows;

			if (!$count) {
				$data['tbl_niveis_cod_nivel'] = 1;
			} else {
				unset($upload_data[$key]);
			}
		}


		if(!empty($upload_data))
			$this->db->insert_batch($this->Usuario_Model->table, $upload_data);

		$this->load->view('excelparser/listar', $this->viewData);
	}


	public function carga_solicitacao()
	{
		// Qual é o sentido disso ?
	}

}