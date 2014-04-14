<?php

define('DB_HOST', 'mysql51-36.perso');
define('DB_NAME', 'alconisdad');
define('DB_USER', 'alconisdad');
define('DB_PASSWORD', '7jHbWDq9');

define('USER_COOKIE', 'hunt_user');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

function hunt_log($user, $action)
{
	$ip = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO `hunt_logs` (`ip`, `user`, `action`) VALUES ('" . mysql_real_escape_string(addslashes($ip)) . "', '" . mysql_real_escape_string(addslashes($user)) . "', '" . mysql_real_escape_string(addslashes($action)) . "');";
    $req = mysql_query($sql);
}

?>