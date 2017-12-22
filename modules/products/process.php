<?php
    include_once('../../libs/pagination.php');
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
        $description    = addslashes($_POST['description']);
        $publisher      = $_POST['publisher'];
        $image = addslashes(file_get_contents($_FILES["cover"]["tmp_name"]));

        $result = $conn->query("INSERT INTO book(bookname, price, description, cover, quantity, categoryid, publisherid, authorid) VALUES ('$name', '$price', '$description', '$image','$quantity', '$category', '$publisher','$author')");
        if ($result) {   
            echo "Thêm sản phẩm thành công";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($page == 'view') {
        $limit = 4;
        $current_page = $_POST['page'] ?? 1;
        $start_from = ($current_page - 1)*$limit;

        $sql = "SELECT b.id, b.bookname, b.price, b.description, b.cover, b.updated, b.quantity, a.authorname, p.publishername, c.categoryname
                                FROM book AS b, author AS a, publisher as p, category AS c
                                WHERE b.categoryid = c.id AND b.publisherid = p.id AND b.authorid = a.id 
                                LIMIT $start_from,$limit"; 

        $result = $conn->query($sql);
        $output = '';
        $output .= '<table class="table table-hover" id="tabledit" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tựa sách</th>
                            <th>Giá</th>
                            <th>Tác giả</th>
                            <th>Danh mục</th>
                            <th>Nhà xuất bản</th>
                            <th>Số lượng</th>
                            <th>Mô tả</th>
                            <th class="col-md-2">Ảnh bìa</th>
                            <th>Lần cuối cập nhật</th>
                            <th><button type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapseInsert" aria-expanded="false" aria-controls="collapseInsert"><i class=" fa fa-plus-square"></i>  Thêm</button></th>
                        </tr>
                    </thead>
                    <tbody>';

        while($row = mysqli_fetch_array($result))
        {
            $output .= '

            <tr>
            <td>'.$row["id"].'</td>
            <td>'.$row["bookname"].'</td>
            <td>'.$row["price"].'</td>
            <td>'.$row["authorname"].'</td>
            <td>'.$row["categoryname"].'</td>
            <td>'.$row["publishername"].'</td>
            <td>'.$row["quantity"].'</td>
            <td>'.$row["description"].'</td>
            <td>
            <img src="data:image/jpeg;base64,'.base64_encode($row['cover'] ).'" height="60" width="75" class="img-thumbnail" />
            </td>
            <td>'.$row["updated"].'</td>
            <td><button type="button" name="update" class="btn btn-warning bt-xs update" id="'.$row["id"].'"><span class="glyphicon glyphicon-pencil"></span> Sửa</button></td>
            <td><button type="button" name="delete" class="btn btn-danger bt-xs delete" id="'.$row["id"].'"><span class="glyphicon glyphicon-trash"></span> Xóa</button></td>
            </tr>
            ';
        }

        $output .= '</tbody></table></div>';
        $result = $conn->query("SELECT id FROM book");
        $total_record = $result->num_rows;
        
        $output .='<div><nav aria-label="Page navigation"><ul class="pagination">';          
        $output .= getAllPageLinks($total_record, $current_page, $limit);
        $output .= '</ul></nav>';

        echo $output;
    }

    if ($page == 'fetch_book') {

        if (isset($_POST['book_id'])) {
            $output = array();

            $result = $conn -> query("SELECT * FROM book WHERE id = '".$_POST['book_id']."' LIMIT 1");
            if ($result) {
                $row = $result -> fetch_assoc();

                $output['id'] = $_POST['book_id'];
                $output['name'] = $row['bookname'];
                $output['price'] = $row['price'];
                $output['quantity'] = $row['quantity'];
                $output['authorid'] = $row['authorid'];
                $output['publisherid'] = $row['publisherid'];
                $output['categoryid'] = $row['categoryid'];
                $output['description'] = $row['description'];

                if ($row['cover'] != '') {
                    $output['cover'] = '<img src="data:image/jpeg;base64,'.base64_encode($row['cover'] ).'" height="60" width="75" class="img-thumbnail" />';
                }else{
                   $output['cover'] = '<input type="hidden" name="hidden_book_image" value="" />';
                }


            }
            echo json_encode($output);
        }
    }
    
    if ($page == 'delete') {
        
        $sql = "DELETE FROM book WHERE id = '".$_POST["book_id"]."'";
        if($conn->query($sql))
        {
            echo 'Đã xóa thành công';
        }
    }

    if ($page == 'update') {

        $id             = $_POST['modal_id'];
        $name           = $_POST['modal_name'];
        $price          = $_POST['modal_price'];
        $author         = $_POST['modal_author'];
        $quantity       = $_POST['modal_quantity'];
        $category       = $_POST['modal_category'];
        $description    = $_POST['modal_description'];
        $publisher      = $_POST['modal_publisher'];
       

        if ($_POST['modal_cover'] != '') {
            $image = addslashes(file_get_contents($_FILES["modal_cover"]["tmp_name"]));
            $result = $conn->query("UPDATE book SET cover='$image' WHERE id='$id' ");
        }

        $sql = "UPDATE book SET bookname = '$name', price ='$price',description='$description', quantity='$quantity', categoryid='$category', publisherid='$publisher', authorid='$author'  WHERE id = '$id'";
        
        $result = $conn->query($sql);
        if ($result) {   
            echo "Cập nhật sản phẩm thành công";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($page == 'pagination') {
        $perPage = new PerPage();

    }


?>