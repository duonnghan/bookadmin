<?php


    $conn = new mysqli('localhost', 'root', '', 'qlsach');
    mysqli_set_charset($conn,"utf8");

    if (mysqli_connect_errno()) {
      echo json_encode(array('conn' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
      exit;
    }

    $page = isset($_GET['p'])? $_GET['p'] : '';

    if ($page == 'add') {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $password = md5($password);

        $result = $conn->query("INSERT INTO admin(username, password) VALUES ('$username', '$password')");
        if ($result) {
            echo "Thêm tài khoản thành công";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($page == 'view') {
        $result = $conn->query("SELECT * FROM admin");
        while ($row = $result->fetch_assoc()){
            ?>
                <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['username'] ?></td>
                    <td><?php echo $row['password'] ?></td>
                    <td><?php echo $row['lastlogin'] ?></td>                
                </tr>
            <?php
        }
    }else{

        header('Content-Type: application/json');
        $input = filter_input_array(INPUT_POST);

        if ($input['action'] === 'edit') {
            $conn->query("UPDATE admin SET username='" . $input['user'] ."' WHERE id='".$input['id'] . "'");
        } else if ($input['action'] === 'delete') {
            $conn->query("DELETE FROM admin WHERE id='" . $input['id'] . "'");
        }

        $conn->close();
        echo json_encode($input);
    }

    
?>