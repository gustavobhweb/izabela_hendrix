<?php

class JsonResponse
{
	private $_data = null;

	public function __construct($data = null)
	{
		$this->_data = json_encode($data);
	}

	public function __toString()
	{
		header('Content-Type: Application/json');
		return $this->_data;
	}
}