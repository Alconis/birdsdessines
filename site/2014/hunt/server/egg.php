<?php
session_start();

Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
Header('Content-Type: application/json');

require( dirname( __FILE__ ) . '/db.php' );

$action = $_GET['do'] || 'list';

$result;
switch ($action) {
	default:

		$sql = 'SELECT * FROM hunt_eggs WHERE 1';

		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	 
		$result = array();
		while($data = mysql_fetch_assoc($req)){
			array_push($result, $data);
		}

		break;
}

mysql_close();
 
echo json_encode($result);
?>