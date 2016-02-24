<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cacher_model extends CI_Model {


    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->path = FCPATH.APPPATH."cache/";
        $this->cache_time = 3600 * 24;
    }


    public function save($filename, $data, $dir = FALSE, $time = FALSE) {
        $path = $this->path.$this->set_dir(FALSE, $dir);
        file_exists($path) OR mkdir($path, 0777, TRUE);
        $path .= $filename[0].'/';
        file_exists($path) OR mkdir($path, 0777, TRUE);
        $file = $path.$filename;
        if (write_file($file, $data)) {
            touch($file, time() + ($time ? $time : $this->cache_time));
            chmod($file, 0777);
            mt_rand(1, 1000) == 2 AND $this->clean_old($path);
            return TRUE;
        }
        return FALSE;
    }


    public function get($filename, $dir = FALSE) {
        $path = $this->path.$this->set_dir($filename, $dir).$filename;
        if (!file_exists($path)) {
            return NULL;
        }
        $data = read_file($path);
        if (time() > filemtime($path)) {
            unlink($path);
            return NULL;
        }
        return $data;
    }


    public function delete($filename, $dir = FALSE) {
        return unlink($this->path.$this->set_dir($filename, $dir).$filename);
    }


    public function clean($dir = FALSE, $delete = FALSE) {
        $path = $this->path.$this->set_dir(FALSE, $dir);
        delete_files($path, TRUE);
        $delete AND rmdir($path);
    }


    private function set_dir($filename = FALSE, $dir = FALSE, $with_subdir = TRUE) {
        $dir = (array)$dir;
        $filename AND $with_subdir AND $dir[] = $filename[0];
        return $dir ? str_replace("//", "/", implode("/", $dir)."/") : "";
    }


    private function clean_old($path) {
        $files = get_filenames($path, TRUE);
        $time = time();
        foreach ($files as $file) {
            $time > filemtime($file) AND unlink($file);
        }
    }


}