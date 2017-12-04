<?php
/********************************* 
 Xóa session login
**********************************/

    if (isset($_SESSION['admin_id'])) {
		unset($_SESSION['admin_id']);
		session_unregister('admin_id');
	}

	header("Local: ./login.php");

?>