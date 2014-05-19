<?php
$user_id = $_GET["id"];
$search_query= $_GET["search_query"];

if($search_query){
	$all_users = get_users('blog_id=0&orderby=nicename&role=subscriber&search=*' . $search_query. '*');

	$nb_match = count($all_users);
	if($nb_match == 0){
		echo '<i>Aucun r&&eacute;sultats pour "' . $search_query. '.</i>';
	}else if($nb_match > 1){
		echo '<strong>R&eacute;sultats pour "' . $search_query. '":</strong><ul>';
		foreach ($all_users as $user) {
			$user_nicename = str_replace($search_query, '<b>'.$search_query.'</b>', $user->user_nicename);
			echo '<li><a href="/moderation/?view=users&id=' . $user->ID . '">' . $user_nicename . '</a></li>';
		}
		echo "</ul>";
	}else{
		foreach ($all_users as $user) {
			$user_id = $user->ID;
		}
	}
}

if($user_id){
	$user = get_userdata( $user_id );

?>

<div id="user">

<?php
	if($user){
?>
	<h2>Fiche pour l'utilisateur <?=$user->user_nicename; ?></h2>

<ul>
	<li>Inscrit depuis <?= human_time_diff( strtotime($user->user_registered), current_time('timestamp') ); ?></li>
	<li>Description: <?= $user->description; ?></li>
	<li>Nombre de BDs publiées: <?= count_user_posts( $user->ID ); ?></li>
<?php
$args = array(
	'user_id' => $user->ID, 
        'count' => true
);
$comments_count = get_comments($args);
?>
	<li>Nombre de commentaires publiées: <?= $comments_count; ?></li>
</ul>

<?php
	}else{
?>

	<h2>Aucun utilisateur pour '<?=$user_id; ?>'</h2>

<?php
	}
?>
</div>
<?php

} else {

?>
	<div class="message">
		Cette page regroupe les outils pour gérer les utilisateurs du site.
	</div>

	<h2>Rechercher dans les utilisateurs</h2>
	<form method="GET" action="/moderation/">
		<input type="hidden" name="view" value="users"></input>
		<input type="text" name="search_query" value="<?=$search_query?>"></input>
		<input type="submit" value="Rechercher"></input>
	</form>

<?php
	echo '<h2>Les 50 derniers inscrits sur le site</h2>';
	$new_users = get_users('blog_id=0&number=50&orderby=registered&order=DESC&fields=all_with_meta');
	$nb_match = count($all_users);
	$usersIds = array();
	foreach ($new_users as $user) {
		array_push($usersIds, $user->ID);
	}
	$usersPostCounts = count_many_users_posts( $usersIds, 'post' );
	echo '<div id="list">';
	foreach ($new_users as $user) {
		echo '<div>';
		echo '<div class="mod_title"><a href="/moderation/?view=users&id=' . $user->ID . '">' . $user->display_name. '</a></div>';
		echo '<div class="mod_time">' . human_time_diff( strtotime($user->user_registered), current_time('timestamp') ) . '</div>';
		$userPostCount = $usersPostCounts[ $user->ID ];
		if($userPostCount == 0){
			echo '<div class="mod_time">0 BD publi&eacute;e</div>';
		}else{
			echo '<div class="mod_time"><a href="' . get_author_posts_url( $user->ID ) . '">' . $userPostCount . ' BDs publi&eacute;es. </a></div>';
		}
		echo '</div>';
	}
	echo '</div>';
}
?>