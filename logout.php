<?php
if(empty($_SESSION['uid']))
{
	header("location:index.php?op=login");
}
session_start();
session_unset();
session_unregister();
session_destroy();


header("location:index.php?op=login");

?>