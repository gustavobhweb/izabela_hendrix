<?php

class PHPSerialize implements Serializable
{
	private $_data = [];

	public function __construct($data)
	{
		$this->_data = $data;
	}

	public function serialize()
	{
		return serialize($this->_data);
	}

	public function unserialize($serialize)
	{
		return unserialize($this->_data);
	}

}