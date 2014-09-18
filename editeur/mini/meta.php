<?php

$library = array(
    'bubbles' => array(
        'big_left',
        'big_right',
        'empty',
        'heart',
        'hearts',
        'left_right',
        'little_left',
        'little_right',
        'right_left',
        'thought_left',
        'thought_right',
        'fb_big_left',
        'fb_big_right',
        'fb_left',
        'fb_right'
    ),
    'birds' => array (
        'normal',
        'normal_left',
        'normal_right',
        'normal_down',
        'normal_down_left',
        'normal_down_right',
        'normal_up_left',
        'normal_up_right',
        'afraid',
        'afraid_left',
        'afraid_right',
        'afraid_speaking',
        'afraid_speaking_left',
        'afraid_speaking_right',
        'amused_left',
        'amused_right',
        'bending_left',
        'bending_right',
        'blind_left',
        'blind_right',
        'sing_left',
        'sing_right',
        'crazy',
        'excusing_left',
        'excusing_right',
        'go_left',
        'go_right',
        'flap_left',
        'flap_right',
        'haughty',
        'haughty_speaking',
        'laughing_left',
        'laughing_right',
        'listening_left',
        'listening_right',
        'love',
        'love_left',
        'love_right',
        'mdr_left',
        'mdr_right',
        'pissed',
        'pissed_speaking',
        'speaking',
        'speaking_left',
        'speaking_right',
        'whispering_left',
        'whispering_right'
    ),
    'news' => array(
        'afraid',
        'behind_newspaper',
        'normal',
        'normal_left',
        'normal_right',
        'pissed',
        'speaking_left',
        'speaking_right'
    ),
    'lady' => array(
        'love_left',
        'love_right',
        'normal',
        'normal_left',
        'normal_right',
        'shocked',
        'smile_left',
        'smile_right',
        'speaking',
        'speaking_left',
        'speaking_right'
    ),
    'baby' => array(
        'girl_angry',
        'girl_ask',
        'girl_crying',
        'girl_normal_left',
        'girl_normal_right',
        'girl_speaking',
        'girl_speaking_left',
        'girl_speaking_right',
        'girl_sulk',
        'boy_angry',
        'boy_ask',
        'boy_crying',
        'boy_normal_left',
        'boy_normal_right',
        'boy_speaking',
        'boy_speaking_left',
        'boy_speaking_right',
        'boy_sulk'
    ),
    'politic' => array(
        'angry',
        'normal_left',
        'normal_right',
        'shocked',
        'speaking',
        'speaking_left',
        'speaking_right'
    )
);


Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
Header('Content-Type: application/json');


echo json_encode($library);
?>