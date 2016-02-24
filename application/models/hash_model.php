<?php

class hash_model extends CI_Model {

    /*
     *  Outputs an image using libgd
     *
     *    text   : the text-line (<position>:<font-size>:<character> ...)
     *    bars   : where to place the bars  (<space-width><bar-width><space-width><bar-width>...)
     *    scale  : scale factor ( 1 < scale < unlimited (scale 50 will produce
     *                                                   5400x300 pixels when
     *                                                   using EAN-13!!!))
     *    mode   : png,gif,jpg, depending on libgd ! (default='png')
     *    total_y: the total height of the image ( default: scale * 60 )
     *    space  : space
     *             default:
     *		$space[top]   = 2 * $scale;
     *		$space[bottom]= 2 * $scale;
     *		$space[left]  = 2 * $scale;
     *		$space[right] = 2 * $scale;
     */
    public function create_image($text, $bars, $code, $params = NULL){
        $params = set_params(array(
            'font' => FCPATH.APPPATH.'fonts/FreeSansBold.ttf',
            'bar_color' => array(0, 0, 0),
            'bg_color' => array(255, 255, 255),
            'text_color' => array(0, 0, 0),
            'scale' => 2,
            'total_y' => 80,
            'space' => '',
            'quality' => 90,
            'cache' => 3600 * 24 * 30,
			'type' => 'png'
        ), $params);
        $params->scale < 1 AND $params->scale = 2;
        $params->total_y = (int)$params->total_y;
        $params->total_y < 1 AND $params->total_y = (int)$params->scale * 60;
        $params->space OR $params->space = array(
            'top'=> 2 * $params->scale,
            'bottom' => 2 * $params->scale,
            'left' => 2 * $params->scale,
            'right' => 2 * $params->scale,
        );
        // Total width
        $xpos = 0;
        $width = TRUE;
        for ($i = 0; $i < strlen($bars); $i++) {
            $val = strtolower($bars[$i]);
            if ($width){
                $xpos += $val * $params->scale;
                $width = FALSE;
                continue;
            }
            // Tall bar
            preg_match("|[a-z]|", $val) AND $val = ord($val) - ord('a') + 1;
            $xpos += $val * $params->scale;
            $width = TRUE;
        }
        // Allocate image
        $total_x = ($xpos) + $params->space['right'] * 2;
        $xpos = $params->space['left'];
        function_exists("imagecreate") OR error("No GD support");
        $im = imagecreate($total_x, $params->total_y);
        // Creating two images
        $col_bg = ImageColorAllocate($im, $params->bg_color[0], $params->bg_color[1], $params->bg_color[2]);
        $col_bar = ImageColorAllocate($im, $params->bar_color[0], $params->bar_color[1], $params->bar_color[2]);
        $col_text = ImageColorAllocate($im, $params->text_color[0], $params->text_color[1], $params->text_color[2]);
        $height = round($params->total_y - ($params->scale * 10));
        $height2 = round($params->total_y - $params->space['bottom']);
        // Painting bars
        $width = TRUE;
        for ($i = 0; $i < strlen($bars); $i++){
            $val = strtolower($bars[$i]);
            if ($width){
                $xpos += $val * $params->scale;
                $width = FALSE;
                continue;
            }
            if (preg_match("|[a-z]|", $val)){
                // Tall bar
                $val = ord($val) - ord('a') + 1;
                $h = $height2;
            } else {
                $h = $height;
            }
            imagefilledrectangle($im, $xpos, $params->space['top'], $xpos + ($val * $params->scale) - 1, $h, $col_bar);
            $xpos += $val * $params->scale;
            $width = TRUE;
        }
        // Writing out text
        $chars = explode(" ", $text);
        reset($chars);
        while (list($n, $v) = each($chars)){
            if (trim($v)){
                $inf = explode(":", $v);
                $fontsize = $params->scale * ($inf[1] / /*1.8*/2.2);
                $fontheight = $params->total_y - ($fontsize / /*2.7*/2.4) + 1;
                @imagettftext($im, $fontsize, 0, $params->space['left'] + ($params->scale * $inf[0]) + 2, $fontheight, $col_text, $params->font, $inf[2]);
            }
        }
        // Output the image
        if ($params->cache) {
            ob_start();
        } else {
            header("Content-Type: image/png; name=\"barcode.png\"");
        }
        imagepng($im);
		imagedestroy($im);
		if ($params->cache) {
            $image = ob_get_contents();
			ob_end_clean();
			$image_new = imagecreatetruecolor(200, 40);
			imagecopyresampled($image_new, imagecreatefromstring($image), 0, 0, 17, 0, 200, 40, 200, 40);
			ob_start();
			imagepng($image_new);
			imagedestroy($image_new);
			$image = ob_get_contents();
			ob_end_clean();
			$image = base64_encode($image);
            // Saving to cache
            $this->cacher_model->save($code, $image, 'barcode', $params->cache);
            return $image;
        }
	}


    public function gen_ean_sum($ean) {
        $even = TRUE;
        $esum = $osum = 0;
        for ($i = strlen($ean) - 1; $i >= 0; $i--) {
            $even ? $esum += $ean[$i] : $osum += $ean[$i];
            $even = !$even;
        }
        return (10 - ((3 * $esum + $osum) % 10)) % 10;
    }


    public function valid_ean($ean) {
        $ean = substr($ean, 0, 12);
        return $ean.$this->gen_ean_sum($ean);
    }


    public function encode_ean($ean){
        $digits = array(3211, 2221, 2122, 1411, 1132, 1231, 1114, 1312, 1213, 3112);
        $mirror = array("000000", "001011", "001101", "001110", "010011", "011001", "011100", "010101", "010110", "011010");
        $guards = array("9a1a", "1a1a1", "a1a");
        $ean = trim($ean);
        (strlen($ean) < 12 OR strlen($ean) > 13 OR preg_match("|[^0-9]|i", $ean)) AND show_error("Invalid EAN-13 Code (must have 12/13 numbers)");
        $ean = $this->valid_ean($ean);
        $line = $guards[0];
        for ($i = 1; $i < 13; $i++){
            $str = $digits[$ean[$i]];
            $line .= ($i < 7 AND $mirror[$ean[0]][$i-1] == 1) ? strrev($str) : $str;
            $i == 6 AND $line .= $guards[1];
        }
        $line .= $guards[2];
        // Creating text
        $pos = 0;
        $text = "";
        for ($a = 0; $a < 13; $a++){
            $a > 0 AND $text .= " ";
            $text .= $pos.":12:".$ean[$a];
            $pos += ($a == 0 OR $a == 6) ? 12 : 7;
        }
        return array(
            'bars' => $line,
            'text' => $text,
        );
    }


    public function generate($code, $params = NULL){
        if (!$image = $this->cacher_model->get($code, 'barcode')) {
            if (!$bars = $this->encode_ean($code)) return FALSE;
            $image = $this->create_image($bars['text'], $bars['bars'], $code, $params);
        }
        return $image;
    }

    public function get_user_list_hash($str){
        $hash = '111100000000';
        $hash = substr_replace($hash, $str, -strlen($str), strlen($str));
        return $this->valid_ean($hash);
    }

    private function get_event_hash($id){
        $hash = '777700000000';
        $hash = substr_replace($hash, $id, -strlen($id), strlen($id));
        return $hash;
    }

    private function get_user_hash(){
        $rand = mt_rand(1, 9).random_str('numeric', 11);
        return (strpos($rand, '7777') === 0 OR strpos($rand, '1111') === 0) ? $this->random_code('user') : $rand;
    }

    public function random_code($type = 'user', $id = FALSE) {
        switch($type){
            case 'event': $rand = $this->get_event_hash($id);break;
            default: $rand = $this->get_user_hash();
        }
        return $this->valid_ean($rand);
    }


}