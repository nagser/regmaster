<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller {

	/*===============================================Articles===================================================================*/

	/*
	* Cписок статей сайта
	* */
	public function index($page = 1){
		Breadcrumbs::set(base_url().'articles/', 'Статьи', 'glyphicon glyphicon-file');
		$this->db->limit(Settings::get('articles_items_per_pages'), Settings::get('articles_items_per_pages')*($page-1));
		$list = $this->articles_model->get_list_width_images();
		get_value($list, 'articles') or  show_404();
		$this->pager_model->get_pager(array(
			'base_url' => base_url().'articles/',
			'total_rows' => $this->db->count_all($this->articles_model->table),
			'per_page' => Settings::get('articles_items_per_pages'),
		));
		$this->load->view('site/articles/index', array('list' => $list));
	}

	/*
	* Cписок статей сайта c категориями
	* */
	public function with_categs($category_alias, $page = 1){
		$category = $this->categs_model->get_record($category_alias, 'alias');
		Breadcrumbs::set(base_url().'articles/', 'Статьи', 'glyphicon glyphicon-file');
		Breadcrumbs::set(base_url().'articles/'.get_value($category, 'alias'), get_value($category, 'name'), 'glyphicon glyphicon-th');
		$count = $this->db
			->where('category_id', get_value($category, 'id'))
			->count_all_results($this->articles_model->table);
		$this->db->limit(Settings::get('articles_items_per_pages'), Settings::get('articles_items_per_pages')*($page-1));
		$list = $this->articles_model->get_category_list(get_value($category, 'id')) OR show_404();
		$this->pager_model->get_pager(array(
			'base_url' => base_url().'articles/'.$category_alias.'/',
			'total_rows' => $count,
			'per_page' => Settings::get('articles_items_per_pages'),
			'uri_segment' => 3,
		));
		$this->load->view('site/articles/index', array('list' => $list));
	}

	/*
	 * Вывод одной статьи
	 * */
	public function view($alias = FALSE) {
		!$alias AND redirect(base_url().'articles/');
		$article = $this->articles_model->get_record($alias, 'alias');
		$images = $this->gallery_model->get_component_images(get_value($article, 'id'), 'articles');
		//Хлебные крошки
		Breadcrumbs::set(base_url().'articles/', 'Статьи', 'glyphicon glyphicon-file');
		Breadcrumbs::set(base_url().'articles/'.get_value($article, 'category_alias'), get_value($article, 'categ_name'), 'glyphicon glyphicon-th');
		Breadcrumbs::set(get_value($article, 'alias'), get_value($article, 'name'), 'glyphicon glyphicon-arrow-right');
		//Шаблон
		$this->load->view('site/articles/item', array(
			'article' => $article,
			'images' => $images,
		));
	}
}