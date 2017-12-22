<?php
    include_once('../../libs/pagination.php');
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
        $current_page = $_GET['page'] ?? 1;
        $start_from = ($current_page - 1)*$limit;
        $result = $conn->query("SELECT * FROM customer limit $start_from,$limit");
        
        $output = '';
        $output .= '<table class="table table-hover" id="tabledit" >
                    <thead>
                        <tr class="active">
                            <th>#</th>
                            <th>Tên khách hàng</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Giới tính</th>
                            <th>Địa chỉ</th>
                            <th><button type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapseAdd" aria-expanded="false" aria-controls="collapseAdd"><i class=" fa fa-plus-square"></i>  Thêm</button></th>
                        </tr>
                    </thead>
                    <tbody>';

        while ($row = $result->fetch_assoc()){
            $output .= '<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['address'].'</td>
                    <td>'.$row['gender'].'</td>
                    <td>'.$row['phone'].'</td>             
                </tr>';
        }

        $output .= '</tbody></table></div>';
        $result = $conn->query("SELECT id FROM customer");
        $total_record = $result->num_rows;
        
        $output .='<div><nav aria-label="Page navigation"><ul class="pagination">';          
        $output .= getAllPageLinks($total_record, $current_page, $limit);
        $output .= '</ul></nav>';  
        echo $output;
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


