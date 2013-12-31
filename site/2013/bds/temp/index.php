<?php

include('../../birds_header.php');

$directory = ".";
$tenDaysTime = time() - (10 * 24 * 60 * 60);

?>
				<div class="post">


<?php
	if ($_GET['pass'] == "alco"){
	
		?>
		
		<form method="POST" action="?action=delete" style="margin:10px">
			<input type="submit" value="Supprimer les BDs des 10 derniers jours"/>
		</form>		
		<?php
		
		// create a handler for the directory
		$handler = opendir($directory);

		$files = Array();
		
		// keep going until all files in directory have been read
		$i = 0;
		while ($file = readdir($handler)) {

			// if $file isn't this directory or its parent, 
			// add it to the results array
			if ($file != '.' && $file != '..' && $file != 'index.php' && $file != 'birds_upload.php'){
				//$fileTime = filemtime($file);
				$files[$i++] = $file;
			}
		}
				
		// tidy up: close the handler
		closedir($handler);
		
		if (!sort($files, SORT_STRING)){
			echo "Error: unable to sort array of files";
		}
		?>
		
		<em>Date limite: <? echo date("D j F Y G:i:s", $tenDaysTime); ?></em>
		<H1>Total de BDs dispos : <?php echo count($files); ?></H1>
		
		<?php
		foreach ($files as $file) {
			?>
				
				<div>
					<?php
						echo $file;
						if (strcmp($tenDaysTime + ".png", $file) > 0){
							echo " <font color='red'<strong>WILL BE DELETED!</strong></font>";
						}
					?>
					<br/>
					<!--img src="http://www.birdsdessines.fr/bd/temp/<?=$file;?>"-->
				<div>
			
			<?php
		}
	}else if ($_GET['action'] == "delete"){
		?>
		
		<H1>Deleting produced files older than 10 days (<?=$tenDaysTime?>)...</H1>
		
		<?php
		$handler = opendir($directory);
		$files = Array();
		$i = 0;
		while ($file = readdir($handler)) {
			if ($file != '.' && $file != '..' && $file != 'index.php' && $file != 'birds_upload.php'){
				$files[$i++] = $file;
			}
		}
		closedir($handler);
		
		if (!sort($files, SORT_STRING)){
			echo "Error: unable to sort array of files";
		}
		
		echo "<ul>";
		foreach ($files as $file) {
			echo "<li>deleting " . $file . "...";
			
			if (strcmp($tenDaysTime + ".png", $file) > 0){
				unlink($file);
			}else{
				echo "STOP! Not old enough!";
				break;
			}
			
			echo " Done!</li>";
		}
		echo "</ul>";
		?>
		
		<a href="?pass=alco">Back to listing</a>
		
		<?php
	}else{
		?>
		<h1>Listing disabled.</h1>

Go to <a href="http://www.birdsdessines.fr">http://www.birdsdessines.fr</a>, now !
<?php
	}
?>
				</div>
<?php include('../../birds_footer.php'); ?>