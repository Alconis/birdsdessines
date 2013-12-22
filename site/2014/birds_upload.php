<?php

$encodedPNGData = $_POST["encodedData"];

if ($encodedPNGData != "") {

	$binaryData = base64_decode($encodedPNGData);

	$path = "bds";

	// Year dir
	$path = $path . "/" . date("Y");
	if(!file_exists( $path )) {
		mkdir( $path, 0777, true );
	}

	// Month dir
	$path = $path . "/" . date("m");
	if(!file_exists( $path )) {
		mkdir( $path, 0777, true );
	}

	// Day dir
	$path = $path . "/" . date("d");
	if(!file_exists( $path )) {
		mkdir( $path, 0777, true );
	}

	$generatedFileName = $path . "/" . time() . ".png";
	file_put_contents($generatedFileName, $binaryData);
	$result = "http://www.birdsdessines.fr/" . $generatedFileName;

} else {

   $result = "ERROR";

}

echo $result;
?>

