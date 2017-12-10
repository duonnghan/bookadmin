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
        $bio = addslashes($_POST['bio']);
        $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));

        $result = $conn->query("INSERT INTO author(authorname, address, bio, avatar) VALUES ('$name', '$address', '$bio','$image')");
        if ($result) {
            echo "Thêm tác giả thành công";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }


    if ($page == 'view') {

        $result = $conn->query("SELECT * FROM author");
        $output = '';

        while ($row = $result->fetch_assoc()){
            $output .= '

            <tr>
            <td>'.$row["id"].'</td>
            <td>'.$row["authorname"].'</td>
            <td>'.$row["address"].'</td>
            <td>'.$row["bio"].'</td>
            <td>
            <img src="data:image/jpeg;base64,'.base64_encode($row['avatar'] ).'" height="60" width="75" class="img-thumbnail" />
            </td>
            <td><button type="button" name="update" class="btn btn-warning bt-xs update" id="'.$row["id"].'"><span class="glyphicon glyphicon-pencil"></span> Sửa</button></td>
            <td><button type="button" name="delete" class="btn btn-danger bt-xs delete" id="'.$row["id"].'"><span class="glyphicon glyphicon-trash"></span> Xóa</button></td>
            </tr>
            ';
        }
    }

    if ($page == 'fetch_author') {

        if (isset($_POST['author_id'])) {
            $output = array();

            $result = $conn -> query("SELECT * FROM author WHERE id = '".$_POST['author_id']."' LIMIT 1");
            if ($result) {
                $row = $result -> fetch_assoc();

                $output['id'] = $_POST['author_id'];
                $output['name'] = $row['authorname'];
                $output['address'] = $row['address'];
                $output['bio'] = $row['bio'];
                if ($row['cover'] != '') {
                    $output['image'] = '<img src="data:image/jpeg;base64,'.base64_encode($row['avatar'] ).'" height="60" width="75" class="img-thumbnail" />';
                }else{
                   $output['image'] = '<input type="hidden" name="hidden_author_image" value="" />';
                }


            }
            echo json_encode($output);
        }
    }
    
    if ($page == 'delete') {
        
        $sql = "DELETE FROM author WHERE id = '".$_POST["author_id"]."'";
        if($conn->query($sql))
        {
            echo 'Đã xóa thành công';
        }
    }

    if ($page == 'update') {

        $id             = $_POST['modal_id'];
        $name           = $_POST['modal_name'];
        $addres         = $_POST['modal_addres'];
        $bio            = $_POST['modal_bio'];
    
        if ($_POST['modal_image'] != '') {
            $image = addslashes(file_get_contents($_FILES["modal_image"]["tmp_name"]));
            $result = $conn->query("UPDATE author SET avatar='$image' WHERE id='$id' ");
        }

        $sql = "UPDATE author SET authorname = '$name', address ='$address',bio='$bio WHERE id = '$id'";
        
        $result = $conn->query($sql);
        if ($result) {   
            echo "Cập nhật tác giả thành công";
        }else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>


