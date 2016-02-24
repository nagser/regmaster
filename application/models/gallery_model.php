<?php
class gallery_model extends CI_Model {

	public $table = 'gallery';
	public $table_images = 'gallery_images';


	function __construct()
	{
		parent::__construct();
		$this->originals_path = Settings::get('gallery_originals');
		$this->resizes_path = Settings::get('gallery_resizes');
		$this->thumbs_path = Settings::get('gallery_thumbs');
		$this->originals_url = base_url().'uploads/gallery/originals/';
		$this->resizes_url = base_url().'uploads/gallery/resizes/';
		$this->thumbs_url = base_url().'uploads/gallery/thumbs/';
	}

	/*
	 * Список всех альбомов
	 * */
	public function get_list(){
		return $this->db->get($this->table)
			->result();
	}

	/*
	 * Получить записи favorites
	 * */
	public function get_favorites($count = 20) {
		return $this->db->get_where($this->table, array('favorite' => 1), $count)
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
			'id' => NULL,
			'name' => $this->input->post('name'),
			'alias' => $this->input->post('alias'),
			'category_id' => $this->input->post('category_id'),
			'description' => $this->input->post('description'),
			'public' => $this->input->post('public'),
			'position' => $this->input->post('position'),
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
			'description' => $this->input->post('description'),
			'public' => $this->input->post('public') OR NULL,
			'position' => $this->input->post('position'),
		);
		return $this->db->update($this->table, $data, array('id' => $id));
	}

	/*
	 * Удалить альбом из Mysql
	 * */
	public function delete($id, $component){
		$images = $this->get_component_images($id, $component);
		foreach($images as $image) {
			unlink($this->originals_path.get_value($image, 'image'));
			unlink($this->resizes_path.get_value($image, 'image'));
			unlink($this->thumbs_path.get_value($image, 'image'));
		}
		$this->db->delete($this->table_images, array('album_id' => $id));
		return $this->db->delete($this->table, array('id' => (int)$id));
	}

	/*
	 * Валидация формы добавление альбома
	 * */
	public function validate() {
		$this->form_validation->set_rules('name', 'Название', 'trim|required');
		$this->form_validation->set_rules('alias', 'Псевдоним', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Категория', 'required');
		$this->form_validation->set_rules('description', 'Описание', 'trim');
		$this->form_validation->set_rules('position', 'Позиция', 'not_required');
		$this->form_validation->set_rules('public', 'Опубликовано', 'not_required');
		$this->input->post('id') AND $this->form_validation->set_rules('id', 'id', 'not_required');
	}

	/*
	 * Обработка изображений
	 * Resize & Drop & Move in Paths
	 * */
	public function upload_images($data){
		$this->load->library('image_lib');
		$r_image = $this->gallery_model->resize_image($data['file_name']);
		if(!is_array($r_image)){
			$t_image = $this->gallery_model->create_thumb($r_image, $this->originals_path);
			if(is_array($r_image)){
				return $t_image;
			}
		} else {
			return $r_image;
		}
		return $t_image;
	}

	/*
	 * Обрезка изображения
	 * */
	public function cropp_image($image, $params){
		$config = array(
			'source_image' => $this->resizes_path.$image,
			'x_axis' => $params['x'],
			'y_axis' => $params['y'],
			'width' => $params['width'],
			'height' => $params['height'],
			'new_image' => $this->thumbs_path.$image,
			'maintain_ratio' => FALSE,
		);
		$this->load->library('image_lib');
		$this->image_lib->initialize($config);
		if(!$this->image_lib->crop()){
			return array('error' => $this->image_lib->display_errors());
		} else {
			$image = $this->create_thumb($image, $this->thumbs_path);
			return $image;
		}
	}

	/*
	 * Создание превью картинки
	 * */
	public function create_thumb($image, $source){
		$config = array(
			'quality' => Settings::get('gallery_image_quality'),
			'source_image'	=> $source.$image,
			'width' => Settings::get('gallery_preview_width'),
			'height' => Settings::get('gallery_preview_height'),
			'new_image' => $this->thumbs_path.$image,
			'maintain_ratio' => FALSE,
		);
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize()){
			return array('error' => $this->image_lib->display_errors());
		} else {
			return $image;
		}
	}

	/*
	 * Создание среднего изображения
	 * */
	public function resize_image($image){
		$config = array(
			'quality' => Settings::get('gallery_image_quality'),
			'source_image'	=> $this->originals_path.$image,
			'width' => Settings::get('gallery_image_width'),
			'height' => Settings::get('gallery_image_height'),
			'new_image' => $this->resizes_path.$image,
		);
		$this->image_lib->initialize($config);
		if(!$this->image_lib->resize()){
			return array('error' => $this->image_lib->display_errors());
		} else {
			return $image;
		}
	}


	/*
	 * Добавление изображения в БД
	 * */
	public function add_image($album_id, $component, $image){
		$data = array(
			'album_id' => (int)$album_id,
			'component' => $component,
			'image' => $image,
		);
		$this->db->insert($this->table_images, $data);
		$id = $this->db->insert_id();
		return $id;
	}

	/*
	 * Вывод изображений альбома по его id и компоненту
	 * */
	public function get_component_images($id, $component){
		return $this->db
            ->order_by('position', 'asc')
            ->get_where($this->table_images, array('album_id' => $id, 'component' => $component))
			->result();
	}

	/*
	 * Вывод изображений для нескольких альбомов сразу(для разводящих компонента)
	 * */
	public function get_component_images_by_albums($idx, $component){
		return $idx ? $this->db
			->select('*')
			->from($this->table_images)
			->where('component', $component)
			->where_in('album_id', $idx)
			->order_by('position asc, id asc')
			->get()
			->result() : NULL;
	}

	/*
	 * Вывести изображение по признаку
	 * */
	public function get_image($value, $mode = 'id'){
		return $this->db->get_where($this->table_images, array($mode => $value))
			->row();
	}

	/*
	 * Удаление изображения и файлов
	 * */
	public function delete_image($id){
		$image = $this->get_image($id);
		unlink($this->originals_path.get_value($image, 'image'));
		unlink($this->resizes_path.get_value($image, 'image'));
		unlink($this->thumbs_path.get_value($image, 'image'));
		$this->db->delete($this->table_images, array('id' => (int)$id));
	}

    /*
     * Сортировка изображений
     * */
    public function sort_images($images, $album_id, $component){
        foreach($images['id'] as $position => $id){
            $data[] = array(
                'id' => $id,
                'album_id' => $album_id,
                'position' => $position,
                'component' => $component,
            );
        }
        $this->db->update_batch($this->table_images, $data, 'id');
        return TRUE;
    }
}