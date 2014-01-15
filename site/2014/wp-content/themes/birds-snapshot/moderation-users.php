<div class="message">
	Cette page regroupe les outils pour gérer les utilisateurs du site.
</div>

<div id="useronline-count"><?php users_online(); ?></div>

<p>Rechercher dans les utilisateurs :</p>
<form method="GET" action="/moderation/">
	<input type="hidden" name="view" value="users"></input>
	<input type="text" name="search_query"></input>
	<input type="submit" value="Rechercher"></input>
</form>

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
?>

<div id="user">
	Fiche pour l'utilisateur <?=$user_id; ?>. Suite à venir...
</div>

<?php } ?>