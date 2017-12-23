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

    if ($page == 'fetch_order') {

        if (isset($_POST['order_id'])) {
            $output = array();

            $result = $conn -> query("SELECT * FROM orderbook WHERE id = '".$_POST['order_id']."' LIMIT 1");
            if ($result) {
                $row = $result -> fetch_assoc();

                $output['id'] = $_POST['order_id'];
                $output['userid'] = $row['userid'];
                $output['paidstat'] = $row['paidstat'];
                $output['amount'] = $row['amount'];

                //Lay thong tin cua khach hang
                $result = $conn -> query("SELECT * FROM customer WHERE id = '".$output['userid']."'");
                if ($result) {
                   $row = $result -> fetch_assoc();
                   $output['c_name'] = $row['name'];
                   $output['c_email'] = $row['email'];
                   $output['c_address'] = $row['address'];
                   $output['c_phone'] = $row['phone'];
                   $output['c_gender'] = $row['gender'];
                }

                //Lay thong tin cac san pham ma khach hang da mua
                $result = $conn -> query("SELECT b.bookname, b.price, od.quantity
                                            FROM `orderdetail` AS od, `book` AS b
                                            WHERE od.bookid = b.id AND od.orderid = '".$output['id']."'");
                if ($result) {
                    $output['od_detail'] = '';
                    while($row = $result -> fetch_assoc()){
                        $output['od_detail'] .='<tr><td>'.$row['bookname'].'</td>
                                                    <td>'.$row['price'].'</td>
                                                    <td>'.$row['quantity'].'</td>
                                                    <td>'.($row['price'] * $row['quantity']).'</td>
                                                </tr>';
                    }
                }

            }

            echo json_encode($output);
        }
    }

   if ($page == 'view') {
        $current_page = $_GET['page'] ?? 1;
        $start_from = ($current_page - 1)*$limit;
        $result = $conn->query("SELECT o.id, c.name, o.amount, o.paidstat, o.shipstat, o.orderdate, o.shipdate
                                FROM orderbook AS o, customer AS c
                                WHERE o.userid = c.id 
                                LIMIT $start_from,$limit");
        $output = '';
        $output .= '<table class="table table-hover" id="tabledit" >
                    <thead>
                        <tr class="active">
                            <th>#</th>
                            <th>Tên khách hàng</th>
                            <th>Giá trị </th>
                            <th>Ngày đặt hàng</th>
                            <th>Ngày giao hàng</th>
                            <th>Tình trạng thanh toán</th>
                            <th>Tình trạng giao hàng</th>
                            <th>Chi tiết</th>
                            <th>Hành động</th>
                            
                        </tr>
                    </thead>
                    <tbody>';

        while ($row = $result->fetch_assoc()){
            $output .='<tr>
                    <td id="'.$row['id'].'">'.$row['id'].'</td>
                    <td>'.$row['name'].'</a></td>
                    <td>$ '.$row['amount'].'</td>
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

                    $output .='</td><td><button type="button" name="view" class="btn btn-primary bt-xs view" id="'.$row["id"].'"><span class="fa fa-search"></span> Xem</button></td></tr>';
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


