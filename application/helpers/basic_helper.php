<?php

/*
 * Проверка на админа
 * Просто обёртка для метода
 * */
function is_admin()
{
	$self = get_instance();
	$self->load->model('login_model');
	return $self->login_model->is_admin();
}

/*
 * Дебагер переменной
 * */
function debug($arr, $return = FALSE)
{
	$dump = '';
	if (is_admin()) {
		$dump = '<pre>' . print_r($arr, TRUE) . '</pre>';
		if (!$return) {
			exit($dump);
		}
	}
	return $dump;
}

/*
 * Системные сообщения
 * */
function show_message($message)
{
	if ($message) {
		switch ($message) {
			case 'success':
				return '<div class="alert alert-success" role="alert">Успешно!</div>';
				break;
			case 'failed':
				return '<div class="alert alert-danger" role="alert">Ошибка!</div>';
				break;
			case 'added':
				return '<div class="alert alert-success" role="alert">Добавлено!</div>';
				break;
			case 'edited':
				return '<div class="alert alert-success" role="alert">Отредактировано!</div>';
				break;
			default:
				return '<div class="alert alert-danger" role="alert">' . $message . '</div>';
				break;
		}
	} else {
		return FALSE;
	}
}

/*
 * Функция выводит дропдаун со значением по умолчанию
 * */
function show_dropdown($name, $options, $selected = FALSE, $id = 'select')
{
	$result = '<select id="' . $id . '" name="' . $name . '" class="form-control">';
	$count = 0;
	foreach ($options as $key => $value) {
		($count == 0 AND !set_value($name)) ? $is_selected = TRUE : $is_selected = FALSE;
		$result .= '<option value="' . $key . '" ' . set_select($name, $key, $is_selected) . '>' . $value . '</option>';
		$count++;
	}
	$result .= '</select>';
	return $result;
}

/*
 * Обрезаем статью
 * */
function cute_text($string, $count)
{
	$length = strlen($string);
	if ($length > $count) {
		$length = 0;
		$result = '';
		$arr_string = explode(' ', $string);
		foreach ($arr_string as $word) {
			$length += strlen($word);
			if ($length < $count) {
				$result[] = $word;
			} else {
				break;
			}
		}
		return implode(' ', $result) . '...</p>';
	}
	return $string;
}

/*
 * Удаление одного уровня массива
 * */
function delete_keys($arr, $k = 'id', $v = 'name')
{
	$result = array();
	if (count($arr)) {
		foreach ($arr as $key => $value) {
			$result[$value->$k] = $value->$v;
		}
	}
	return $result;
}

/*
 * Вывести элемент меню
 * */
function show_link($link, $name, $admin = FALSE, $icon = FALSE)
{
	$active = '';
	$self = get_instance();
	$url = $admin ? (isset($self->uri->segments['2']) ? $self->uri->segments['2'] : TRUE) : (isset($self->uri->segments['1']) ? $self->uri->segments['1'] : TRUE);
	//(($url == 'FALSE' AND $link == base_url()) OR substr_count($link, $url)) AND $active = 'active';
    if($admin){
        $result = '
        <a href="'.$link.'" class="thumbnail color-blue text-center '.$active.'">
			<span style="font-size: 90px;" class="'.$icon.'"></span>
			<ul class="list-group no-margin no-padding">
				<li class="list-group-item">'.$name.'</li>
			</ul>
		</a>';
    } else {
        $result =  '<li class="' . $active . '"><a href="' . $link . '">' . $name . '</a></li>';
    }
    return $result;
}

/*
 * Получение свойств объекта или массива
 * */
function get_value($obj, $key) {
	$obj = (array)$obj;
	if(isset($obj[$key])) {
		return $obj[$key];
	} else {
		return FALSE;
	}
}

/*
* Одномерный массив по выбранному полю
* */
function array_from_key($array, $key = 'id'){
	foreach($array as $item){
		$result[] = get_value($item, $key);
	}
	return isset($result) ? $result : NULL;
}

/*
 * Меняем ключ массива
 * Если флаг $ignore_level = TRUE - для каждого ключа берётся только одно значение(первое по порядку), остальные игнорируются
 * */
function key_from_value($array, $key = 'id', $ignore_level = TRUE){
	if(is_array($array)){
		foreach($array as $item){
			if($ignore_level){
				if(!isset($result[get_value($item, $key)])){
					$result[get_value($item, $key)] = $item;
				}
			} else {
				$result[get_value($item, $key)][] = $item;
			}
		}
	}
	return isset($result) ? $result : NULL;
}

/*
 * Принимает бесчисленное кол-во параметров, возвращает первый =! FALSE OR NULL
 * */
function value() {
	$args = func_get_args();
	foreach ($args as $val) {
		if ($val) return $val;
		$result = $val;
	}
	return $result;
}

function set_params($defaults = NULL, $params = NULL, $as_array = FALSE) {
    $result = array_merge((array)$defaults, (array)$params);
    return $as_array ? $result : (object)$result;
}


function random_str($type = 'alnum', $length = 16) {
    switch($type)
    {
        case 'basic':
            return mt_rand();
            break;

        default:
        case 'alnum':
        case 'numeric':
        case 'nozero':
        case 'alpha':
        case 'distinct':
        case 'hexdec':
            switch ($type)
            {
                case 'alpha':
                    $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;

                default:
                case 'alnum':
                    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;

                case 'numeric':
                    $pool = '0123456789';
                    break;

                case 'nozero':
                    $pool = '123456789';
                    break;

                case 'distinct':
                    $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
                    break;

                case 'hexdec':
                    $pool = '0123456789abcdef';
                    break;
            }

            $str = '';
            for ($i=0; $i < $length; $i++)
            {
                $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
            }
            return $str;
            break;

        case 'unique':
            return md5(uniqid(mt_rand()));
            break;

        case 'sha1' :
            return sha1(uniqid(mt_rand(), true));
            break;
    }
}

function join_phrases() {
	$args = func_get_args();
	if (is_array($args[0])) {
		foreach ($args[0] as $item) {
			$item AND $res[] = $item;
		}
		return implode(isset($args[2]) ? $args[1] : ($args[1] ? $args[1] : " / "), $res);
	} else {
		return implode(" / ", $args);
	}
}

function array_to_list($arr, $field_key = 'id', $field_val = 'name', $string_keys = FALSE, $separator = ', ') {
	foreach ($arr as $item) {
		$item = (object)$item;
		$res = array();
		foreach ((array)$field_val as $fv) {
			$res[] = $item->$fv;
		}
		#$value = implode($separator, $res);
		$value = join_phrases($res, $separator);
		$field_key ? $result[$string_keys ? "'".$item->$field_key."'" : $item->$field_key] = $value : $result[] = $value;
	}
	return (array)$result;
}

