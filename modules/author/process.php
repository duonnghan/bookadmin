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
        $address = $_POST['address'];
        $bio = $_POST['bio'];

        $result = $conn->query("INSERT INTO author(authorname, address, bio) VALUES ('$name', '$address', '$bio')");
        if ($result) {
            echo "Thêm tác giả thành công";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($page == 'view') {
        $result = $conn->query("SELECT * FROM author");
        while ($row = $result->fetch_assoc()){
            ?>
                <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['authorname'] ?></td>
                    <td><?php echo $row['address'] ?></td>
                    <td><?php echo $row['bio'] ?></td>                
                </tr>
            <?php
        }
    }else{

        header('Content-Type: application/json');
        $input = filter_input_array(INPUT_POST);

        if ($input['action'] === 'edit') {
            $conn->query("UPDATE author SET authorname='" . $input['name'] . "', address='" . $input['address'] . "', bio='" . $input['bio'] . "' WHERE id='" . $input['id'] . "'");
        } else if ($input['action'] === 'delete') {
            $conn->query("DELETE FROM author WHERE id='" . $input['id'] . "'");
        }

        $conn->close();
        echo json_encode($input);
    }
?>


