<?php
class pager_model extends CI_Model {


	function __construct()
	{
		parent::__construct();
	}

	/*
	 * Стандартная паджинация Ci
	 * @param $params array()
	 * */
	public function get_pager($params = FALSE) {
		$default = array(
			'per_page' => 10,
			'uri_segment' => 2,
		);
		$config = array_merge($default, $params);
		$this->pagination->initialize($config);
	}

}