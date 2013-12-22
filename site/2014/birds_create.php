<?php
header("Content-type: image/png");

$line_y = 135;
$bird1_x = 20;
$bird2_x = 155;
$bird3_x = 290;
$bird4_x = 425;
$bird5_x = 560;
$bird6_x = 695;

// Background
$im = imagecreatefrompng("birds_editor/assets/3casesIn1-blue-sky-empty.png");// 796x284

$bird = imagecreatefrompng("birds_editor/assets/birds/pissed-speaking.png");// 75x100
$bird_shift_x = 0;
$bird_shift_y = 5;
imagecopy($im, $bird, $bird1_x + $bird_shift_x, $line_y + $bird_shift_y, 0, 0, imagesx($bird), imagesy($bird));
imagecopy($im, $bird, $bird2_x + $bird_shift_x, $line_y + $bird_shift_y, 0, 0, imagesx($bird), imagesy($bird));
imagecopy($im, $bird, $bird3_x + $bird_shift_x, $line_y + $bird_shift_y, 0, 0, imagesx($bird), imagesy($bird));
imagecopy($im, $bird, $bird4_x + $bird_shift_x, $line_y + $bird_shift_y, 0, 0, imagesx($bird), imagesy($bird));
imagecopy($im, $bird, $bird5_x + $bird_shift_x, $line_y + $bird_shift_y, 0, 0, imagesx($bird), imagesy($bird));
imagecopy($im, $bird, $bird6_x + $bird_shift_x, $line_y + $bird_shift_y, 0, 0, imagesx($bird), imagesy($bird));

$bubble = imagecreatefrompng("birds_editor/assets/bubbles/bubble-big-left.png");// 216x122
$bubble_shift_x = 0;
$bubble_shift_y = 0;
imagecopy($im, $bubble, 22 + $bubble_shift_x, 5 + $bubble_shift_y, 0, 0, imagesx($bubble), imagesy($bubble));

$black = imagecolorallocate($im, 0, 0, 0);
$font = "birds_editor/assets/Gilles_Handwriting.ttf";
$font_size = 13;
imagettftext($im, $font_size, 0, 30, 15 + $font_size, $black, $font, "text in the bubble.");

// Separation bars
$white = imagecolorallocate($im, 255, 255, 255);
imagefilledrectangle ($im, (imagesx($im)/3) - 5, 0, (imagesx($im)/3) + 5, imagesy($im), $white);
imagefilledrectangle ($im, (imagesx($im)/3*2) - 5, 0, (imagesx($im)/3*2) + 5, imagesy($im), $white);

imagepng($im);
imagedestroy($im);
?>