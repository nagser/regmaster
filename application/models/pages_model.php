<?php
class pages_model extends CI_Model {

	public $table = 'pages';


	function __construct()
	{
		parent::__construct();
	}

	/*
	 * Список всех параметров
	 * */
	public function get_list($cols = FALSE){
		$cols AND $this->db->select($cols);
		return $this->db->get($this->table)
			->result();
	}

	/*
	 * Получиить запись по id
	 * */
	public function get_record($value, $alias = 'id') {
		return $this->db->get_where($this->table, array($alias => $value))
			->row();
	}

	/*
	 * Добавить запись в Mysql
	 * */
	public function add_record() {
		$data = array(
			'id' => NULL,
			'name' => $this->input->post('name'),
			'alias' => $this->input->post('alias'),
			'text' => $this->input->post('text'),
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
			'name' => $this->input->post('name'),
			'alias' => $this->input->post('alias'),
			'text' => $this->input->post('text'),
			'seo_title' => $this->input->post('seo_title'),
			'seo_description' => $this->input->post('seo_description'),
			'seo_keywords' => $this->input->post('seo_keywords'),
		);
//		debug($data);
		return $this->db->update($this->table, $data, array('id' => $id));
	}

	/*
	 * Удалить запись из Mysql
	 * */
	public function delete($id){
		return $this->db->delete($this->table, array('id' => (int)$id));
	}

	/*
	 * Валидация формы добавление параметра
	 * */
	public function validate() {
		$this->form_validation->set_rules('name', 'Название', 'trim|required');
		$this->form_validation->set_rules('alias', 'Псевдоним', 'trim|required');
		$this->form_validation->set_rules('text', 'Содержимое', 'trim|required');
		$this->input->post('id') AND $this->form_validation->set_rules('id', 'id', 'not_required');
	}

	/*
	 * Получение списка категорий для построения дропдауна
	 * */
	public function as_list(){
		$result = array();
		$result = $this->categs_model->get_list('id, name');
		return delete_keys($result);
	}

}