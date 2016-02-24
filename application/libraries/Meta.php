<?php

class Meta {

    public static $meta, $settings, $uri = array();

    public function __Construct(){
		$result = array();
        $self = get_instance();
        $self->load->model(array('settings_model', 'meta_model'));
        self::$settings = array_merge($self->config->config, $self->settings_model->get_settings());

		//Стандартные теги
		self::$meta = array(
			'title' => self::$settings['site_meta_title'],
			'keywords' => self::$settings['site_meta_keywords'],
			'description' => self::$settings['site_meta_description'],
		);

		//Пробуем получить правило для страницы
		$self->load->helper('basic_helper');
		self::$uri = get_value($self->uri, 'segments');
		count(self::$uri) AND $url = implode('/', self::$uri);
		isset($url) AND $result = $self->meta_model->get_record($url, 'path');
		if(count($result)){
			self::$meta = array(
				'title' => get_value($result, 'seo_title'),
				'keywords' => get_value($result, 'seo_keywords'),
				'description' => get_value($result, 'seo_description'),
			);
		}
    }

    public static function get($type){
		$result = '';
		isset(self::$meta[$type]) AND $result = self::$meta[$type];
		return $result;
    }

    public static function set($meta){
        is_array($meta) AND self::$meta = $meta;
    }

}