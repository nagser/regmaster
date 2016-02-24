<?php

class Scripts {

	private static $scripts = array();

	public function __Construct(){
		$self = get_instance();
		$self->load->library('Settings');
		self::$scripts = Settings::get('core_scripts');
	}

	public static function get(){
		self::$scripts = array_merge(self::$scripts, Settings::get('system_scripts'));
		return "'".implode("', '", self::$scripts)."'";
	}

	public static function set($script){
		self::$scripts = array_merge(self::$scripts, $script);
	}

}