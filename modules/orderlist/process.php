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

   if ($page == 'view') {
        $current_page = $_GET['page'] ?? 1;
        $start_from = ($current_page - 1)*$limit;
        $result = $conn->query("SELECT o.id, c.name, o.paidstat, o.shipstat, o.orderdate, o.shipdate
                                FROM orderbook AS o, customer AS c
                                WHERE o.userid = c.id 
                                LIMIT $start_from,$limit");
        $output = '';
        $output .= '<table class="table table-hover" id="tabledit" >
                    <thead>
                        <tr class="active">
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Ngày đặt hàng</th>
                            <th>Ngày giao hàng</th>
                            <th>Tình trạng thanh toán</th>
                            <th>Tình trạng giao hàng</th>
                            <th>Hành động</th>
                            
                        </tr>
                    </thead>
                    <tbody>';

        while ($row = $result->fetch_assoc()){
            $output .='<tr>
                    <td><a href="../orderdetail/">'.$row['id'].'</a></td>
                    <td><a href="../customer/">'.$row['name'].'</a></td>
                    <td>'.$row['orderdate'].'</td>
                    <td>'.$row['shipdate'].'</td><td>'; 

                    if($row['paidstat'] == '1')
                        $output .="Đã thanh toán";
                    else
                        $output .="Chưa thanh toán";

                    $output .='</td><td>';
                    if($row['shipstat'] == '1')
                        $output .="Đã giao hàng"; 
                    else
                        $output .="Chưa giao hàng";

                    $output .='</td></tr>';
        }

        $output .= '</tbody></table></div>';
        $result = $conn->query("SELECT id FROM orderbook");
        $total_record = $result->num_rows;
        
        $output .='<div><nav aria-label="Page navigation"><ul class="pagination">';          
        $output .= getAllPageLinks($total_record, $current_page, $limit);
        $output .= '</ul></nav>';
        echo $output;
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


