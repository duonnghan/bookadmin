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
        $publisher      = $_POST['publisher'];
        $image = addslashes(file_get_contents($_FILES["cover"]["tmp_name"]));

        $result = $conn->query("INSERT INTO book(bookname, price, description, cover, quantity, categoryid, publisherid, authorid) VALUES ('$name', '$price', '$description', '$image','$quantity', '$category', '$publisher','$author')");
        if ($result) {   
            echo "Thêm sản phẩm thành công";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($page == 'view') {
        $result = $conn->query("SELECT b.id, b.bookname, b.price, b.description, b.cover, b.updated, b.quantity, a.authorname, p.publishername, c.categoryname
                                FROM book AS b, author AS a, publisher as p, category AS c
                                WHERE b.categoryid = c.id AND b.publisherid = p.id AND b.authorid = a.id");
        while ($row = $result->fetch_assoc()){
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['bookname']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['authorname']; ?></td>
                    <td><?php echo $row['categoryname']; ?></td>
                    <td><?php echo $row['publishername']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><img src="data:image/jpeg;base64,'.base64_encode($row['cover'] ).'" height="30" width="30" class="img-thumbnail" />td>
                    <td><?php echo $row['updated']; ?></td>                
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