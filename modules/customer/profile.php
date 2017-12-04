<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Thông tin khách hàng</title>
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
  <style type="text/css">
		  .user-row {
		    margin-bottom: 14px;
		  }

		  .user-row:last-child {
		    margin-bottom: 0;
		  }

		  .dropdown-user {
		    margin: 13px 0;
		    padding: 5px;
		    height: 100%;
		  }

		  .dropdown-user:hover {
		    cursor: pointer;
		  }

		  .table-user-information > tbody > tr {
		    border-top: 1px solid rgb(221, 221, 221);
		  }

		  .table-user-information > tbody > tr:first-child {
		    border-top: 0;
		  }


		  .table-user-information > tbody > tr > td {
		    border-top: 0;
		  }
		  .toppad
		  {margin-top:20px;
		  }

	</style>
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</head>
<body>
	<?php
		$i = $_GET['id'] ?? '';
		$conn = new mysqli('localhost', 'root', '', 'qlsach');
		mysqli_set_charset($conn,"utf8");

		if (mysqli_connect_errno()) {
		echo json_encode(array('conn' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
		exit;
		}

		if (empty($id)) {
			echo "Không tồn tại khách hàng.";
		}else{
			$result = $conn->query("SELECT * FROM customer WHERE id='$id'");

			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				?>
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

							<div class="panel panel-info">

								<div class="panel-heading">
									<h3 class="panel-title">Thông tin khách hàng</h3>
								</div>

								<div class="panel-body">
									<div class="row">

										<div class=" col-md-9 col-lg-9 col-md-offset-2 "> 
											<table class="table table-user-information">
												<tbody>
													<tr>
														<td>Họ tên:</td>
														<td><?php echo $row['name'] ?></td>
													</tr>
													<tr>
														<td>Email:</td>
														<td><a href="<?php echo $row['email'] ?>"><?php echo $row['email'] ?></a></td>
													</tr>
													<tr>
														<td>Địa chỉ</td>
														<td><?php echo $row['address'] ?></td>
													</tr>
													<tr>
														<tr>
															<td>Giới tính</td>
															<td><?php echo $row['gender'] ?></td>
														</tr>
														<tr>
															<td>Số điện thoại</td>
															<td><?php echo $row['phone'] ?></td>
														</tr>
														<td>Danh sách đơn hàng</td>
														<td>
															<?php
															$result = $conn->query("SELECT id FROM orderbook WHERE userid='$row['id']'");

															if ($result->num_rows > 0) {
																while ($row = $result->fetch_assoc()) {
																	echo "<a>$row['id']</a><br><br>";
																}

															}else{
																echo "Không có hóa đơn nào.<br><br>";
															}

															?>
														</td>

													</tr>

												</tbody>
											</table>

											<a href="./index.php" class="btn btn-success">Xem danh sách</a>
											<button type="button" class="btn btn-info" onclick="goBack()">Trở về</button>

											<script type="text/javascript">
												function goBack() {
													window.history.back();
												}
											</script>
										</div>

									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}

	?>
</body>
</html>