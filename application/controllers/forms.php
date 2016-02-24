<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forms extends CI_Controller
{

    /*
     * Главная странциа
     * */
    public function index($id = FALSE)
    {
        Scripts::set(Settings::get('select'));
        Scripts::set(Settings::get('typeahead'));
        $this->load->helper('form');
        $form = $this->forms_model->get_form();
        $data = array(
            'form' => $form
        );
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->forms_model->dynamic_validate($data['form']); //Валидация данных
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('site/forms/index', $data);
            } else {
                //Обновить или добавить данные?
                if ($this->input->post('id')) {
                    $this->forms_model->update($this->input->post('id'));
                    $id = $this->input->post('id');
                } else {
                    $id = $this->forms_model->add_record();
                }
                redirect(base_url() . 'forms/view/' . $id);
            }
        } //Если альбом редактируется, а не создаётся
        elseif ($id) {
            $row = $this->forms_model->get_form((int)$id);
            $user = $this->users_model->get_user((int)$id);
            if (count($row) AND count($user)) {
                foreach ($user as $key => $value) {
                    $_POST[$key] = $value;
                }
                $this->load->view('site/forms/index', array(
                    'edit' => TRUE,
                    'form' => $form,
                ));
            } else {
                redirect('/forms/failed');
            }
        } //Форма добавления альбома
        else {
            $this->load->view('site/forms/index', $data);
        }
    }

    public function view($id)
    {
        $data = array(
            'user' => $this->users_model->get_user($id),
            'form' => $this->forms_model->get_form(),
            'print_history' => $this->printer_model->get_print_history($id)
        );
        if ($theme = $this->input->get('theme')) {
            $this->printer_model->proccess($theme, (int)$id);
            redirect(base_url() . 'forms/view/' . $id);
        }
        $this->load->view('site/forms/view', $data);
    }

    public function print_page($theme_id, $user_id)
    {
        $this->printer_model->write_in_history($theme_id, $user_id);
        $content = $this->printer_model->parse_theme($theme_id, $user_id);
        $this->load->view('site/forms/printer', array('content' => $content));
    }

    public function pager($page = 1)
    {
        $list = $this->users_model->get_list();
        $count = count($list);
        $this->db->limit(Settings::get('items_per_page'), Settings::get('items_per_page') * ($page - 1));
        $list = $this->users_model->get_list();
        $this->pager_model->get_pager(array(
            'base_url' => base_url() . 'forms/pager',
            'total_rows' => $count,
            'per_page' => Settings::get('items_per_page'),
            'uri_segment' => 3,
        ));
        $this->load->view('site/forms/pager', array('list' => $list));
    }

    public function user_delete($id, $ajax = FALSE)
    {
        if ((int)$id) {
            $this->users_model->delete($id);
            if (!$ajax) {
                redirect('forms/pager');
            } else {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('id' => $id)));
            }
        } else {
            show_error('Error. User not deleted');
        }
    }

//	public function printer(){
//		ini_set("display_errors", 1);
//		ini_set("track_errors", 1);
//		ini_set("html_errors", 1);
//		error_reporting(E_ALL);
//		shell_exec('lp -d Samsung_M2020_Series /home/kubuntu/Downloads/pdf-sample.pdf');
////		exec('C:\regmaster\htdocs\AcrobatReaderDC\Reader\AcroRd32.exe /t "'.APPPATH.'\cache\1.pdf" "printer1"');
//	}

    public function find_user()
    {
        $result = $this->users_model->find($this->input->get('surname'));
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('result' => $result)));
    }

    public function get_city()
    {
        $query = $this->input->post('query');
        $result = $this->users_model->get_city($query);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_surname()
    {
        $query = $this->input->post('query');
        $result = $this->users_model->get_surname($query);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function find_surname()
    {
        $id = $this->input->get('name');
        $ajax = $this->input->get('ajax');
//		$name = explode(' ', $name);
//		if(count($name) >= 2){
//			$params = array('surname' => $name[0], 'name' => $name[1]);
//			$name[2] != ';' AND $params = array('surname' => $name[0], 'name' => $name[1], 'patronymic' => rtrim($name[2], ';'));
//			$result = $this->db->get_where($this->forms_model->table_submitted, $params)->row();
//		} else {
//			$result = FALSE;
//		}
        if (is_numeric($id)) {
            $result = $this->db->get_where($this->forms_model->table_submitted, array('id' => $id))->row();
        } else {
            $result = FALSE;
        }
        if ($ajax) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        } else {
            if ($result AND $result->id) {
                redirect(base_url() . 'forms/view/' . $result->id);
            } else {
                show_error('undefined user');
            }
        }
    }

    public function get_special()
    {
        $query = $this->input->post('query');
        $result = $this->users_model->get_special($query);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function scanner()
    {
        if ($hash = $this->input->post('hash')) {
            $user = $this->forms_model->get_user($hash, 'hash');
            $user AND redirect(base_url() . 'forms/view/' . $user->id);
        }
        $this->load->view('site/forms/scanner');
    }

    /*
     * Генерация баркодов(На случай если их нет)
     * */
//    public function generate_barcodes()
//    {
//        $users = $this->db->get_where($this->forms_model->table_submitted)->result();
//        foreach ($users as $user) {
//            $barcode = $this->users_model->hash();
//            $this->db->update($this->forms_model->table_submitted, array('hash' => $barcode), array('id' => $user->id));
//        }
//    }


}
