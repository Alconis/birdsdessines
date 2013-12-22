<?php
require('./wp-blog-header.php');
include('birds_header.php');


if( is_user_logged_in() ) {
	$current_user = wp_get_current_user();
	$current_user->get_role_caps();

	if($_GET['trashed'] == "1"){
		echo "La BD a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s. <a href='http://www.birdsdessines.fr'>Revenir &agrave; l'accueil du site.</a>";
		include('birds_footer.php');

		// Reset user role to subscriber
		if($current_user->has_cap('delete_published_posts')){
			$current_user->remove_cap('delete_published_posts');
		}

//@mail("webmaster@birdsdessines.fr", "BD supprimée par " . $current_user->display_name, "");
		return;
	}else{
		// Grant capabilities to delete published post
		$current_user->add_cap('delete_published_posts');
	}

	$post_id = $_GET['post_id'];
	$current_post = get_post( $post_id );

	if($current_user && $current_post && $current_post->post_author == $current_user->ID ){
?>

Bonjour <?= $current_user->display_name; ?>, cliquez sur le lien suivant pour confirmer la suppression de la BD intitul&eacute;e <strong>"<?= $current_post->post_title; ?>"</strong>:<br/><br/> 

<a class="delete_link" href="<? echo wp_nonce_url( get_bloginfo('url') . '/wp-admin/post.php?action=trash&amp;post=' . $post_id, 'trash-post_' . $post_id); ?>">Confirmer la suppression de ma BD ci-dessous :</a>

<br/>
<br/>
<img src="<? echo get_post_meta($post_id, "large-image", $single = true); ?>">
<br/>
<br/>
<?php
	}else{
?>
<?= $current_user->display_name; ?>, vous n'avez pas les acc&egrave;s suffisants pour supprimer la BD <?= $post_id; ?>
<?php
	}

}else{
?>
Veuillez vous authentifier pour supprimer une BD.
<?php
}
?>
 
<?php
include('birds_footer.php');
?>	