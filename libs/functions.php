<?php

include_once("database.php");
include_once("config.php");
include_once("session.php");
/*
	Kiểm tra nếu phiên user id có hay không. Nếu không chuyển
	tới trang login. Nếu có và tìm thấy
	$_GET['logout'] trong truy vấn thì đăng xuất thành viên
*/
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
	$password = md5($_POST['txtPassword']);

	// trước tiên, chắc chắn là username & password có giá trị
	if ($userName == '') {
		$errorMessage = 'Vui lòng nhập username';
	} else if ($password == '') {
		$errorMessage = 'Vui lòng nhập mật khẩu';
	} else {
		// kiểm tra database và thấy nếu username và password đều có
		$sql="select username from admin where username='" . $userName . "' And password='".$password. "'";
		$result = dbQuery($sql);

		if (dbNumRows($result) == 1) {
			$row = dbFetchAssoc($result);
			$_SESSION['admin_id'] = $row['username'];
            echo "Dang nhap thanh cong";

			// ghi lại thời gian mà thành viên đó đăng nhập lần cuối
			$sql = "UPDATE admin
			        SET lastlogin = NOW()
					WHERE username = '{$row['username']}'";
			dbQuery($sql);
                  
            redirect("main.php");
		} else {
			$errorMessage = 'Sai tên đăng nhập hoặc mật khẩu';
			echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu, vui lòng nhập lại.')</script>";
		}

	}

	return $errorMessage;
}

/*
	Thành viên đăng xuất
*/
function doLogout()
{
	if (isset($_SESSION['admin_id'])) {
		unset($_SESSION['admin_id']);
		session_unregister('admin_id');
	}

	header("Local: login.php");
	exit();
}


/*************************************************
	Tạo thumbnail của $srcFile và lưu vào $destFile.
	Thumbnail có kích thước $width pixel.
**************************************************/
function createThumbnail($srcFile, $destFile, $width, $quality = 75)
{
	$thumbnail = '';

	if (file_exists($srcFile)  && isset($destFile))
	{
		$size        = getimagesize($srcFile);
		$w           = number_format($width, 0, ',', '');
		$h           = number_format(($size[1] / $size[0]) * $width, 0, ',', '');

		$thumbnail =  copyImage($srcFile, $destFile, $w, $h, $quality);
	}

	// trả về tên file thumbnail khi thành công hoặc để trắng nếu không được
	return basename($thumbnail);
}



/*********************************************************
	Tạo link phân trang
*************************************************************/
class PerPage {
	public $perpage;
	
	function __construct() {
		$this->perpage = 10;
	}
	
	function getAllPageLinks($count) {
		$output = '';
		if(!isset($_GET["page"])) $_GET["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if($_GET["page"] == 1) 
				$output = $output . '<span class="link first disabled">&#8810;</span><span class="link disabled">&#60;</span>';
			else	
				$output = $output . '<a class="link first" onclick="fetch_data(\''  . (1) . '\')" >&#8810;</a><a class="link" onclick="fetch_data(\''  . ($_GET["page"]-1) . '\')" >&#60;</a>';
			
			
			if(($_GET["page"]-3)>0) {
				if($_GET["page"] == 1)
					$output = $output . '<span id=1 class="link current">1</span>';
				else				
					$output = $output . '<a class="link" onclick="fetch_data(\''  . '1\')" >1</a>';
			}
			if(($_GET["page"]-3)>1) {
					$output = $output . '<span class="dot">...</span>';
			}
			
			for($i=($_GET["page"]-2); $i<=($_GET["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_GET["page"] == $i)
					$output = $output . '<span id='.$i.' class="link current">'.$i.'</span>';
				else				
					$output = $output . '<a class="link" onclick="fetch_data(\''  . $i . '\')" >'.$i.'</a>';
			}
			
			if(($pages-($_GET["page"]+2))>1) {
				$output = $output . '<span class="dot">...</span>';
			}
			if(($pages-($_GET["page"]+2))>0) {
				if($_GET["page"] == $pages)
					$output = $output . '<span id=' . ($pages) .' class="link current">' . ($pages) .'</span>';
				else				
					$output = $output . '<a class="link" onclick="fetch_data(\''  .  ($pages) .'\')" >' . ($pages) .'</a>';
			}
			
			if($_GET["page"] < $pages)
				$output = $output . '<a  class="link" onclick="fetch_data(\''  . ($_GET["page"]+1) . '\')" >></a><a  class="link" onclick="fetch_data(\''  . ($pages) . '\')" >&#8811;</a>';
			else				
				$output = $output . '<span class="link disabled">></span><span class="link disabled">&#8811;</span>';
			
			
		}
		return $output;
	}
	function getPrevNext($count) {
		$output = '';
		if(!isset($_GET["page"])) $_GET["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if($_GET["page"] == 1) 
				$output = $output . '<span class="link disabled first">Prev</span>';
			else	
				$output = $output . '<a class="link first" onclick="fetch_data(\''  . ($_GET["page"]-1) . '\')" >Prev</a>';			
			
			if($_GET["page"] < $pages)
				$output = $output . '<a  class="link" onclick="fetch_data(\''  . ($_GET["page"]+1) . '\')" >Next</a>';
			else				
				$output = $output . '<span class="link disabled">Next</span>';
			
			
		}
		return $output;
	}
}


//Ham lay thong tin sach
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

//Ham lay so luong nguoi dung
function getNumUsers(){
   return dbCount('customer');
}

//Ham lay so luong hoa don
function getNumOrders(){
    return dbCount('orderbook');
}

//Ham lay tong gia tri cac don hang
function getTotalPrices(){
    $sql = "SELECT SUM(count) from orderdetail";
    return dbQuery($sql);
}


?>
