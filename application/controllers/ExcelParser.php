<?php

include_once __DIR__ . '/../third_party/PHPExcel/PHPExcel.php';

class ExcelParser extends WG_Controller
{
	public $allowedActions = ['get_json', 'get_serial', 'listar'];

	private function _getUpload()
	{
		$filename =& $_FILES['xls']['name'];

		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

		$validExtensions = in_array($extension, ['xls', 'xlsx'], true);

		if (isset($_FILES['xls']) && $validExtensions) {

			$xlsFile = $_FILES['xls']['tmp_name'];

			$excel = new PHPExcel();

			$reader = new PHPExcel_Reader_Excel2007();
			$reader->setReadDataOnly(true);
			$phpexcel = $reader->load($xlsFile);
			$phpexcel->setActiveSheetIndex(0);

			$array = $phpexcel->getActiveSheet()->toArray(null,true,true,true);
			$phpexcel = null;


			if (is_array(current($array)) && count(current($array)) == 5) {
				$fields = ['nome', 'matricula', 'cpf', 'foto', 'email'];

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

		return (new JsonSerialize($this->_getUpload()))->serialize();		
	}

	public function get_serial()
	{
		$this->load->file(APPPATH . 'libraries/PHPSerialize.php');

		return (new PHPSerialize($this->_getUpload()))->serialize();			
	}


	public function listar()
	{
		$this->viewData['upload_data'] = $this->_getUpload();

		$this->load->view('excelparser/listar', $this->viewData);
	}

}