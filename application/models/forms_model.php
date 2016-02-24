<?php

class forms_model extends CI_Model
{

    public $table = 'forms';
    public $table_submitted = 'forms_submitted';
    public $table_others = 'forms_others';

    function __construct()
    {
        parent::__construct();
    }

    public function get_list()
    {
        return $this->db->select('*')->from($this->table)->order_by('position asc')->get()->result();
    }


    public function get_record($value, $mode = 'id')
    {
        return $this->db->get_where($this->table, array($mode => $value))->row();
    }

	public function get_user($value, $mode = 'id'){
		return $this->db->get_where($this->table_submitted, array($mode => $value))->row();
	}


    /*
     * Добавить запись в Mysql
     * */
    public function add_record()
    {
        $data = array();
        $post = $this->input->post();
        $required = $this->users_model->map;
        unset($required['id'], $required['hash']);//id и хеш пока неизвестны
        foreach ($required as $value) {
			if($value == 'surname'){
				$post[$value] = $this->parse_surname($post[$value]);
			}
            $data[$value] = $post[$value];
            unset($post[$value]);
        }
        $data['hash'] = $this->users_model->hash();
        $data AND $this->db->insert($this->table_submitted, $data);
		$id = $this->db->insert_id();
		unset($post['id']);
		if($post AND count($post)){
            $data = array();
            foreach ($post as $key => $value) {
                $data[] = array(
                    'user_id' => $id,
                    'name' => $key,
                    'value' => $value,
                );
            }
            $data AND $this->db->insert_batch($this->table_others, $data);
        }
		return $id;
    }

    /*
     * Обновить запись в Mysql
     * */
    public function update($id){
		$data = array();
		$post = $this->input->post();
		$required = $this->users_model->map;
		unset($required['id'], $required['hash']);//id и хеш пока неизвестны
		foreach ($required as $value) {
			if($value == 'surname'){
				$post[$value] = $this->parse_surname($post[$value]);
			}
			$data[$value] = $post[$value];
			unset($post[$value]);
		}
       	$data AND $this->db->update($this->table_submitted, $data, array('id' => $id));
		unset($post['id']);
		if($post AND count($post)){
			$data = array();
			foreach ($post as $key => $value) {
				$buffer1 = array(
					'user_id' => $id,
					'name' => $key,
//					'value' => $value,
				);
				$buffer2 = array(
					'user_id' => $id,
					'name' => $key,
					'value' => $value,
				);
				$this->db->delete($this->table_others, $buffer1);
				$data[] = $buffer2;
			}
			$data AND $this->db->insert_batch($this->table_others, $data);
		}
    }

	public function parse_surname($surname){
		$surname = explode(';', $surname);
		$surname = explode(' ', trim($surname[0]));
		return $surname[0];
	}

    /*
     * Удалить запись из Mysql
     * */
    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => (int)$id));
    }

    /*
     * Валидация формы добавление параметра
     * */
    public function validate()
    {
        $this->form_validation->set_rules('name', 'Название', 'trim|required');
        $this->form_validation->set_rules('alias', 'Индентификатор', 'trim|required');
        $this->form_validation->set_rules('values', 'Возможные значения', 'trim');
        $this->form_validation->set_rules('rules', 'Правила валидации', 'trim|required');
        $this->form_validation->set_rules('position', 'Позиция', 'trim|integer');
        $this->form_validation->set_rules('publish', 'Активность', 'trim|integer');
        $this->input->post('id') AND $this->form_validation->set_rules('id', 'id', 'not_required');
    }

    public function dynamic_validate($form)
    {
        if ($form AND count($form)) {
            foreach ($form as $item) {
                $this->form_validation->set_rules($item->alias, $item->name, $item->rules);
            }
        }
    }

    public function get_form()
    {
        return $this->db->select('*')->from($this->table)->where(array('publish' => 1))->order_by('position asc')->get()->result();
    }

    public function explode_values($values)
    {
        $result = array();
        $values = explode('|', $values);
        foreach ($values as $value) {
            $result[$value] = $value;
        }
        return $result;

    }

	/*
 	* Добавить запись в Mysql
 	* */
	public function add_record_form() {
		$data = array(
			'id' => NULL,
			'name' => $this->input->post('name'),
			'alias' => $this->input->post('alias'),
			'values' => $this->input->post('values'),
			'rules' => $this->input->post('rules'),
			'position' => $this->input->post('position'),
			'publish' => $this->input->post('publish'),
		);
		$this->db->insert($this->table, $data);
	}

	/*
	 * Обновить запись в Mysql
	 * */
	public function update_record_form($id){
		$data = array(
			'name' => $this->input->post('name'),
			'alias' => $this->input->post('alias'),
			'values' => $this->input->post('values'),
			'rules' => $this->input->post('rules'),
			'position' => $this->input->post('position'),
			'publish' => $this->input->post('publish'),
		);
		return $this->db->update($this->table, $data, array('id' => $id));
	}
}