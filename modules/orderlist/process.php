<?php
    include_once('../../libs/pagination.php');
    $conn = new mysqli('localhost', 'root', '', 'qlsach');
    mysqli_set_charset($conn,"utf8");

    if (mysqli_connect_errno()) {
      echo json_encode(array('conn' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
      exit;
    }

   
    $page = $_GET['p'] ?? '';

    //Lay thong tin don hang
    if ($page == 'fetch_order') {
        $output = '';

        if (isset($_POST['order_id'])) {
            
            $result = $conn -> query("SELECT * FROM orderbook WHERE id = '".$_POST['order_id']."' LIMIT 1");

            if ($result) {

                $row = $result -> fetch_assoc();
                $id = $_POST['order_id'];
                $userid = $row['userid'];
                $amount = $row['amount'];

                //Lay thong tin cua khach hang
                $result = $conn -> query("SELECT * FROM customer WHERE id = $id");
                if ($result) {
                    $row = $result -> fetch_assoc();
                   $output .='<div class="col-md-6">
                                <strong>Họ tên: </strong>
                                <span id="modal_name">'.$row['name'].'</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Giới tính: </strong>
                                <span id="modal_gender">'.$row['gender'].'</span>
                            </div>
                            <br><br>
                            <div class="col-md-12">
                                <strong>Địa chỉ: </strong>
                                <span id="modal_address">'.$row['address'].'</span>
                            </div>
                            <br><br>
                            <div class="col-md-12">
                                <strong>Email: </strong>
                                <span id="modal_email">'.$row['email'].'</span>
                            </div>
                            <br><br>
                            <div class="col-md-12">
                                <strong>Số điện thoại: </strong>
                                <span id="modal_phone">'.$row['phone'].'</span>
                            </div>';
                    
                }
                
                $output .= '<div class="col-md-12">
                            <h3 class="text-center"><strong>Thông tin các sản phẩm</strong></h3>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Tên sách</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="modal_order_detail">';

                //Lay thong tin cac san pham ma khach hang da mua
                $result = $conn -> query("SELECT b.bookname, b.price, od.quantity
                                            FROM `orderdetail` AS od, `book` AS b
                                            WHERE od.bookid = b.id AND od.orderid = $id");
                if ($result) {
                    while($row = $result -> fetch_assoc()){
                        $output .='<tr><td>'.$row['bookname'].'</td>
                                                    <td>'.$row['price'].'</td>
                                                    <td>'.$row['quantity'].'</td>
                                                    <td class="text-right"> $'.($row['price'] * $row['quantity']).'</td>
                                                </tr>';
                    }
                }

                $output .='</tbody>
                            </table></div><br><br>
                            <div class="text-right col-md-12"><strong>Tổng: </strong>$ '.$amount.'<span id="modal_amount"></span></div>
                            <br><br>';
            }
        }

        echo $output;
    }
    else{
        //Xem danh sach cac hoa don
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
                                <th>Giá trị ($) </th>
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
                        <td>'.$row['amount'].'</td>
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
                $conn->query("UPDATE orderbook SET orderdate='" . $input['orderdate']."',shipdate='" . $input['shipdate']."', amount='" . $input['amount']."',paidstat='" . $input['paidstat']."',shipstat='" . $input['shipstat']. "' WHERE id='" . $input['id'] . "'");
            } else if ($input['action'] === 'delete') {
                //Xoa chi tiet hoa don
                $conn->query("DELETE FROM orderdetail WHERE orderid='" . $input['id'] . "'");
                //Xoa khach hang neu chi con 1 don hang nay
                $result = $conn->query("SELECT userid FROM orderbook WHERE id ='".$input['id']."'");
                if ($result->num_rows <= 1) {
                    $row = $result->fetch_assoc();
                    $conn->query("DELETE FROM customer WHERE id='" . $row['userid'] . "'");
                }
                //Xoa hoa don
                $conn->query("DELETE FROM orderbook WHERE id='" . $input['id'] . "'");
                
            }

            $conn->close();
            echo json_encode($input);
        }
    }
   
?>


