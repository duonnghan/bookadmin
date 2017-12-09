<?php 

	$conn = new mysqli('localhost', 'root', '', 'qlsach');
    mysqli_set_charset($conn,"utf8");

    if (isset($_POST['book_id'])) {
    	$output = array();

    	$result = $conn -> query("SELECT * FROM book WHERE id = '$_POST['book_id']'  LIMIT 1");
        if ($result) {
            $row = $result -> fetch_assoc();

            $output['name'] = $row['bookname'];
            $output['price'] = $row['price'];
            $output['quantity'] = $row['quantity'];
            $output['authorid'] = $row['authorid'];
            $output['publisherid'] = $row['publisherid'];
            $output['categoryid'] = $row['categoryid'];
            $output['description'] = $row['description'];

            if ($row['cover'] != '') {
            	$output['cover'] = '<img src="data:image/jpeg;base64,'.base64_encode($row['cover'] ).'" height="60" width="75" class="img-thumbnail" />';
            	

            }
        }


    }
	

 ?>