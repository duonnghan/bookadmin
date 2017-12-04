<?php
    
    $conn = new mysqli('localhost', 'root', '', 'qlsach');
    mysqli_set_charset($conn,"utf8");

    if (mysqli_connect_errno()) {
      echo json_encode(array('conn' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
      exit;
    }

    //Lay du lieu
    $page = $_GET['p'] ?? '';

   if ($page == 'view') {
        $result = $conn->query("SELECT o.id, c.name, o.paidstat, o.shipstat, o.orderdate, o.shipdate
                                FROM orderbook AS o, customer AS c
                                WHERE o.userid = c.id");
        while ($row = $result->fetch_assoc()){
            ?>
                <tr>
                    <td><a href="../orderdetail/"><?php echo $row['id'] ?></a></td>
                    <td><a href="../customer/"><?php echo $row['name'] ?></a></td>
                    <td><?php echo $row['orderdate'] ?></td>
                    <td><?php echo $row['shipdate'] ?></td>   
                    <td><?php if($row['paidstat'] == '1') echo "Đã thanh toán"; else echo "Chưa thanh toán" ?></td>
                    <td><?php if($row['shipstat'] == '1') echo "Đã giao hàng"; else echo "Chưa giao hàng" ?></td>
                </tr>
            <?php
        }
    }else{

        header('Content-Type: application/json');
        $input = filter_input_array(INPUT_POST);

        if ($input['action'] === 'edit') {
            $conn->query("UPDATE orderbook SET orderdate='" . $input['orderdate']."',shipdate='" . $input['shipdate']."',paidstat='" . $input['paidstat']."',shipstat='" . $input['shipstat']. "' WHERE id='" . $input['id'] . "'");
        } else if ($input['action'] === 'delete') {
            $conn->query("DELETE FROM orderbook WHERE id='" . $input['id'] . "'");
        }

        $conn->close();
        echo json_encode($input);
    }
?>


