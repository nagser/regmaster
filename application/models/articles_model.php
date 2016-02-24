<?php
class articles_model extends CI_Model {

	public $table = 'articles';


	function __construct()
	{
		parent::__construct();
	}

	/*
	 * Список всех статей
	 * Сразу получем с alias категории
	 * */
	public function get_list(){
		//Статьи
		return $this->db->select('a.*, b.alias AS categ_alias')
			->from($this->table.' a')
			->join($this->categs_model->table.' b', 'b.id = a.category_id')
			->get()
			->result();
	}

	public function get_list_width_images(){
		$articles = $this->get_list();
		$idx = array_from_key($articles);
		//Изображения для статей
		$images = key_from_value($this->gallery_model->get_component_images_by_albums($idx, 'articles'), 'album_id');
		return array(
			'images' => $images,
			'articles' => $articles,
		);
	}

	/*
	 * Получить записи текущей категории
	 * */
	public function get_category_list($id) {
		//Статьи
		$articles = $this->db->select('a.*, b.alias AS categ_alias')
			->from($this->table.' a')
			->join($this->categs_model->table.' b', 'b.id = a.category_id')
			->where('a.category_id', $id)
			->get()
			->result();
		$idx = array_from_key($articles);
		//Изображения для статей
		$images = key_from_value($this->gallery_model->get_component_images_by_albums($idx, 'articles'), 'album_id');
		return array(
			'images' => $images,
			'articles' => $articles,
		);
	}

	/*
	 * Получить записи favorites
	 * */
	public function get_favorites($count = 20) {
		//Статьи
		$articles = $this->db->select('a.*, b.alias AS categ_alias')
			->from($this->table.' a')
			->join($this->categs_model->table.' b', 'b.id = a.category_id')
			->where('a.favorite', 1)
			->where('a.publish', 1)
			->limit($count)
			->get()
			->result();
		$idx = array_from_key($articles);
		//Изображения для статей
		$images = key_from_value($this->gallery_model->get_component_images_by_albums($idx, 'articles'), 'album_id');
		return array(
			'images' => $images,
			'articles' => $articles,
		);
	}

	/*
	 * Получиить запись
	 * Сразу получем с alias категории
	 * */
	public function get_record($value, $mode = 'id') {
		return $this->db->select('a.*, b.alias AS categ_alias, b.name AS categ_name')
			->from($this->table.' a')
			->join($this->categs_model->table.' b', 'b.id = a.category_id')
			->where('a.'.$mode, $value)
			->get()
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
			'category_id' => $this->input->post('category_id'),
			'preview' => $this->input->post('preview'),
			'text' => $this->input->post('text'),
			'publish' => $this->input->post('publish'),
			'favorite' => $this->input->post('favorite'),
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
			'category_id' => $this->input->post('category_id'),
			'preview' => $this->input->post('preview'),
			'text' => $this->input->post('text'),
			'publish' => $this->input->post('publish') OR NULL,
			'favorite' => $this->input->post('favorite') OR NULL,
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
	 * Валидация формы добавление параметра
	 * */
	public function validate() {
		$this->form_validation->set_rules('name', 'Название', 'trim|required');
		$this->form_validation->set_rules('alias', 'Псевдоним', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Категория', 'required');
		$this->form_validation->set_rules('preview', 'Вступление', 'trim|required');
		$this->form_validation->set_rules('text', 'Подробный текст', 'trim|required');
		$this->form_validation->set_rules('publish', 'Опубликовано', 'not_required');
		$this->form_validation->set_rules('favorite', 'Избранное', 'not_required');
		$this->input->post('id') AND $this->form_validation->set_rules('id', 'id', 'not_required');
	}


}