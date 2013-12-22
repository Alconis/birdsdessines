<?php

// Retrieve parameters from request
$data	 = $_POST['encodedData'];
$to      = $_POST['mailAddress'];
$from    = ($_POST['fromMailAddress'] == "" || $_POST['fromMailAddress'] == null) ? "webmaster@birdsdessines.fr" : $_POST['fromMailAddress'];
$subject = "[BirdsDessines.fr] Votre BirdsDessines !";
$message = "Votre BirdsDessines est en piece jointe. A bientot sur BirdsDessines.fr";

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
     "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
     "Content-Transfer-Encoding: 7bit\n\n" .
     $message . "\n\n";

// Base64 encode the file data
$data = chunk_split($data);

// Add file attachment to the message
$message .= "--{$mime_boundary}\n" .
      "Content-Type: image/png;\n" .
      " name=\"birdsdessines_perso.png\"\n" .
      "Content-Disposition: attachment;\n" .
      " filename=\"birdsdessines_perso.png\"\n" .
      "Content-Transfer-Encoding: base64\n\n" .
      $data . "\n\n" .
      "--{$mime_boundary}--\n";

// Send the message
$ok = @mail($to, $subject, $message, $headers);
if ($ok) {
  echo "OK";
} else {
  echo "ERROR";
}
?>