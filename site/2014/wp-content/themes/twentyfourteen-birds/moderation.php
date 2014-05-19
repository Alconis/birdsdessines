<div id="mod">
<?php

$current_user = wp_get_current_user();

////// HANDLE ACTIONS

$trash= $_GET['trash'];
if($trash){
	get_template_part( 'moderation', 'delete' );
	echo '</div>';
	return;
}

$action_result = '';

$view = $_GET['view'];
if(!$view) $view = 'last';

$detailID = $_GET['detail'];

$hide = $_GET['hide'];
if($hide){
	update_post_meta($hide, 'hidden', 1);
	$action_result .= 'La BD ' . $hide . ' est d&eacute;sormais cach&eacute;e par le bandeau.';
}

$show = $_GET['show'];
if($show){
	update_post_meta($show, 'hidden', 0);
	$action_result .= 'La BD ' . $show . ' n\'a plus de bandeau.';
}

$uncertify= $_GET['uncertify'];
if($uncertify){
	update_post_meta($uncertify, 'certified', 0);
	$action_result .= 'La BD ' . $uncertify. ' n\'a d&eacute;sormais plus de badge.';
}

$certify= $_GET['certify'];
if($certify){
	update_post_meta($certify, 'certified', 1);
	$action_result .= 'La BD ' . $certify. ' a maintenant un badge.';
}

$reset = $_GET['reset'];
if($reset){
	delete_post_meta($reset, 'moderation');
	$action_result .= 'Les signalements pour la BD ' . $reset . ' ont &eacute;t&eacute; remis &agrave; z&eacute;ro.';
}

$alert= $_GET['alert'];
if($alert){
	$moderation = get_post_meta($alert, 'moderation',true);
	if($moderation == null) $moderation = 0;
	update_post_meta($alert, 'moderation', ++$moderation);
	$action_result .= 'La BD ' . $id . ' a &eacute;t&eacute; signal&eacute;e.';
}

$untrash = $_GET['untrash'];
if($untrash){
	wp_untrash_post($untrash);
	delete_post_meta($untrash, 'moderator');
	$action_result .= 'La BD ' . $untrash . ' a &eacute;t&eacute; republi&eacute;e &agrave; partir de la corbeille.';
}

$delete_com = $_GET['delete_com'];
if($delete_com){
	wp_delete_comment($delete_com);
	$action_result .= 'Le commentaire ' . $delete_com . ' a &eacute;t&eacute; supprim&eacute;.';
}

$clean = $_GET['clean'];
if($clean){
	
	$directory = "/homez.44/alconis/birdsdessines.fr/bds/temp/";
	$tenDaysTime = time() - (10 * 24 * 60 * 60);

	$handler = opendir($directory);
	$files = Array();
	$i = 0;
	while ($file = readdir($handler)) {
		if ($file != '.' && $file != '..' && $file != 'index.php' && $file != 'birds_upload.php'){
			$files[$i++] = $file;
		}
	}
	closedir($handler);
	
	sort($files, SORT_STRING);
	
	$i = 0;
	foreach ($files as $file) {
		if (strcmp($tenDaysTime + ".png", $file) > 0){
			unlink($directory . $file);
			$i++;
		}
	}

	$action_result .= $i . ' BDs temporaires ont &eacute;t&eacute; supprim&eacute;es.';
}

if($action_result != '') echo '<div class="message">' . $action_result . '</div>';

if($view == 'last') $title = "50 derni&egrave;res BDs";
if($view == 'modo') $title = "File de mod&eacute;ration";
if($view == 'bin') $title = "Corbeille";
if($view == 'comments') $title = "Commentaires";
if($view == 'users') $title = "Utilisateurs";

echo '<h2>' . $title . '</h2>';

if($view == 'comments'){
	get_template_part( 'moderation', 'comments' );
	echo '</div>';
	return;
}
if($view == 'users'){
	get_template_part( 'moderation', 'users' );
	echo '</div>';
	return;
}

if($view == 'top'){
	get_template_part( 'moderation', 'top' );
	echo '</div>';
	return;
}
?>
<div id="list">

<?php

if($view == 'last'){
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => 50
	);

?>

<div class="message">Cliquez sur le titre d'une BD pour voir l'image, les commentaires et les actions de mod&eacute;ration.</div>

<?php
}

if($view == 'modo'){
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => 100,
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'meta_key' => 'moderation'
	);
?>

<div class="message">La file de mod&eacute;ration contient toutes les BDs signal&eacute;es class&eacute;es par nombre de signalements.</div>

<?php

}

if($view == 'bin'){
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => 50,
		'post_status' => 'trash',
		'orderby' => 'modified',
		'order' => 'DESC'
	);
?>

<div class="message">La corbeille contient les 50 derni&egrave;res BDs retir&eacute;es. Ces derni&egrave;res y restent 30 jours avant d'&ecirc;tre automatiquement et d&eacute;finitivement supprim&eacute;es.</div>

<?php

}

$query = new WP_Query($args);

while ( $query->have_posts() ) {
	$query->the_post();
	$post_id = get_the_ID();
	
	echo '<div class="post">';
	echo '<div class="mod_title"><a href="?view=' . $view . '&detail=' . $post_id . '">' . get_the_title() . '</a>';

	$certified = get_post_meta($post->ID, "certified", true);
	if($certified == 1)
		echo ' &nbsp;<img src="/wp-content/plugins/editeur-bd/editor/assets/icons/certified.png" style="width: 16px;height:16px;" alt="certified" title="BD certifi&eacute;e comme in&eacute;dite par son auteur !">';

	echo '</div>';
	echo '<div class="mod_author">' . get_the_author() . '</div>';
	echo '<div class="mod_time">' . human_time_diff( get_the_time('U'), current_time('timestamp') ) . '</div>';
	echo '<div class="mod_comm">' . get_comments_number() . '</div>';
	echo '<div class="mod_vote">' . get_post_meta($post_id, 'ratings_score', true) . '</div>';
	$moderation_count = get_post_meta($post_id, 'moderation', true);
	echo '<div class="mod_modo">' . ($moderation_count != '' ? $moderation_count : '0') . '</div>';

	$hidden = get_post_meta($post_id, 'hidden', true);
	if($hidden == 1){
		echo '<div class="mod_hidden"><img alt="Cette BD est cach&eacute;e (bandeau)" src="/wp-content/themes/twentyfourteen-birds/images/eye_exclamation.png"></div>';
	}

	echo '<div class="mod_author">' . get_post_meta($post_id, 'moderator', true) . '</div>';

	if($post_id == $detailID){
?>

<div id="details">
	<div id="bd">
		<a href="<?php the_permalink(); ?>"><img src="<?php echo get_post_meta($post_id, 'large-image', true); ?>" style="width:470px;"/></a><br/>
<?php 
if($view != 'bin'){
?>
		<a class="action" href="?view=<?=$view;?>&detail=<?=$post_id;?>&<?=$hidden?'show':'hide';?>=<?=$post_id;?>"><?=$hidden?'Enlever':'Ajouter';?> le bandeau <img src="/wp-content/themes/twentyfourteen-birds/images/eye_exclamation.png"></a><a class="action" href="?view=<?=$view;?>&detail=<?=$post_id;?>&alert=<?=$post_id;?>">Signaler la BD (+1 <img src="/wp-content/themes/twentyfourteen-birds/images/error.png">)</a><a class="action" href="?view=<?=$view;?>&detail=<?=$post_id;?>&reset=<?=$post_id;?>">Annuler les signalements (<img src="/wp-content/themes/twentyfourteen-birds/images/error.png"> =0)</a><a class="action" href="?view=<?=$view;?>&detail=<?=$post_id;?>&<?=$certified?'uncertify':'certify';?>=<?=$post_id;?>"><?=$certified?'Enlever':'Ajouter';?> le badge <img src="/wp-content/plugins/editeur-bd/editor/assets/icons/certified.png" style="width: 16px;height:16px;"></a>

<?php
}
if($view == 'bin'){ echo '<a class="action" href="?untrash=' . $post_id . '">Restaurer la BD</a>';}
if($view == 'modo'){ echo '<a class="action warning" href="?trash=' . $post_id . '">Supprimer la BD...</a>';}

?>
	</div>
	<div id="comments">

<?php
$params = array(
	'post_id' => $post_id,
	'order' => 'ASC'
);

if ($view == 'bin'){
	$params['status'] = 'post-trashed';
}

$comments = get_comments($params);
foreach($comments as $comment) :
?>

<div class="comment">
<strong><?php echo $comment->comment_author; ?></strong> : <?php echo $comment->comment_content; ?> <a href="?view=<?=$view;?>&detail=<?=$post_id;?>&delete_com=<?=$comment->comment_ID;?>">Supprimer</a>
</div> <!-- .comment -->

<?php endforeach; ?>

	</div> <!-- #comments -->
</div><!-- #details -->

<?php	}
	echo '</div> <!-- .post -->';
}
wp_reset_postdata();
?>
</div><!-- #list -->

</div><!-- #mod -->