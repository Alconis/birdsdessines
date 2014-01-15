<?php

$trash = $_GET['trash'];
$moderation_type = $_GET['mod_type'];
$current_user = wp_get_current_user();
$post = get_post($trash);
$bd = get_post_meta($trash, "large-image", $single = true);
$author = get_userdata($post->post_author);

$confirm= $_GET['confirm'];
if($confirm == '1'){
	// Add the current user as moderator for this BD
	update_post_meta($post->ID, 'moderator', $current_user->user_nicename);

	// Retrieve Mail text content
	$mail_content = $_POST['mail_content'];

	// Retrieve BD content
	$handle = fopen($bd, "rb");
	$contents = '';
	while (!feof($handle)) {
  		$contents .= fread($handle, 1024*1024);
	}
	fclose($handle);
 
	$png_encoded = base64_encode($contents);
	
	// Prepare mail options.
	$to		= $author->user_email;
	$from		= "webmaster@birdsdessines.fr";
	$subject 	= "Votre BD " . $post->post_title . " a ete moderee";
	$body_msg 	= "Bonjour <strong>" . $author->user_nicename . "</strong>,<br/><p>Votre BirdsDessines \"" . $post->post_title . "\" a &eacute;t&eacute; retir&eacute;e du site BirdsDessin&eacute;s.fr pour la/les raisons suivantes :</p>";
	$body_msg	.= $mail_content;

	// Display mail content
	echo "<h2>Contenu du mail envoy&eacute;</h2>";
	echo $body_msg;
	echo "<br/>Pi&egrave;ce jointe:<br/><img src=\"".$bd."\">";
 
	// Generate a boundary string
	$semi_rand = md5(time());
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
 
	// Add the headers for a file attachment
	$headers = "From: " . $from;
	$headers .= "\nMIME-Version: 1.0\n" .
      		"Content-Type: multipart/mixed;\n" .
      		" boundary=\"{$mime_boundary}\"";
 
	// Add a multipart boundary above the plain message
	$message = "This is a multi-part message in MIME format.\n\n" .
     		"--{$mime_boundary}\n" .
     		"Content-Type: text/html; charset=\"iso-8859-1\"\n" .
     		"Content-Transfer-Encoding: 7bit\n\n" .
     	$body_msg . "\n\n";
 
	// Base64 encode the image data
	$data = chunk_split($png_encoded);
 
	// Add file attachment to the message
	$message .= "--{$mime_boundary}\n" .
      		"Content-Type: image/png;\n" .
      		" name=\"votre_birdsdessine.png\"\n" .
      		"Content-Disposition: attachment;\n" .
      		" filename=\"votre_birdsdessine.png\"\n" .
      		"Content-Transfer-Encoding: base64\n\n" .
      	$data . "\n\n" .
      		"--{$mime_boundary}--\n";
 
	// Send the message
	$ok = @mail($to, $subject, $message, $headers);
	if ($ok) {
		echo "Envoi mail auteur: OK<br/>";
	} else {
		echo "Envoi mail auteur: ERROR<br/>";
	}

	// Send the message to the moderator
	$ok = @mail($current_user->user_email, $subject, $message, $headers);
	if ($ok) {
		echo "Envoi mail moderateur: OK";
	} else {
		echo "Envoi mail moderateur: ERROR";
	}

	// Grant current user with temporary trash cap
	$current_user->get_role_caps();
	$current_user->add_cap('delete_published_posts');

	wp_delete_post($post->ID);

	if($current_user->has_cap('delete_published_posts')){
		$current_user->remove_cap('delete_published_posts');
	}

	echo '<div class="message">La BD a &eacute;t&eacute; mise dans la corbeille et l\'auteur a &eacute;t&eacute; averti par un courriel.</div>';
	wp_reset_postdata();
	return;
}

$body_msg = '';
if ("malformed" == $moderation_type){
	$body_msg .= "<p>Les BDs que vous publiez sur le site ne doivent pas contenir d'erreurs";
	$body_msg .= " de conception (oubli de bulle, d'oiseau, texte trop long dans les bulles etc.).</p>";
}elseif("pub" == $moderation_type || "private" == $moderation_type){
	$body_msg .= "<p>Les BDs que vous publiez sur le site ne doivent pas faire de publicit&eacute;";
	$body_msg .= " ou &ecirc;tre destin&eacute;e &agrave;  votre entourage ou un groupe restreint. ";
	$body_msg .= "Pour cela, utilisez les autres options \"Envoyer ma BD par mail\" ou ";
	$body_msg .= "\"T&eacute;l&eacute;charger ma BD sur mon ordinateur\" dans les options d'exportation. ";
	$body_msg .= "La publication d'une BirdsDessines sur le site BirdsDessin&eacute;.fr ne concerne ";
	$body_msg .= "que les BDs destin&eacute;e &agrave; tout le monde.</p>";
}elseif("ortho" == $moderation_type || "insulte" == $moderation_type){
	$body_msg .= "<p>Les BDs que vous publiez sur le site ne doivent pas contenir de faute d'orthographe ";
	$body_msg .= "et &ecirc;tre r&eacute;dig&eacute;e dans un niveau de langage correct d&eacute;pourvu de toute vulgarit&eacute; et/ou insulte.</p>";
}elseif("doublon" == $moderation_type){
	$body_msg .= "<p>Le contenu de la BD que vous avez publi&eacute; a &eacute;t&eacute; signal&eacute; comme maintes fois d&eacute;j&agrave; publi&eacute;.";
	$body_msg .= " Aussi, afin de ne pas polluer le site par trop de redondances, veillez &agrave; &ecirc;tre original !</p>";
}else{
	$body_msg .= "&lt;&lt; Ecrivez ici la justification ou choisissez ci-dessus un type de mod&eacute;ration pr&eacute;d&eacute;fini. &gt;&gt;\n";
}
 
$body_msg .= "Vous trouverez la BD retir&eacute;e en pi&egrave;ce jointe de ce mail.
Merci de votre compr&eacute;hension et &agrave; bient&ocirc;t sur BirdsDessin&eacute;s.fr.

L'&eacute;quipe de mod&eacute;ration de BirdsDessin&eacute;s.fr
";
?>

<h3>Mettre la BD suivante dans la corbeille:</h3>

<strong>Auteur:</strong> <?=$author->user_nicename;?>
<img src="<?=$bd;?>">

<div id="titles">
	<a class="<?=$moderation_type=='malformed'?'selected':'';?>" href="?trash=<?=$trash;?>&mod_type=malformed">BD mal form&eacute;e</a><a class="<?=$moderation_type=='private'?'selected':'';?>" href="?trash=<?=$trash;?>&mod_type=private">Public restreint</a><a class="<?=$moderation_type=='pub'?'selected':'';?>" href="?trash=<?=$trash;?>&mod_type=pub">Pas de pub</a><a class="<?=$moderation_type=='ortho'?'selected':'';?>" href="?trash=<?=$trash;?>&mod_type=ortho">Orthographe</a><a class="<?=$moderation_type=='insulte'?'selected':'';?>" href="?trash=<?=$trash;?>&mod_type=insulte">Insultes, racisme</a><a class="<?=$moderation_type=='doublon'?'selected':'';?>" href="?trash=<?=$trash;?>&mod_type=doublon">D&eacute;j&agrave; vu</a>
</div>

<form method="POST" action="?trash=<?=$trash;?>&confirm=1">
	<textarea cols="100" rows="10" name="mail_content"><?=$body_msg;?></textarea>
	Vous recevrez vous aussi ce mail afin de garder une trace de vos mod&eacute;rations.

	<input type="submit" value="Mettre la BD dans la corbeille et envoyer le mail ci-dessus"></input>
</form>

<?php 
wp_reset_postdata();
?>