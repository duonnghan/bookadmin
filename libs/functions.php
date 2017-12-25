<?php

include_once("database.php");
include_once("config.php");
include_once("session.php");
include_once("crypto.php");

/*************************************************
	Kiểm tra nếu phiên user id có hay không. Nếu không chuyển
	tới trang login. Nếu có và tìm thấy
	$_GET['logout'] trong truy vấn thì đăng xuất thành viên
*************************************************/
function checkUser()
{
	// Nếu phiên id không thiết lập, chuyển tới trang login
	if (!isset($_SESSION['admin_id'])) {
		header('Location: /bookadmin/modules/common/login.php');
		exit();
	}

	// thành viên này muốn đăng xuất
	if (isset($_GET['logout'])) {
		doLogout();
	}
}

/************************
Ham chuyen trang
*************************/
function redirect($link){
    header("Location:{$link}");
    exit();
}

/************************
Ham dang nhap
*************************/
function doLogin()
{
	// nếu tìm thấy lỗi, lưu lỗi vào biến sau
	$errorMessage = '';
	$userName = $_POST['txtUserName'];
	$password = $_POST['txtPassword'];

	// trước tiên, chắc chắn là username & password có giá trị
	if ($userName == '') {
		$errorMessage = 'Vui lòng nhập username';
	} else if ($password == '') {
		$errorMessage = 'Vui lòng nhập mật khẩu';
	} else {
		// kiểm tra database và thấy nếu username và password đều có
		$sql="select * from admin where username='" . $userName. "' LIMIT 1";
		$result = dbQuery($sql);

		if (dbNumRows($result) == 1) {
			$row = dbFetchAssoc($result);
			if (hash_equals($row['password'], crypt($password, $row['password']))) {
				$_SESSION['admin_id'] = $row['username'];
	            echo "Dang nhap thanh cong";

				// ghi lại thời gian mà thành viên đó đăng nhập lần cuối
				$sql = "UPDATE admin
				        SET lastlogin = NOW()
						WHERE username = '{$row['username']}'";
				dbQuery($sql);
	                  
	            redirect("main.php");
			}
			
		} else {
			$errorMessage = 'Sai tên đăng nhập hoặc mật khẩu, vui lòng nhập lại.';
			echo "<script>alert('.$errorMessage.')</script>";
		}

	}

	return $errorMessage;
}

/*************************
	Thành viên đăng xuất
*************************/
function doLogout()
{
	if (isset($_SESSION['admin_id'])) {
		unset($_SESSION['admin_id']);
		session_unregister('admin_id');
	}

	header("Local: login.php");
	exit();
}

/*************************
	Ham lay thong tin sach
*************************/
function getBookInfo(){
    $sql = "SELECT b.id, b.`bookname`, b.`price`, b.`description`, b.`cover`, b.`updated`, b.`quantity`, c.categoryname, p.publishername, a.authorname
    FROM `book` AS b, author AS a, publisher AS p, category AS c
    WHERE b.`publisherid` = p.id AND b.`authorid`= a.id AND b.`quantity`= c.id";
    return dbQuery($sql);
}

function getAuthorInfo(){
	$sql = "SELECT * FROM author";
	$result = dbQuery($sql);
	return $result;
}

function getPublisherInfo(){
	$sql = "SELECT * FROM publisher";
	$result = dbQuery($sql);
	return $result;
}

function getCategoryInfo(){
	$sql = "SELECT * FROM category";
	$result = dbQuery($sql);
	return $result;
}

function getCustomerOrderInfo($orderid){
	$sql = "SELECT c.name, c.email, c.address, c.gender, c.phone
			FROM `orderbook` AS ob, `customer` AS c
			WHERE c.id = ob.userid, ob.id='$orderid' ";
	$result = dbQuery($sql);
	return $result;
}

//Ham lay so luong nguoi dung
function getNumUsers(){
   return dbCount('customer');
}

//Ham lay so luong hoa don
function getNumOrders(){
    return dbCount('orderbook');
}

function getNumBooks(){
	return dbCount('book');
}

//Ham lay tong gia tri cac don hang
function getTotalPrices(){
    $sql = "SELECT SUM(count) from orderdetail";
    return dbQuery($sql);
}


?>
