<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	/*===============================================Pages===================================================================*/

	/*
	 * Вывод одной страницы
	 * */
	public function view($alias) {
		if(!$page = $this->pages_model->get_record($alias, 'alias')){
			show_404();
		};
		//Хлебные крошки
		Breadcrumbs::set(get_value($page, 'alias'), get_value($page, 'name'), 'glyphicon glyphicon-arrow-right');
		Meta::set(array(
			'title' => get_value($page, 'seo_title'),
			'description' => get_value($page, 'seo_description'),
			'keywords' => get_value($page, 'seo_keywords')
		));
		//Шаблон
		$this->load->view('site/pages/item', $page);
	}
}