<?php
class login_model extends CI_Model {


	function __construct()
	{
		parent::__construct();
		if(!substr_count($_SERVER['REQUEST_URI'], '/login') && substr_count($_SERVER['REQUEST_URI'], '/admin') && !$this->session->userdata('admin')) {
			redirect(base_url().'admin/login');
		}
	}

	/*
	 * Проверка на админа
	 * */
	public function is_admin(){
		return $this->session->userdata('admin') ? TRUE : FALSE;
	}

	/*
	 * Валидация формы логина
	* */
	public function validate() {
		$this->form_validation->set_rules('name', 'Имя', 'trim|required');
		$this->form_validation->set_rules('password', 'Пароль', 'trim|required');
	}

	/*
 	* Логин админа
 	* */
	public function login_as_admin(){
		return ($this->input->post('name') == $this->config->config['admin_username'] AND md5($this->input->post('password')) == $this->config->config['admin_password']) ? TRUE : FALSE;
	}



}