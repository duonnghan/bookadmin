<?php
	include_once("../../libs/functions.php");

	$conn = new mysqli('localhost', 'root', '', 'qlsach');
    mysqli_set_charset($conn,"utf8");

    if (mysqli_connect_errno()) {
      echo json_encode(array('conn' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
      exit;
    }

	$perPage = new PerPage();

	$sql = "SELECT * from book";
	$paginationlink = "getresult.php?page=";	
	// $pagination_setting = $_GET["pagination_setting"];
					
	$page = 1;
	if(!empty($_GET["page"])) {
		$page = $_GET["page"];
	}

	$start = ($page-1)*$perPage->perpage;
	if($start < 0) $start = 0;

	$query =  $sql . " limit " . $start . "," . $perPage->perpage; 
	$result = $conn -> query($query);

	if(empty($_GET["rowcount"])) {
		$_GET["rowcount"] = $result->num_rows;
	}

	if($pagination_setting == "prev-next") {
		$perpageresult = $perPage->getPrevNext($_GET["rowcount"], $paginationlink,$pagination_setting);	
	} else {
		$perpageresult = $perPage->getAllPageLinks($_GET["rowcount"], $paginationlink,$pagination_setting);	
	}


	$output = '';
	foreach($faq as $k=>$v) {
		 $output .= '<div class="question"><input type="hidden" id="rowcount" name="rowcount" value="' . $_GET["rowcount"] . '" />' . $faq[$k]["question"] . '</div>';
		 $output .= '<div class="answer">' . $faq[$k]["answer"] . '</div>';
	}
	if(!empty($perpageresult)) {
		$output .= '<div id="pagination">' . $perpageresult . '</div>';
	}

	print $output;
?>
