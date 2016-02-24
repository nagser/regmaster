<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		Scripts::set(Settings::get('admin_scripts'));
	}


	public function index()
	{
		$this->load->view('admin/index');
	}

	/*
	 * Страница входа
	 * */
	public function login($form_success = FALSE){
		is_admin() AND redirect(base_url().'admin');
		$this->load->helper(array('form', 'url'));
		$this->load->view('admin/login/index', array(
			'form_success' => $form_success,
		));
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->login_model->validate();
			//Валидация данных
			if ($this->form_validation->run() == FALSE) {
				redirect(base_url().'admin/login/failed');
			} else {
				if($this->login_model->login_as_admin()) {
					$this->session->set_userdata('admin', TRUE);
					redirect(base_url().'admin');
				} else {
					redirect(base_url().'admin/login/failed');
				}
			}
		}
	}

	/*
	 * Выход из админки
	 * */
	public function logout(){
		$this->session->unset_userdata('admin');
		redirect(base_url());
	}

	/*===============================================Settings===================================================================*/
	/*
	 * Главная страница
	 * Выводим список всех параметров
	 * */
	public function settings($form_success = FALSE){
		$list = $this->settings_model->get_list();
		$this->load->view('admin/settings/index', array(
			'form_success' => $form_success,
			'list' => $list,
		));
	}

	/*
	 * Редактирование настройки
	 * Форма редактирования настройки с вводом названия и выбором типа
	 * */
	public function setting_edit($id = FALSE)
	{
		Scripts::set(Settings::get('editor_scripts'));
		$this->load->helper(array('form', 'url'));
		//Если форма отправлена
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->settings_model->validate();
			//Валидация данных
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/settings/edit');
			} else {
				//Обновить или добавить данные?
				if ($this->input->post('id')) {
					$this->settings_model->update($this->input->post('id'));
					redirect(base_url().'admin/settings/edited');
				} else {
					$this->settings_model->add_record();
					redirect(base_url().'admin/settings/added');
				}
			}
		} //Если параметр редактируется, а не создаётся
		elseif ($id) {
			$row = $this->settings_model->get_record((int)$id);
			if (count($row)) {
				foreach ($row as $key => $value) {
					$_POST[$key] = $value;
				}
				$this->load->view('admin/settings/edit', array('edit' => TRUE));
			} else {
				redirect(base_url().'admin/settings/failed');
			}
		} //Форма добавления параметра
		else {
			$this->load->view('admin/settings/edit');
		}
	}

	/*
	 * Удаление выбранного параметра
	 * */
	public function setting_delete($id, $ajax = FALSE) {
		if((int)$id){
			$this->settings_model->delete($id);
			if(!$ajax){
				redirect(base_url().'admin/settings/success');
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('id' => $id)));
			}
		} else {
			redirect(base_url().'admin/settings/failed');
		}
	}

	/*===============================================Categories===================================================================*/
	/*
	* Cписок категорий сайта
	* */
	public function categs($form_success = FALSE){
		$list = $this->categs_model->get_list();
		$this->load->view('admin/categs/index', array(
			'form_success' => $form_success,
			'list' => $list,
		));
	}

	/*
	 * Редактирование категории
	 * Форма редактирования категории статей
	 * */
	public function categ_edit($id = FALSE)
	{
		Scripts::set(Settings::get('editor_scripts'));
		Scripts::set(Settings::get('friendly_url_scripts'));
		$this->load->helper(array('form', 'url'));
		//Если форма отправлена
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->categs_model->validate();
			//Валидация данных
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/categs/edit');
			} else {
				//Обновить или добавить данные?
				if ($this->input->post('id')) {
					$this->categs_model->update($this->input->post('id'));
					redirect(base_url().'admin/categs/edited');
				} else {
					$this->categs_model->add_record();
					redirect(base_url().'admin/categs/added');
				}
			}
		} //Если категория редактируется, а не создаётся
		elseif ($id) {
			$row = $this->categs_model->get_record((int)$id);
			if (count($row)) {
				foreach ($row as $key => $value) {
					$_POST[$key] = $value;
				}
				$this->load->view('admin/categs/edit', array('edit' => TRUE));
			} else {
				redirect(base_url().'admin/categs/failed');
			}
		} //Форма добавления категории
		else {
			$this->load->view('admin/categs/edit');
		}
	}

	/*
	 * Удаление выбранного параметра
	 * */
	public function categ_delete($id, $ajax = FALSE) {
		if((int)$id){
			$this->categs_model->delete($id);
			if(!$ajax){
				redirect(base_url().'admin/categs/success');
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('id' => $id)));
			}
		} else {
			redirect(base_url().'admin/categs/failed');
		}
	}

	/*===============================================Articles===================================================================*/
	/*
	* Cписок статей сайта
	* */
	public function articles($form_success = FALSE){
		$list = $this->articles_model->get_list();
		$this->load->view('admin/articles/index', array(
			'form_success' => $form_success,
			'list' => $list,
		));
	}

	/*
	 * Редактирование статьи
	 * Форма редактирования категории статей
	 * */
	public function article_edit($id = FALSE)
	{
		Scripts::set(Settings::get('editor_scripts'));
		Scripts::set(Settings::get('friendly_url_scripts'));
		$this->load->helper(array('form', 'url'));
		//Если форма отправлена
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->articles_model->validate();
			//Валидация данных
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/articles/edit');
			} else {
				//Обновить или добавить данные?
				if ($this->input->post('id')) {
					$this->articles_model->update($this->input->post('id'));
					redirect('/admin/articles/edited');
				} else {
					$this->articles_model->add_record();
					redirect('/admin/articles/added');
				}
			}
		} //Если категория редактируется, а не создаётся
		elseif ($id) {
			$row = $this->articles_model->get_record((int)$id);
			if (count($row)) {
				foreach ($row as $key => $value) {
					$_POST[$key] = $value;
				}
				$this->load->view('admin/articles/edit', array('edit' => TRUE));
			} else {
				redirect(base_url().'admin/articles/failed');
			}
		} //Форма добавления категории
		else {
			$this->load->view('admin/articles/edit');
		}
	}

	/*
	 * Удаление выбранной категории
	 * */
	public function article_delete($id, $ajax = FALSE) {
		if((int)$id){
			$this->articles_model->delete($id);
			if(!$ajax){
				redirect('/admin/articles/success');
			} else {
				$this->output
				->set_content_type('application/json')
					->set_output(json_encode(array('id' => $id)));
			}
		} else {
			redirect(base_url().'admin/articles/failed');
		}
	}


	/*===============================================Gallery===================================================================*/
	/*
	* Cписок альбомов сайта
	* */
	public function gallery($form_success = FALSE){
		$list = $this->gallery_model->get_list();
		$this->load->view('admin/gallery/index', array(
			'form_success' => $form_success,
			'list' => $list,
		));
	}

	/*
	 * Редактирование статьи
	 * Форма редактирования категории статей
	 * */
	public function album_edit($id = FALSE)
	{
//		$this->output->enable_profiler(TRUE);
		Scripts::set(Settings::get('editor_scripts'));
		Scripts::set(Settings::get('friendly_url_scripts'));
		$this->load->helper(array('form', 'url'));
		//Если форма отправлена
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->gallery_model->validate();
			//Валидация данных
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/gallery/edit');
			} else {
				//Обновить или добавить данные?
				if ($this->input->post('id')) {
					$this->gallery_model->update($this->input->post('id'));
					redirect('/admin/gallery/edited');
				} else {
					$this->gallery_model->add_record();
					redirect('/admin/gallery/added');
				}
			}
		} //Если альбом редактируется, а не создаётся
		elseif ($id) {
			$row = $this->gallery_model->get_record((int)$id);
			if (count($row)) {
				foreach ($row as $key => $value) {
					$_POST[$key] = $value;
				}
				$this->load->view('admin/gallery/edit', array(
					'edit' => TRUE
				));
			} else {
				redirect(base_url().'admin/gallery/failed');
			}
		} //Форма добавления альбома
		else {
			$this->load->view('admin/gallery/edit');
		}
	}

	/*
	 * Загрузка и редактирование изображений альбома
	 * */
	public function album_images($album_id = FALSE, $component = FALSE){
		if($component){
			$data = array(
				'id' => $album_id,
				'component' => $component
			);
			$this->load->helper(array('form', 'url'));
			Scripts::set(Settings::get('gallery_scripts'));
			Scripts::set(Settings::get('cropper_scripts'));
			Scripts::set(Settings::get('sortable_scripts'));
			if ($album_id) {
				$images = $this->gallery_model->get_component_images($album_id, $component);
				$data['images'] = $images;
			}
			$this->load->view('admin/gallery/images', $data);
		}
	}

	/*
	 * Удаление выбранного альбома
	 * */
	public function album_delete($id, $component, $ajax = FALSE) {
		if((int)$id){
			$this->gallery_model->delete($id, $component);
			if(!$ajax){
				redirect('/admin/articles/success');
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('id' => $id)));
			}
		} else {
			redirect('/admin/articles/failed');
		}
	}

	/*
	 * Загрузка изображений средствами js
	 * */
	public function album_upload($id = FALSE, $component = FALSE){
		if($id AND $component){
			$result = array();
			$config = array(
				'upload_path' => $this->gallery_model->originals_path,
				'allowed_types' => 'jpg|jpeg|png|gif',
			);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('file')){
				$result = $this->gallery_model->upload_images($this->upload->data());
			} else {
				$result['error'] = $this->upload->display_errors();
			}
			//Добавляем изображение в БД
			if(!is_array($result)) {
				$id = $this->gallery_model->add_image((int)$id, $component, $result);
				$data = array(
					'result' => 'ok',
					'id' => $id,
					'thumb' => $this->gallery_model->thumbs_url.$result,
					'resized' => $this->gallery_model->resizes_url.$result,
					'delete_link' => base_url().'admin/delete_image/',
					'edit_link' => base_url().'admin/cropp_image/'
				);
			} else {
				$data = array(
					'error' => $result['error']
				);
			}
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($data));
		}
	}

	/*
	 * AJAX удаление изображений
	 * */
	public function delete_image($id, $ajax = FALSE){
		if((int)$id){
			$this->gallery_model->delete_image((int)$id);
			if(!$ajax){
				redirect('/admin/gallery/success');
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('id' => $id)));
			}
		} else {
			redirect('/admin/gallery/failed');
		}
	}

	/*
	 * Обрезка изображения
	 * */
	public function cropp_image(){
		$id = $this->input->post('id');
		$result = $this->gallery_model->get_image($id);
		$image = get_value($result, 'image');
		$c_image = $this->gallery_model->cropp_image($image, $this->input->post());
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array(
				'id' => $id,
				'image' => $this->gallery_model->thumbs_url.$image
			)));
	}

    /*
     * Сортировка изображений
     * */
    public function sort_images($id, $component){
        $result = $this->gallery_model->sort_images($this->input->get(), $id, $component);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('result' => $result)));
    }


	/*===============================================Meta Rules===================================================================*/
	/*
	 * Meta
	 * Выводим список всех правил
	 * */
	public function meta($form_success = FALSE){
		$list = $this->meta_model->get_list();
		$this->load->view('admin/meta/index', array(
			'form_success' => $form_success,
			'list' => $list,
		));
	}

	/*
	 * Редактирование мета
	 * Форма редактирования правила
	 * */
	public function meta_edit($id = FALSE)
	{
//		Scripts::set(Settings::get('editor_scripts'));
		$this->load->helper(array('form', 'url'));
		//Если форма отправлена
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->meta_model->validate();
			//Валидация данных
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/meta/edit');
			} else {
				//Обновить или добавить данные?
				if ($this->input->post('id')) {
					$this->meta_model->update($this->input->post('id'));
					redirect('/admin/meta/edited');
				} else {
					$this->meta_model->add_record();
					redirect('/admin/meta/added');
				}
			}
		} //Если параметр редактируется, а не создаётся
		elseif ($id) {
			$row = $this->meta_model->get_record((int)$id);
			if (count($row)) {
				foreach ($row as $key => $value) {
					$_POST[$key] = $value;
				}
				$this->load->view('admin/meta/edit', array('edit' => TRUE));
			} else {
				redirect('/admin/meta/failed');
			}
		} //Форма добавления параметра
		else {
			$this->load->view('admin/meta/edit');
		}
	}

	/*
	 * Удаление выбранного параметра
	 * */
	public function meta_delete($id, $ajax = FALSE) {
		if((int)$id){
			$this->meta_model->delete($id);
			if(!$ajax){
				redirect('/admin/meta/success');
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('id' => $id)));
			}
		} else {
			redirect('/admin/meta/failed');
		}
	}

	/*===============================================Pages===================================================================*/
	/*
	 * Страницы
	 * Список всех страниц
	 * */
	public function pages($form_success = FALSE){
		$list = $this->pages_model->get_list();
		$this->load->view('admin/pages/index', array(
			'form_success' => $form_success,
			'list' => $list,
		));
	}

	/*
	 * Редактирование страницы
	 * Форма редактирования
	 * */
	public function page_edit($id = FALSE)
	{
		Scripts::set(Settings::get('editor_scripts'));
		Scripts::set(Settings::get('friendly_url_scripts'));
		$this->load->helper(array('form', 'url'));
		//Если форма отправлена
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->pages_model->validate();
			//Валидация данных
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/pages/edit');
			} else {
				//Обновить или добавить данные?
				if ($this->input->post('id')) {
					$this->pages_model->update($this->input->post('id'));
					redirect('/admin/pages/edited');
				} else {
					$this->pages_model->add_record();
					redirect('/admin/pages/added');
				}
			}
		} //Если редактируется, а не создаётся
		elseif ($id) {
			$row = $this->pages_model->get_record((int)$id);
			if (count($row)) {
				foreach ($row as $key => $value) {
					$_POST[$key] = $value;
				}
				$this->load->view('admin/pages/edit', array('edit' => TRUE));
			} else {
				redirect('/admin/pages/failed');
			}
		} //Форма добавления параметра
		else {
			$this->load->view('admin/pages/edit');
		}
	}

	/*
	 * Удаление
	 * */
	public function page_delete($id, $ajax = FALSE) {
		if((int)$id){
			$this->pages_model->delete($id);
			if(!$ajax){
				redirect(base_url().'admin/pages/success');
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('id' => $id)));
			}
		} else {
			redirect(base_url().'admin/pages/failed');
		}
	}

    /*
     * Формы регистрации
     * */
    public function forms($form_success = FALSE){
        $list = $this->forms_model->get_list();
        $this->load->view('admin/forms/index', array(
            'form_success' => $form_success,
            'list' => $list,
        ));
    }

    public function forms_edit($id = FALSE)
    {
//		Scripts::set(Settings::get('editor_scripts'));
        $this->load->helper(array('form', 'url'));
        //Если форма отправлена
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->forms_model->validate();
            //Валидация данных
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/forms/edit');
            } else {
                //Обновить или добавить данные?
                if ($this->input->post('id')) {
                    $this->forms_model->update_record_form($this->input->post('id'));
                    redirect(base_url().'admin/forms/edited');
                } else {
                    $this->forms_model->add_record_form();
                    redirect(base_url().'admin/forms/added');
                }
            }
        } //Если параметр редактируется, а не создаётся
        elseif ($id) {
            $row = $this->forms_model->get_record((int)$id);
            if (count($row)) {
                foreach ($row as $key => $value) {
                    $_POST[$key] = $value;
                }
                $this->load->view('admin/forms/edit', array('edit' => TRUE, 'item' => $row));
            } else {
                redirect(base_url().'admin/forms/failed');
            }
        } //Форма добавления параметра
        else {
            $this->load->view('admin/forms/edit');
        }
    }

    public function form_delete($id, $ajax = FALSE) {
        if((int)$id){
            $this->forms_model->delete($id);
            if(!$ajax){
                redirect(base_url().'admin/forms/success');
            } else {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('id' => $id)));
            }
        } else {
            redirect(base_url().'admin/forms/failed');
        }
    }

    public function users(){
        $this->load->view('admin/users/index');
    }

    public function import(){
        $this->load->helper('form');
        if($_FILES AND $_FILES['file']){
            $this->users_model->import($_FILES['file']['tmp_name']);
        }
		$users_count =  $this->db->count_all($this->forms_model->table_submitted);
        $this->load->view('admin/users/import', array('count' => $users_count));
    }

	public function import_categs(){
		$this->load->helper('form');
		if($_FILES AND $_FILES['file']){
			$this->users_model->import_categs($_FILES['file']['tmp_name']);
		}
		$categs_count =  $this->db->count_all($this->users_model->table_categs);
		$this->load->view('admin/users/categs_import', array('count' => $categs_count));
	}






/*===============================================Printer Themes===================================================================*/
	/*
	* Cписок статей сайта
	* */
	public function themes($form_success = FALSE){
		$list = $this->printer_model->get_list();
		$this->load->view('admin/printer/index', array(
			'form_success' => $form_success,
			'list' => $list,
		));
	}

	/*
	 * Редактирование статьи
	 * Форма редактирования категории статей
	 * */
	public function themes_edit($id = FALSE)
	{
		Scripts::set(Settings::get('editor_scripts'));
		$this->load->helper(array('form', 'url'));
		//Если форма отправлена
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->printer_model->validate();
			//Валидация данных
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/printer/edit');
			} else {
				//Обновить или добавить данные?
				if ($this->input->post('id')) {
					$this->printer_model->update($this->input->post('id'));
					redirect(base_url().'admin/themes/edited');
				} else {
					$this->printer_model->add_record();
					redirect(base_url().'admin/themes/added');
				}
			}
		} //Если категория редактируется, а не создаётся
		elseif ($id) {
			$row = $this->printer_model->get_record((int)$id);
			if (count($row)) {
				foreach ($row as $key => $value) {
					$_POST[$key] = $value;
				}
				$this->load->view('admin/printer/edit', array('edit' => TRUE));
			} else {
				redirect(base_url().'admin/themes/failed');
			}
		} //Форма добавления категории
		else {
			$this->load->view('admin/printer/edit');
		}
	}

	/*
	 * Удаление выбранной категории
	 * */
	public function themes_delete($id, $ajax = FALSE) {
		if((int)$id){
			$this->printer_model->delete($id);
			if(!$ajax){
				redirect(base_url().'admin/themes/success');
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('id' => $id)));
			}
		} else {
			redirect(base_url().'themes/admin/themes/failed');
		}
	}

	/*
 	* Удаление всех пользователей
 	* */
	public function users_delete()
	{
		$this->db->truncate($this->forms_model->table_submitted);
		$this->db->truncate($this->forms_model->table_others);
		$this->db->truncate($this->printer_model->table_themes_printed);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('id' => TRUE)));

	}

	public function categs_delete()
	{
		$this->db->truncate($this->users_model->table_categs);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('id' => TRUE)));

	}

	public function users_import(){
		$visited_only = $this->input->get('visited_only');
		$route = $this->input->get('route');
		$this->$route($visited_only);
	}

	public function users_import_xml($visited = FALSE){
		$list = $this->users_model->get_users($visited);
		$this->users_model->generate_xml($list);
	}


	public function users_import_excel($visited = FALSE){
		$list = $this->users_model->get_users($visited);
		$this->users_model->generate_excel($list);
	}

}

