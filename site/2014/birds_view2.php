<?php

$id = $_GET['bd'];

?>

<?php include('birds_header.php'); ?>
				<div class="post">
<h1>Voici votre BirdsDessines !</h1>

<img src="http://www.birdsdessines.fr/bds/temp/<?php echo $id; ?>">

<p>Pour enregistrer l'image sur votre ordinateur, faites un clic droit avec votre souris sur l'image et choisissez "Enregistrez l'image [sous]..."</p>

<h1>Attention !</h1>

<p>Votre BD ne sera gard&eacute;e que 10 jours sur nos serveurs. Aussi, n'int&eacute;grez pas l'image dans votre site directement &agrave; partir de notre serveur. Utilisez les services d'h&eacute;bergement d'image en ligne qui sont id&eacute;als pour cela (imageshack.us, photobucket.com, imagik.fr, etc.)

				</div>
<?php include('birds_footer.php'); ?>