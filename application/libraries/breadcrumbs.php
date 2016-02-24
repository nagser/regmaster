<?php

class Breadcrumbs {

	public static $breadcrumbs = array();

	/*
	 * Формирование осуществляется вручную вызовом set в контроллере.
	 * */
	public function __Construct(){
		$self = get_instance();
		$self->load->library('Settings');
		//Добавляем главную в крошки
		self::$breadcrumbs[0] = array(
			'link' => base_url(),
			'name' => 'Главная',
            'icon' => 'glyphicon glyphicon-home',
		);

	}

	/*
	 * Добавление крошек
	 * */
	public static function set($link, $name, $icon = 'glyphicon glyphicon-arrow-right'){
		self::$breadcrumbs[] = array(
			'link' => $link,
			'name' => $name,
            'icon' => $icon,
		);
	}

	/*
	 * Выводим хлебные крошки
	 * */
	public function get(){
		//Определяем последний элемент с помошью счётчика
		$count = count(self::$breadcrumbs);
		$i = 1;
		$result[] = '<ol class="breadcrumb">';
		foreach(self::$breadcrumbs as $item){
            $item['icon'] != FALSE ? $icon = '<span class="'.$item['icon'].'"></span> ' : $icon = FALSE;
            if($i != $count) {
				$result[] = '<li style="color: #999;">'.$icon.'<a href="'.$item['link'].'">'.$item['name'].'</a></li>';
			} else {
				$result[] = '<li class="active">'.$icon.$item['name'].'</li>';
			}
			$i++;
		}
		$result[] = '</ol>';
		return implode('', $result);
	}

}