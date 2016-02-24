<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/*
	 * Главная странциа
	 * */
	public function index()
	{
		$this->load->view('site/index');
	}

}
