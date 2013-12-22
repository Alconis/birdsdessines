<?php

$encodedPNGData = $_POST["encodedData"];

//Decode and save as a PNG file
if ($encodedPNGData != "") {
   $binaryData = base64_decode($encodedPNGData);
   $generatedFileName = "" . time() . ".png";
   file_put_contents($generatedFileName, $binaryData);
   //$result = "SUCCESS";
   $result = "http://www.birdsdessines.fr/bd/" . $generatedFileName;
} else {
   //Some Error Occured
   $result = "ERROR";
}

//Send Result to Flex
echo $result;

?>
