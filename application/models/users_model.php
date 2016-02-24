<?php

class users_model extends CI_Model
{

    public $map = array('id' => 'id', 'hash' => 'hash', 'surname' => 'surname', 'name' => 'name', 'patronymic' => 'patronymic', 'city' => 'city', 'email' => 'email');
	public $aliases_mape = array('workplace_1' => 'post', 'mobile_phone_1');
	public $categs = array('id', 'name');
	public $table_cities = 'geo_cities';
	public $table_regions = 'geo_regions';
	public $table_countries = 'geo_countries';
	public $table_categs = 'users_categs';

    public function import($file)
    {
		$buffer2 = array();
		$users = new SimpleXMLElement(file_get_contents($file));
		//$this->map = array_merge($this->map, array_to_list($this->forms_model->get_list(), 'alias', 'alias'));
        foreach ($users as $user) {
			$buffer1 = array();
            $user = (array)$user;
			$user = $user['@attributes'];
			unset($user['special']);
			foreach($user as $name => $value){
				if(get_value($this->map, $name)){
					if($name == 'city'){
						$buffer1[$name] = implode('; ', array(get_value($user, 'city'), get_value($user, 'region'), get_value($user, 'country')));
					} else {
						$buffer1[$name] = $value;
					}
				} elseif(get_value(array_to_list($this->forms_model->get_list(), 'alias', 'alias'), $name = str_replace('_1', '', $name))){
					$buffer2[] = array(
						'user_id' => get_value($user, 'id'),
						'name' => $name,
						'value' => $value,
					);
				}
			}
			if(get_value($user, 'mobile_phone_1')){
				$buffer2[] = array(
					'user_id' => get_value($user, 'id'),
					'name' => 'phone',
					'value' => $user['mobile_phone_1'],
				);
			}
            $data_1[] = $buffer1;
        }
        isset($data_1) AND $this->db->insert_batch($this->forms_model->table_submitted, $data_1);
        isset($buffer2) AND $this->db->insert_batch($this->forms_model->table_others, $buffer2);
    }

    public function find($surname)
    {
        return $this->db->select('*')
            ->from($this->forms_model->table_submitted)
            ->where(array('surname' => $surname))
            ->get()
            ->result();
    }

    public function hash()
    {
        return $this->hash_model->random_code();
    }

    public function get_user($id){
        $user = $this->db->select('a.*, GROUP_CONCAT(b.name SEPARATOR "||") as names, GROUP_CONCAT(b.value SEPARATOR "||") as "values"')
            ->from($this->forms_model->table_submitted.' a')
            ->join($this->forms_model->table_others.' b', 'a.id = b.user_id')
            ->where(array('a.id' => $id))
            ->get()
            ->row();
		if($user->values){
			$values = explode('||', $user->values);
			$names = explode('||', $user->names);
			foreach($names as $key => $name){
				isset($values[$key]) AND $user->$name = $values[$key];
			}
		}
		return $user;
    }

	public function get_users($visited = FALSE){
//        debug($visited);
		$this->db->select('a.*, GROUP_CONCAT(b.name SEPARATOR "||") as names, GROUP_CONCAT(b.value SEPARATOR "||") as "values"')
			->from($this->forms_model->table_submitted. ' a')
			->join($this->forms_model->table_others.' b', 'a.id = b.user_id', 'LEFT');
		if($visited){
			$this->db->join($this->printer_model->table_themes_printed . ' c', 'c.user_id = a.id');
		}
		$results = $this->db->order_by('surname ASC')
			->group_by('a.id')
			->get()
			->result_array();
		if($results){
			foreach ($results as $result) {
				$values = explode('||', get_value($results, 'values'));
				$names = explode('||', get_value($results, 'names'));
				foreach($names as $key => $name){
					isset($values[$key]) AND $result[$name] = $values[$key];
				}
			}
		}
		return $results;
	}

	public function get_list(){
        $a = $this->forms_model->table_submitted;
        $b = $this->forms_model->table_others;
		$this->db->select("a.*, CONCAT_WS(' ', a.surname, a.name, a.patronymic) as full_name", FALSE)
			->from($a . ' a')
            ->join($b . ' b', 'b.user_id = a.id');
        if($search_text = $this->input->get('search_text')){
            if(is_numeric($search_text)){
                $this->db->where(array('b.name' => 'number', 'b.value' => $search_text));
            } else {
                $this->db->like("CONCAT_WS(' ', a.surname, a.name, a.patronymic)", $this->input->get('search_text'));
            }
        }
        $results = $this->db->order_by('surname asc')
            ->group_by('a.id')
			->get()
			->result();
        return $results;
	}

	public function delete($id){
		$id OR show_404();
		$this->db->delete($this->forms_model->table_submitted, array('id' => (int)$id));
		$this->db->delete($this->forms_model->table_others, array('user_id' => (int)$id));
		return TRUE;
	}

	public function get_city($query){
		$list = $this->db->select('a.*, b.region_name_ru as region, c.country_name_ru as country')
			->from($this->table_cities. ' a')
			->join($this->table_regions. ' b', 'a.id_region = b.id')
			->join($this->table_countries. ' c', 'a.id_country = c.id')
			->like('city_name_ru', $query)
			->get()
			->result();
		$list = $this->city_ajax($list);
		return $list;
	}

	public function get_surname($query){
		$list = $this->db->select('a.*, GROUP_CONCAT(b.name SEPARATOR "||") as names, GROUP_CONCAT(b.value SEPARATOR "||") as "values"')
			->from($this->forms_model->table_submitted. ' a')
			->join($this->forms_model->table_others.' b', 'a.id = b.user_id', 'left')
			->like('a.surname', $query)
			->order_by('surname ASC')
			->group_by('b.user_id')
			->get()
			->result();
		$list = $this->surname_ajax($list);
		return $list;
	}

	public function get_special($query){
		$list = $this->db->select('*')
			->from($this->table_categs)
			->like('name', $query)
			->get()
			->result();
		$list = $this->categs_ajax($list);
		return $list;
	}

	public function surname_ajax($result){
		foreach($result as $key => $item){
			$item = (array)$item;
			$values = explode('||', $item['values']);
			$names = explode('||', $item['names']);
			foreach($names as $alias => $name){
				isset($values[$alias]) AND $item[$name] = $values[$alias];
			}
			$arr[] = array(
				'link' => base_url().'forms/'.$item['id'],
				'text' => get_value($item, 'surname').' '.get_value($item, 'name').' '. get_value($item, 'patronymic').'; '.get_value($item, 'city'),
				'value' => get_value($item, 'id'),
				'order' => $key
			);
		}
		return $arr;
	}

	public function city_ajax($result){
		foreach($result as $key => $item){
			$arr[] = array(
				'text' => get_value($item, 'city_name_ru').'; '.get_value($item, 'region').'; '.get_value($item, 'country'),
				'value' => get_value($item, 'city_name_ru').'; '.get_value($item, 'region').'; '.get_value($item, 'country'),
				'order' => $key
			);
		}
		return $arr;
	}

	public function categs_ajax($result){
		foreach($result as $key => $item){
			$arr[] = array(
				'text' => get_value($item, 'name'),
				'value' => get_value($item, 'name'),
				'order' => $key
			);
		}
		return $arr;
	}

	public function get_url($alias){
		switch($alias){
			case 'city':
				return base_url().'forms/get_city';
				break;
			case 'special':
				return base_url().'forms/get_special';
				break;
			case 'surname':
				return base_url().'forms';
				break;
		}
		return FALSE;
	}

	public function import_categs($file)
	{
		$data = array();
		$categs = new SimpleXMLElement(file_get_contents($file));
		foreach ($categs as $categ) {
			$user = (array)$categ;
			foreach ($this->categs as $value) {
				$buffer[$value] = $user['@attributes'][$value];
			}
			$data[] = $buffer;
		}
		$data AND $this->db->insert_batch($this->table_categs, $data);
	}

	public function get_categs(){
		return $this->db->get($this->table_categs)->result();
	}

	public function generate_xml($data){/**/
		$this->load->helper('download');
		$xml = new domDocument("1.0", "utf-8");
		$users = $xml->createElement('users');
		$xml->appendChild($users);
		foreach ($data as $item) {
			$user = $xml->createElement('user');
			foreach($item as $alias => $value){
				if($alias != 'names' AND $alias != 'values')
				$user->setAttribute($alias, $value);
			}
			$users->appendChild($user);
		}
		$file = $xml->saveXML();
		force_download('users.xml', $file);
	}

	public function generate_excel($data){
		$cols = array_to_list($this->forms_model->get_list(), 'alias', 'name');
		require_once(APPPATH.'helpers/simple_excel/simple_excel.php');
		$excel = new ExportDataExcel('browser');
		$excel->filename = 'users.xls';
		$excel->initialize();
		$excel->addRow($cols, 'Middle');
		$excel->addRow(array());
		foreach($data as &$user){
			$buffer = array();
            //Распаковка кастомных полей профиля
            if(isset($user['names'])){
                $names = explode('||', $user['names']);
                $values = explode('||', $user['values']);
                foreach($names as $key => $name){
                    $user[$name] = $values[$key];
                }
            }
            //Вставляем строку в excel
            foreach($cols as $alias => $name){
				$buffer[$alias] = get_value($user, $alias);
			}
			$excel->addRow($buffer);
		}
		return $excel->finalize();
	}

}

