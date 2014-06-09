<?php

include_once __DIR__ . '/../third_party/PHPExcel/PHPExcel.php';

class ExcelParser extends WG_Controller
{
	public function get_upload()
	{

		if (isset($_FILES['xls'])) {

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

				print_r($array);

			}


		}
	}
}