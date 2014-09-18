<?php

function wrapText($string, $width, $fontFace, $fontSize, $maxLines){
    $ret = "";
    $arr = explode(' ', $string);
    $nbLines = 1;
    
    foreach ( $arr as $word ){
        $teststring = $ret.' '.$word;
        $testbox = imagettfbbox($fontSize, 0, $fontFace, $teststring);
        if ( $testbox[2] > $width ){
            if($nbLines >= $maxLines){
                return $ret;
            }
            $ret.=($ret==""?"":"\n").$word;
            $nbLines++;
        } else {
            $ret.=($ret==""?"":' ').$word;
        }
    }
    return $ret;
}

function create_canvas_image($square_count) {
    $square_width = 267;
    $square_height = 284;
    $border_thickness = 10;

    $image_width = ($square_count*$square_width) + (2*$border_thickness);
    $image_height = $square_height + (2*$border_thickness);

    $canvas_img = imagecreatetruecolor($image_width, $image_height);
    imagesavealpha($canvas_img, true);

    $transparent_colour = imagecolorallocatealpha($canvas_img, 0, 0, 0, 127);
    imagefill($canvas_img, 0, 0, $transparent_colour);

    return $canvas_img;
}

function get_background_image($square_count, $bname) {
    $file_name = "assets/back_" . $square_count . "sq_" . $bname . ".png";
    if(file_exists($file_name)) {
        return imagecreatefrompng($file_name);
    }else{
        return null;
    }
}

function create_canvas_from_background($bname) {
    $file_name = "assets/back_" . $bname . ".png";
    if(file_exists($file_name)) {
        $background_img = imagecreatefrompng($file_name);
    }else{
        $background_img = null;
    }
    
    $image_width = imagesx($background_img);
    $image_height = imagesy($background_img);

    $canvas_img = imagecreatetruecolor($image_width, $image_height);
    imagesavealpha($canvas_img, true);

    $transparent_colour = imagecolorallocatealpha($canvas_img, 0, 0, 0, 127);
    imagefill($canvas_img, 0, 0, $transparent_colour);
    if($background_img != null) {
        imagecopy($canvas_img, $background_img, 0, 0, 0, 0, $image_width, $image_height);
    }

    return $canvas_img;
}

function get_bird_image($bname) {
    $separator = '$';
    $sep_index = strpos($bname, $separator);
    if($sep_index > 0) {
        $directory_name = substr($bname, 0, $sep_index);
        $bname = substr($bname, $sep_index+1);
    }else{
        $directory_name = 'birds';
    }
    $file_name = "assets/" . $directory_name . "/" . $bname . ".png";
    if(file_exists($file_name)) {
        return imagecreatefrompng($file_name);
    }else{
        return null;
    }
}

function get_bubble_image($bname) {
    $file_name = "assets/bubbles/" . $bname . ".png";
    if(file_exists($file_name)) {
        return imagecreatefrompng($file_name);
    }else{
        return null;
    }
}

function draw_background($canvas_img, $square_count, $back_name) {
    $background_img = get_background_image($square_count, $back_name);
    if($background_img) {
        imagecopy($canvas_img, $background_img, 0, 0, 0, 0, imagesx($background_img), imagesy($background_img));
        return true;
    }
    return false;
}

function draw_vertical_bar($canvas_img, $x) {
    $color = imagecolorallocate($canvas_img, 255, 255, 255);
    $bart_width = 10;
    imagefilledrectangle($canvas_img, $x - ($bart_width / 2), 0, $x + ($bart_width / 2), imagesy($canvas_img), $color);
}

function draw_bird($canvas_img, $bird_name, $dest_x, $dest_y) {
    $bird_img = get_bird_image($bird_name);
    if($bird_img ) {
        imagecopy($canvas_img, $bird_img , $dest_x, $dest_y, 0, 0, imagesx($bird_img ), imagesy($bird_img ));
        return true;
    }
    return false;
}

function draw_bubble($canvas_img, $bubble_name, $texts, $dest_x, $dest_y) {
    $bubble_img = get_bubble_image($bubble_name);
    if($bubble_img) {
        imagecopy($canvas_img, $bubble_img , $dest_x, $dest_y, 0, 0, imagesx($bubble_img ), imagesy($bubble_img ));
        draw_bubble_texts($canvas_img, $bubble_name, $texts, $dest_x, $dest_y);
        return true;
    }else{
        return false;
    }
}

function draw_bubble_texts($canvas_img, $bubble_name, $texts, $bubble_x, $bubble_y) {
    $nb_texts = count($texts);
    if($nb_texts == 0) return false;
    $text1 = $texts[0];
    if($nb_texts > 1) {
        $text2 = $texts[1];
    }

    $color= imagecolorallocate($canvas_img, 0, 0, 0);
    $font = "assets/Gilles_Handwriting.ttf";
    $font_size = 13;
    $angle = 0;

    $text1_x = $bubble_x + 10;
    $text1_y = $bubble_y + 10 + $font_size;
    $bubble1_width = 200;
    $text2_x = $bubble_x + 10;
    $text2_y = $bubble_y + 60 + $font_size;
    $bubble2_width = 200;
    $maxLines1 = 4;
    $maxLines2 = 2;

    switch($bubble_name) {
        case 'full' :
        case 'big_left' :
        case 'big_right' : {
            $text2 = null;
            break;
        }
        case 'thought_left' :
        case 'thought_right' : {
            $text1_x = $bubble_x + 20;
            $text1_y = $bubble_y + 30 + $font_size;
            $text2 = null;
            break;
        }
        case 'right_left' : {
            $text1_x = $bubble_x + 50;
            $text1_y = $bubble_y + 5 + $font_size;
            $maxLines1 = 2;
            break;
        }
        case 'left_right' : {
            $text1_y = $bubble_y + 5 + $font_size;
            $text2_x = $bubble_x + 40;
            $maxLines1 = 2;
            break;
        }
        case 'fb_big_left' : 
        case 'fb_big_right' : {
            $font_size = 20;
            $text1_x = $bubble_x + 15;
            $text1_y = $bubble_y + 15 + $font_size;
            $maxLines1 = 4;
            $bubble1_width = 350;
            $text2 = null;
            break;
        }
        case 'fb_right_left' : {
            $font_size = 20;
            $text1_x = $bubble_x + 50;
            $text1_y = $bubble_y + 15 + $font_size;
            $maxLines1 = 2;
            $bubble1_width = 300;

            $text2_x = $bubble_x + 15;
            $text2_y = $bubble_y + 150 + $font_size;
            $maxLines2 = 2;
            $bubble2_width = 300;
            break;
        }
        case 'fb_left_right' : {
            $font_size = 20;
            $text1_x = $bubble_x + 15;
            $text1_y = $bubble_y + 15 + $font_size;
            $maxLines1 = 2;
            $bubble1_width = 300;

            $text2_x = $bubble_x + 50;
            $text2_y = $bubble_y + 150 + $font_size;
            $maxLines2 = 2;
            $bubble2_width = 300;
            break;
        }
    }

    if($text1) {
        $wrapped_text = wrapText($text1, $bubble1_width, $font, $font_size, $maxLines1);
        imagettftext($canvas_img, $font_size, $angle, $text1_x, $text1_y, $color, $font, $wrapped_text);
    }
    if($text2) {
        $wrapped_text = wrapText($text2, $bubble2_width, $font, $font_size, $maxLines2);
        imagettftext($canvas_img, $font_size, $angle, $text2_x, $text2_y, $color, $font, $wrapped_text);
    }
}

function print_bd($canvas_img) {
    imagepng($canvas_img);
    imagedestroy($canvas_img);
}
?>