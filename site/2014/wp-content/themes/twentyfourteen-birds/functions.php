<?php
if ( ! isset( $content_width ) ) {
	$content_width = 900;
}

add_filter( 'the_content', 'the_content_bd_filter');
function the_content_bd_filter( $content ) {
	global $post;

	$img_url = get_post_meta($post->ID, "large-image", true);
	$transcript = get_post_meta($post->ID, 'bubbles-text', true);
	$hidden = get_post_meta($post->ID, "hidden", true);
	$certified = get_post_meta($post->ID, "certified", true);

	
	$hidden_template_link = '<a title="%s" href="%s" class="hiddenMsg">Cette BD est cachée car elle a été signalée comme à ne pas mettre devant tous les yeux.<br/>Pour la voir quand même cliquez ce message.</a>';
	$hidden_template_banner = '<div class="hiddenMsg">Cette BD est cachée car elle a été signalée comme à ne pas mettre devant tous les yeux.</div>';
	$bd_template = '<div class="full-bd"><img class="bd" src="%s" alt="BD" title="%s"></div>';

	if( is_single() ) {
		$single_post_template = '';
		if($hidden) {
			$single_post_template = $hidden_template_banner;
		}
		$single_post_template .= $bd_template . '<h3>Description</h3><p>%s</p>';
		$single_post_template .= '<h3>Transcription</h3><blockquote>%s</blockquote>';
		$content = sprintf($single_post_template,$img_url,$post->title,$content,$transcript);
	}else
	if( is_home() || is_archive() || is_search() ) {
		if($hidden) {
			$content = sprintf($hidden_template_link ,$post->title,get_permalink());
		}else{
			$multiple_post_template = '<a href="%s" title="%s">' . $bd_template . '</a>';
			$content = sprintf($multiple_post_template,get_permalink(),$content,$img_url,$post->title);
		}
	}	

    return $content;
}
?>