<?php
class settings_model extends CI_Model {

	public $table = 'settings';
	public $types =  array(
		'input' => 'Текстовое поле',
		'text' => 'Большое текстовое поле',
		'editor' => 'Визуальный редактор'
	);


	function __construct()
	{
		parent::__construct();
	}

	/*
	 * Список всех параметров
	 * */
	public function get_list(){
		return $this->db->get($this->table)
			->result_array();
	}

	/*
	 * Получиить запись по id
	 * */
	public function get_record($id) {
		return $this->db->get_where($this->table, array('id' => $id))
			->row();
	}

	/*
	 * Добавить запись в Mysql
	 * */
	public function add_record() {
		$data = array(
			'id' => NULL,
			'name' => $this->input->post('name'),
			'type' => $this->input->post('type'),
			'value' => $this->input->post('value'),
			'description' => $this->input->post('description')
		);
		 $this->db->insert($this->table, $data);
	}

	/*
	 * Обновить запись в Mysql
	 * */
	public function update($id){
		unset($_POST['id']);//удалим PRIMARY id
		return $this->db->update($this->table, $this->input->post(), array('id' => $id));
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
		$this->form_validation->set_rules('type', 'Тип', 'required');
		$this->form_validation->set_rules('value', 'Значение', 'required');
		$this->form_validation->set_rules('description', 'описание', 'not_required');
		$this->input->post('id') AND $this->form_validation->set_rules('id', 'id', 'not_required');
	}

	/*
	 * Настройки сайта в виде массива
	 * */
	public function get_settings(){
		$result = array();
		$list = $this->settings_model->get_list();
		foreach($list as $item) {
			$result[$item['name']] = $item['value'];
		}
		return $result;
	}

	/*
	 * Изменение поля для ввода значения в зависимости от типа
	 * */
	public function show_form_by_type($type, $list) {
		switch ($type) {
			case 'input'  : return form_input(array_merge($list, array('class' => 'form-control'))); break;
			case 'text'   : return form_textarea(array_merge($list, array('class' => 'form-control', 'rows' => '5'))); break;
			case 'editor' : return form_textarea(array_merge($list, array('class' => 'form-control editor', 'rows' => '10'))); break;
			default : return form_input(array_merge($list, array('class' => 'form-control'))); break;
		}
	}


}