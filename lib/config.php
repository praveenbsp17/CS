<?php
ob_start();
session_start();
include_once('Database.class.php');
$Database = new Database('localhost','root','','cinesodhi');
$Database->connect();

// Defining some Constants
//define('EMAIL_IMG_PATH', 'http://localhost/MLM/images/');
define('EMAIL_IMG_PATH', 'http://localhost/data/c3docs/images/');

// Defining server path
//define('SERVER_URL', 'http://localhost/MLM/');
define('SERVER_URL', 'http://localhost/data/c3docs/');

?>