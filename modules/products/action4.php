<?php 

	$connect = mysqli_connect("localhost", "root", "", "qlsach");

		$name           = $_POST['name'];
        $price          = $_POST['price'];
        $author         = $_POST['author'];
		$file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
		$query = "INSERT INTO book(bookname, price, cover) VALUES ('$name', '$price',  '$file')";
		if(mysqli_query($connect, $query))
		{
			echo 'Image Inserted into Database';
		}
 ?>