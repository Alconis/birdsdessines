<?php
require( dirname( __FILE__ ) . '/config.php' );

$db = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME,$db);

?>