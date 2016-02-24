<?php

class Settings {

	public static $settings = array();

	public function __Construct(){
		$self = get_instance();
		$self->load->model('settings_model');
		self::$settings = array_merge($self->config->config, $self->settings_model->get_settings());
	}

	public static function get($param){
		return self::$settings[$param] ? self::$settings[$param] : FALSE;
	}

	public static function set($key, $value){
		self::$settings[$key] = $value;
	}

}