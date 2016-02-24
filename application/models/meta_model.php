<?php
class meta_model extends CI_Model {

	public $table = 'meta';


	function __construct()
	{
		parent::__construct();
	}

	/*
	 * Список всех статей
	 * */
	public function get_list(){
		return $this->db->get($this->table)
			->result();
	}

	/*
	 * Получиить запись по id
	 * */
	public function get_record($value, $mode = 'id') {
		return $this->db->get_where($this->table, array($mode => $value))
			->row();
	}


	/*
	 * Добавить запись в Mysql
	 * */
	public function add_record() {
		$data = array(
			'path' => trim($this->input->post('path'), '/'),
			'seo_title' => $this->input->post('seo_title'),
			'seo_description' => $this->input->post('seo_description'),
			'seo_keywords' => $this->input->post('seo_keywords'),
		);
		$this->db->insert($this->table, $data);
	}

	/*
	 * Обновить запись в Mysql
	 * */
	public function update($id){
		$data = array(
			'path' => trim($this->input->post('path'), '/'),
			'seo_title' => $this->input->post('seo_title'),
			'seo_description' => $this->input->post('seo_description'),
			'seo_keywords' => $this->input->post('seo_keywords'),
		);
		return $this->db->update($this->table, $data, array('id' => $id));
	}

	/*
	 * Удалить запись из Mysql
	 * */
	public function delete($id){
		return $this->db->delete($this->table, array('id' => (int)$id));
	}

	/*
	 * Валидация формы добавление мета
	 * */
	public function validate() {
		$this->form_validation->set_rules('path', 'Относительный путь', 'trim|required');
		$this->input->post('id') AND $this->form_validation->set_rules('id', 'id', 'not_required');
	}


}