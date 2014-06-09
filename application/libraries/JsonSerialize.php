<?php

class JsonSerialize
{
	private $_data = [];

	public function __construct($data)
	{
		$this->_data = $data;
	}

	public function serialize($pretty = JSON_PRETTY_PRINT)
	{
		return json_encode($this->_data, $pretty);
	}

	public function unserialize($isArray = false)
	{
		return json_decode($this->_data, $isArray);
	}
}