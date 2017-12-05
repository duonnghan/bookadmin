<?php

session_start();
define("IN_SITE", true);
include_once ('../../libs/functions.php');

checkUser();
/********************************* 
 Xóa session login
**********************************/
	
    if (isset($_SESSION['admin_id'])) {
		unset($_SESSION['admin_id']);
		session_destroy();
	}

	redirect("login.php");

?>