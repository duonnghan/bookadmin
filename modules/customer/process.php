<?php
    
    $conn = new mysqli('localhost', 'root', '', 'qlsach');
    mysqli_set_charset($conn,"utf8");

    if (mysqli_connect_errno()) {
      echo json_encode(array('conn' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
      exit;
    }

    //Lay du lieu
    $page = $_GET['p'] ?? '';

    if ($page == 'add') {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];

        $result = $conn->query("INSERT INTO customer(email, address, name, gender, phone) VALUES ('$email', '$address','$name', '$gender', '$phone')");

        if ($result) {
            echo "Thêm danh mục thành công";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($page == 'view') {
        // $id = $_GET['id'] ?? '';
        // if (!empty($id)) {
        //     $result = $conn->query("SELECT * FROM customer WHERE id='$id'");
        // }else
            $result = $conn->query("SELECT * FROM customer");
        
        while ($row = $result->fetch_assoc()){
            ?>
                <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['address'] ?></td>
                    <td><?php echo $row['gender'] ?></td>
                    <td><?php echo $row['phone'] ?></td>             
                </tr>
            <?php
        }
    }else{

        header('Content-Type: application/json');
        $input = filter_input_array(INPUT_POST);

        if ($input['action'] === 'edit') {
            $conn->query("UPDATE customer SET name='" . $input['name']."',email='" . $input['email']."',address='" . $input['address']."',gender='" . $input['gender']."',phone='" . $input['phone']. "' WHERE id='" . $input['id'] . "'");
        } else if ($input['action'] === 'delete') {
            $conn->query("DELETE FROM customer WHERE id='" . $input['id'] . "'");
        }

        $conn->close();
        echo json_encode($input);
    }
?>


