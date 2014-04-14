<?php
session_start();

Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
Header('Content-Type: application/json');

require( dirname( __FILE__ ) . '/db.php' );

$action = $_GET['do']; if(!$action) $action = 'list';
$user = $_GET['user']; if(!$user) $user = $_COOKIE[USER_COOKIE];
$egg = $_GET['egg'];
$pass = $_GET['pass'];
$code = $_GET['code'];
$newName = $_GET['newName'];

$status = 200;
$result;
switch ($action) {
	case 'logout':
		// Force user cookie to expire
		if(isset($_COOKIE[USER_COOKIE])) {
			setcookie(USER_COOKIE, "", time()-3600);
			unset($_COOKIE[USER_COOKIE]);
		}

		break;

	case 'add':
		// Conditions
		if(!$user) {
			$status = 404;
			$result = "Unknown user";
			break;
		}
		if(!$pass) {
			$status = 404;
			$result = "Unknown password";
			break;
		}

		// User alreay exists?
		$sql = "SELECT * FROM `hunt_users` WHERE `login` LIKE '" . mysql_real_escape_string(addslashes($user)) . "' ";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}
		if(0 != mysql_num_rows($req)) {
			$status = 403;
			$result = "Username " . $user . " already exists.";
			break;
		}

		// Insert new user in database
		$sql = "INSERT INTO `hunt_users` (`login`, `password`) VALUES ('" . mysql_real_escape_string(addslashes($user)) . "', '" . mysql_real_escape_string(addslashes($pass)) . "');";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}

		hunt_log($user, 'new subscription');
		// Automatically login by not breaking switch

	case 'login':
		// Conditions
		if(!$user) {
			$status = 404;
			$result = "Unknown user";
			break;
		}
		if(!$pass) {
			$status = 404;
			$result = "Unknown password";
			break;
		}

		// Retrieve user id from given name
		$sql = "SELECT * FROM `hunt_users` WHERE `login` LIKE '" . mysql_real_escape_string(addslashes($user)). "' AND `password` = '" . mysql_real_escape_string(addslashes($pass)) . "'";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}
		if(0 == mysql_num_rows($req)) {
			$status = 401;
			$result = "Unknown user: " . $user . " with password " . $pass;
			break;
		}
		$data = mysql_fetch_assoc($req);
		$user = $data['id'];

		// Set user cookies with 2 days expiration
		$in_2_days = time()+60*60*24*2;
		setcookie(USER_COOKIE, $user, $in_2_days);

		// Don't break as we return the card if logged in.

	case 'card':
		// Conditions
		if(!$user) {
			$status = 404;
			$result = "Unknown user";
			break;
		}

		// Retrieve user data
		$sql = "SELECT `id`, `login` FROM `hunt_users` WHERE `id` = '" . mysql_real_escape_string(addslashes($user)) . "'";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}
		if(0 == mysql_num_rows($req)) {
			$status = 401;
			$result = "Unknown user: " . $user . ".";
			break;
		}
		$user_data = mysql_fetch_assoc($req);

		// Retrieve found eggs
		$sql = "SELECT `egg`, `time` FROM `hunt_users_eggs` WHERE `user` = '" . mysql_real_escape_string(addslashes($user)) . "'";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}
		$found_eggs = array();
		while($data = mysql_fetch_assoc($req)){
			array_push($found_eggs, $data);
		}

		// Prepare final object
		$result = array(
			"id" => $user_data['id'],
			"login" => $user_data['login'],
			"eggs" => $found_eggs
		);

		break;
	case 'rename':
		// Conditions
		if(!$user) {
			$status = 404;
			$result = "Unknown user";
			break;
		}
		if(!$newName) {
			$status = 404;
			$result = "Unknown user";
			break;
		}
		$sql = "UPDATE `hunt_users` SET `login` = '" . mysql_real_escape_string(addslashes($newName)) . "' WHERE `hunt_users`.`id` = '" . mysql_real_escape_string(addslashes($user)) . "'";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}

		hunt_log($user, 'changes username to ' . $newName);
		break;

	case 'collect':

		// Conditions
		if(!$user) {
			$status = 404;
			$result = "Unknown user";
			break;
		}
		if(!$egg) {
			$status = 404;
			$result = "Unknown egg";
			break;
		}
		if(!$code) {
			$status = 404;
			$result = "Unknown code";
			break;
		}

		$sql = "SELECT * FROM `hunt_users` WHERE `id` = '" . mysql_real_escape_string(addslashes($user)) . "'";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}
		if(0 == mysql_num_rows($req)) {
			$status = 403;
			$result = "User " . $user . " does not exist.";
			break;
		}

		$sql = "SELECT * FROM `hunt_eggs` WHERE `id` = '" . mysql_real_escape_string(addslashes($egg)) . "'";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}
		if(0 == mysql_num_rows($req)) {
			$status = 403;
			$result = "Egg " . $egg . " does not exist.";
			break;
		}

		$sql = "SELECT * FROM `hunt_users_eggs` WHERE `user` = '" . mysql_real_escape_string(addslashes($user)) . "' AND `egg` = '" . mysql_real_escape_string(addslashes($egg)) . "' ";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}
		if(0 != mysql_num_rows($req)) {
			$status = 409;
			$result = "User " . $user . " has already collected egg " . $egg . ".";
			break;
		}

		$sql = "SELECT * FROM `hunt_eggs` WHERE `id` = '" . mysql_real_escape_string(addslashes($egg)) . "' AND `code` = '" . mysql_real_escape_string(addslashes($code)) . "'";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}
		if(0 == mysql_num_rows($req)) {
			$status = 403;
			$result = "Code '" . $code . "' is not the good one for egg " . $egg . ".";

			hunt_log($user, 'tries to collect egg ' . $egg . ' with code ' . $code);
			break;
		}

		$sql = "INSERT INTO `hunt_users_eggs` (`user`, `egg`) VALUES ('" . mysql_real_escape_string(addslashes($user)) . "', '" . mysql_real_escape_string(addslashes($egg)) . "');";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}

		hunt_log($user, 'collects egg ' . $egg);

		break;

	default:
		// Retrieve all users
		$sql = "select u.id as id, u.login as user, e.egg, e.time "
			    . "from hunt_users u "
			    . "left join hunt_users_eggs e "
			    . "on u.id = e.user";
		$req = mysql_query($sql);
		if(false == $req) {
			$status = 500;
			$result = " SQL Error: " . $sql . '<br>' . mysql_error();
			break;
		}
	 
		$result = array();
		while($data = mysql_fetch_assoc($req)){
			array_push($result, $data);
		}

		break;
}

mysql_close();
header(" ", true, $status);
if(null != $result) {
	echo json_encode($result);
}
?>