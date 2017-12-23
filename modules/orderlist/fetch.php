<?php 
    if(isset($_POST["id"]))  
	 {  
	 	$conn = new mysqli('localhost', 'root', '', 'qlsach');
	    mysqli_set_charset($conn,"utf8");

	    if (mysqli_connect_errno()) {
	      echo json_encode(array('conn' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
	      exit;
	    }

		$output = '';  
		$sql = "SELECT * FROM customer WHERE id='".$_POST["id"]."'";  
		$result = $conn->query($sql);  
		while($row = $result->fetch_assoc())  
		{  
			$output = '  
			    <p><label>Họ tên : '.$row['name'].'</label></p>  
			    <p><label>Địa chỉ : </label><br />'.$row['address'].'</p>  
			    <p><label>Giới tính : </label>'.$row['gender'].'</p>  
			    <p><label>Email : </label>'.$row['email'].'</p>  
			    <p><label>Số điện thoại : </label>'.$row['phone'].' Years</p>  
			';  
		}  
		echo $output;  
	 }  

?>