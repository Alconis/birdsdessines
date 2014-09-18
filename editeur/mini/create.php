<?php
header("Content-type: image/png");

require_once('drawing_tools.php');

$bd_format = $_GET['format'];
if(!$bd_format) $bd_format = '3';
$bd_format = intval($bd_format);
$background_name = $_GET['back'];
if(!$background_name ) $background_name = 'bluesky';

if($bd_format == 4) {
    $bird1_name = $_GET['bird1'];
    $bird2_name = $_GET['bird2'];
    $bubble_name = $_GET['bubble'];
    $text1 = stripcslashes(urldecode($_GET['text1']));
    $text2 = stripcslashes(urldecode($_GET['text2']));
    $texts = array($text1, $text2);

    $canvas_img = create_canvas_from_background('facebook');
    draw_bird($canvas_img, $bird1_name, 50, 255);
    draw_bird($canvas_img, $bird2_name, 255, 255);
    draw_bubble($canvas_img, $bubble_name, $texts, 40, 40);
    print_bd($canvas_img);
}

if($bd_format == 1) {
    $bird1_name = $_GET['bird1'];
    $bird2_name = $_GET['bird2'];
    $bubble_name = $_GET['bubble'];
    $text1 = stripcslashes(urldecode($_GET['text1']));
    $text2 = stripcslashes(urldecode($_GET['text2']));
    $texts = array($text1, $text2);

    $canvas_img = create_canvas_image($bd_format);
    draw_background($canvas_img, $bd_format, $background_name);
    draw_bird($canvas_img, $bird1_name, 10, 115);
    draw_bird($canvas_img, $bird2_name, 150, 115);
    draw_bubble($canvas_img, $bubble_name, $texts, 15, 20);
    print_bd($canvas_img);
}

if($bd_format == 2) {
    $bird1_name = $_GET['bird1'];
    $bird2_name = $_GET['bird2'];
    $bird3_name = $_GET['bird3'];
    $bird4_name = $_GET['bird4'];
    $bubble1_name = $_GET['bubble1'];
    $bubble2_name = $_GET['bubble2'];
    $vbar_hidden = $_GET['vbar'] == 'hide';
    $text1 = stripcslashes(urldecode($_GET['text1']));
    $text2 = stripcslashes(urldecode($_GET['text2']));
    $texts1 = array($text1, $text2);
    $text3 = stripcslashes(urldecode($_GET['text3']));
    $text4 = stripcslashes(urldecode($_GET['text4']));
    $texts2 = array($text3, $text4);

    $canvas_img = create_canvas_image($bd_format);
    draw_background($canvas_img, $bd_format, $background_name);
    if(!$vbar_hidden) draw_vertical_bar($canvas_img, imagesx($canvas_img)/2);
    draw_bird($canvas_img, $bird1_name, 10, 115);
    draw_bird($canvas_img, $bird2_name, 150, 115);
    draw_bubble($canvas_img, $bubble1_name, $texts1, 15, 20);
    draw_bird($canvas_img, $bird3_name, 280, 115);
    draw_bird($canvas_img, $bird4_name, 420, 115);
    draw_bubble($canvas_img, $bubble2_name, $texts2, 300, 20);
    print_bd($canvas_img);
}

if($bd_format == 3) {
    $bird1_name = $_GET['bird1'];
    $bird2_name = $_GET['bird2'];
    $bird3_name = $_GET['bird3'];
    $bird4_name = $_GET['bird4'];
    $bird5_name = $_GET['bird5'];
    $bird6_name = $_GET['bird6'];
    $bubble1_name = $_GET['bubble1'];
    $bubble2_name = $_GET['bubble2'];
    $bubble3_name = $_GET['bubble3'];
    $vbar1_hidden = $_GET['vbar1'] == 'hide';
    $vbar2_hidden = $_GET['vbar2'] == 'hide';
    $text1 = stripcslashes(urldecode($_GET['text1']));
    $text2 = stripcslashes(urldecode($_GET['text2']));
    $texts1 = array($text1, $text2);
    $text3 = stripcslashes(urldecode($_GET['text3']));
    $text4 = stripcslashes(urldecode($_GET['text4']));
    $texts2 = array($text3, $text4);
    $text5 = stripcslashes(urldecode($_GET['text5']));
    $text6 = stripcslashes(urldecode($_GET['text6']));
    $texts3 = array($text5, $text6);

    $canvas_img = create_canvas_image($bd_format);
    draw_background($canvas_img, $bd_format, $background_name);
    if(!$vbar1_hidden) draw_vertical_bar($canvas_img, imagesx($canvas_img)/3);
    if(!$vbar2_hidden) draw_vertical_bar($canvas_img, imagesx($canvas_img)/3*2);
    draw_bird($canvas_img, $bird1_name, 10, 115);
    draw_bird($canvas_img, $bird2_name, 150, 115);
    draw_bubble($canvas_img, $bubble1_name, $texts1, 15, 20);
    draw_bird($canvas_img, $bird3_name, 280, 115);
    draw_bird($canvas_img, $bird4_name, 420, 115);
    draw_bubble($canvas_img, $bubble2_name, $texts2, 300, 20);
    draw_bird($canvas_img, $bird5_name, 550, 115);
    draw_bird($canvas_img, $bird6_name, 690, 115);
    draw_bubble($canvas_img, $bubble3_name, $texts3, 575, 20);
    print_bd($canvas_img);
}
?>												