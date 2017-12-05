<?php
    
    $conn = new mysqli('localhost', 'root', '', 'qlsach');
    mysqli_set_charset($conn,"utf8");

    if (mysqli_connect_errno()) {
      echo json_encode(array('conn' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
      exit;
    }

    $page = isset($_GET['p'])? $_GET['p'] : '';

    if ($page == 'add') {
        $name           = $_POST['name'];
        $price          = $_POST['price'];
        $author         = $_POST['author'];
        $quantity       = $_POST['quantity'];
        $category       = $_POST['category'];
        $description    = $_POST['description'];
        $cover          = $_POST['cover'];

        //mở file ảnh để đọc với chế độ đọc binary
        $f = fopen($cover, "rb");
        $imgContents = fread($f, filesize($imgFilename));
        fclose($f);

        //chèn nội dung file ảnh vào table imgConetnts
        $conn->query("INSERT INTO products (cover) VALUES('" . mysql_real_escape_string($imgContents, $conn) . "')");

        $result = $conn->query("INSERT INTO book(bookname, price, description, cover, quantity, categoryid, publisherid, authorid) VALUES ('$username', '$password')");
        if ($result) {   
            echo "Thêm sản phẩm thành công";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($page == 'view') {
        $result = $conn->query("SELECT * FROM book");
        while ($row = $result->fetch_assoc()){
            ?>
                <tr>
                    <td><?php echo $book['id']; ?></td>
                    <td><?php echo $admin['bookname']; ?></td>
                    <td><?php echo $admin['price']; ?></td>
                    <td><?php echo $admin['authorname']; ?></td>
                    <td><?php echo $admin['categoryname']; ?></td>
                    <td><?php echo $admin['publishername']; ?></td>
                    <td><?php echo $admin['quantity']; ?></td>
                    <td><?php echo $admin['description']; ?></td>
                    <td><?php echo $admin['cover']; ?>td>
                    <td><?php echo $admin['updated']; ?></td>                
                </tr>
            <?php
        }
    }else{

        header('Content-Type: application/json');
        $input = filter_input_array(INPUT_POST);

        if ($input['action'] === 'edit') {
            $conn->query("UPDATE products SET bookname='" . $input['name'] .", price = '".$input['price']."', authorname='".index['author'].", description ='".$input['description']. "WHERE id='".$input['id'] . "'");
        } else if ($input['action'] === 'delete') {
            $conn->query("DELETE FROM admin WHERE id='" . $input['id'] . "'");
        }

        $conn->close();
        echo json_encode($input);
    }

    
?>