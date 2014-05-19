<?php 

require('./wp-blog-header.php');

if( !is_user_logged_in() ){
	echo "Veuillez vous authentifier sur le site avant d'acc&eacute;der &agrave; cette page.";
	return;
}

$user = $_GET['user'];
if($user){
	$current_user = get_userdata($user);
}else{
	$current_user = wp_get_current_user();
}

$args = array(
	'author' => $current_user->ID,
	'nopaging' => true
	);
$posts = get_posts($args);

$zip = new ZipArchive();
$zipPath = "./zips/";
$zipName = "BDs_" . $current_user->user_login . ".zip";
if ($zip->open($zipPath . $zipName, ZipArchive::CREATE)!==TRUE) {
    exit("Impossible d'ouvrir le fichier <$filename>\n");
}

foreach( $posts as $post ) {
	$bd_url = get_post_meta( $post->ID, 'large-image', true );
	$bd_name = basename($bd_url);
	$bd_path = "./bd/" . $bd_name;
	$zip->addFile($bd_path);
}

$zip->close();

$file = $zipPath . $zipName;
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
	ob_end_flush();
    readfile($file);
    exit;
}else{
	echo $file . " does not exist.";
}
?>