<?php
    include_once('../../libs/pagination.php');

    $conn = new mysqli('localhost', 'root', '', 'qlsach');
    mysqli_set_charset($conn,"utf8");

    if (mysqli_connect_errno()) {
      echo json_encode(array('conn' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
      exit;
    }

    //SHA-256
    $salt = '$5$rounds=5000$LTWEB20171-ibookonline-A$';

    $page = isset($_GET['p'])? $_GET['p'] : '';

    if ($page == 'add') {
        $username = $_POST['user'];
        $password = $_POST['pass'];

        // $password = md5($password);
        $password = crypt($password, $salt);
        $result = $conn->query("INSERT INTO admin(username, password) VALUES ('$username', '$password')");
        if ($result) {
            echo "Thêm tài khoản thành công: $password";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($page == 'view') {
        $current_page = $_GET['page'] ?? 1;
        $start_from = ($current_page - 1)*$limit;
        $result = $conn->query("SELECT * FROM admin limit $start_from,$limit");

        $output = '';
        $output .='<table class="table table-hover" id="tabledit" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tài khoản</th>
                                <th>Lân cuối đăng nhập</th>
                                <th>Hành động</th>
                                <th><button type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapseInsert" aria-expanded="false" aria-controls="collapseInsert"><i class=" fa fa-plus-square"></i>  Thêm</button></th>
                            </tr>
                        </thead>
                        <tbody>';

        while ($row = $result->fetch_assoc()){
            $output .= '<tr>
                    <td>'. $row['id'].'</td>
                    <td>'. $row['username'].'</td>
                    <td>'. $row['lastlogin'].'</td>              
                </tr>';
        }

        $output .= '</tbody></table></div>';

        $result = $conn->query("SELECT id FROM admin");
        $total_record = $result->num_rows;
        
        $output .='<div><nav aria-label="Page navigation"><ul class="pagination">';          
        $output .= getAllPageLinks($total_record, $current_page, $limit);
        $output .= '</ul></nav>';  
        echo $output;
    }else{ //Update and delete admin

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