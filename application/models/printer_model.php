<?php

class printer_model extends CI_Model
{

	public $table_themes = 'printer_themes';
	public $table_themes_printed = 'printer_themes_printed';


	function __construct()
	{
		parent::__construct();
	}

	public function get_list($params = array())
	{
		return $this->db->select('*')
			->from($this->table_themes)
			->where($params)
			->get()
			->result();
	}


	public function get_record($value, $mode = 'id')
	{
		return $this->db->get_where($this->table_themes, array($mode => $value))->row();
	}

	public function add_record()
	{
		$data = array(
			'id' => NULL,
			'name' => $this->input->post('name'),
			'text' => $this->input->post('text'),
			'active' => $this->input->post('active'),
		);
		$this->db->insert($this->table_themes, $data);
	}

	public function update($id)
	{
		$data = array(
			'name' => $this->input->post('name'),
			'text' => $this->input->post('text'),
			'active' => $this->input->post('active'),
		);
		return $this->db->update($this->table_themes, $data, array('id' => $id));
	}

	public function delete($id)
	{
		return $this->db->delete($this->table_themes, array('id' => (int)$id));
	}

	public function validate()
	{
		$this->form_validation->set_rules('name', 'Название', 'trim|required');
		$this->form_validation->set_rules('text', 'Макет', 'trim|required');
		$this->form_validation->set_rules('active', 'Активен', 'not_required');
		$this->input->post('id') AND $this->form_validation->set_rules('id', 'id', 'not_required');
	}

	public function themes_as_list()
	{
		$params = array('active' => 1);
		$result = $this->get_list($params);
		if ($result) {
			$result = array_to_list($result);
		} else {
			$result = array();
		}
		return $result;
	}

	public function proccess($theme_id, $user_id)
	{
		$printer_name = $this->get_printer();
//debug($printer_name);
		$user = $this->users_model->get_user($user_id);
		$file_path = FCPATH.APPPATH.'cache/'.$user->id.'.pdf';
		$url = base_url(). 'forms/print_page/' . $theme_id . '/' . $user->id;
		shell_exec('wkhtmltopdf ' . $url . ' ' . $file_path);
		shell_exec('lp -d ' . $printer_name . ' ' . $file_path);
	}

	public function get_printer()
	{
		$ip = $this->input->ip_address();
		$printers = Settings::get('printers');
		$printers = explode(PHP_EOL, $printers);
		foreach ($printers AS $printer) {
			$printer = explode('||', $printer);
			if (trim($printer[0]) == $ip) {
				return trim($printer[1]);
			} else {
				continue;
			}
		}
		show_error('Current IP not existed in printer list!');
		return FALSE;
	}

	public function parse_theme($id, $user_id)
	{
		$data = array();
		$user = $this->users_model->get_user($user_id);
		$theme = $this->get_record($id);
		$theme OR show_error('Invalid Theme');
		$theme = $theme->text;
		//Данные пользователя
		foreach ($user as $key => $row) {
			if ($key == 'hash') {
				$row = '<img width="140" height="40" src="data:image/png;base64,' . $this->hash_model->generate($row) . '">';
			} elseif($key == 'city'){
				$row = explode(';', $row);
				$row = trim($row[0]);
			}
			$theme = str_replace('[' . $key . ']', $row, $theme);
		}
		//Настройки проекта
		if(isset(Settings::$settings) AND is_array(Settings::$settings)){
			foreach (Settings::$settings as $key => $row) {
				if(!is_array($row) AND substr_count($key, 'event_')){
					$theme = str_replace('[' . $key . ']', $row, $theme);
				}
			}
		}
		return $theme;
	}

	public function replace_aliases($str, $user)
	{
		foreach ($user as $alias => $row) {
			$str = str_replace($alias, $row, $str);
		}
		return $str;
	}

	public function write_in_history($theme_id, $user_id){
		$this->db->insert($this->table_themes_printed, array(
            'theme_id' => $theme_id,
            'user_id' => $user_id
		));
	}

    public function get_print_history($user_id){
        $list = $this->db->get_where($this->table_themes_printed, array('user_id' => $user_id))->result();
        return $list ? array_to_list($list, 'theme_id', 'datetime') : array();
    }

}
