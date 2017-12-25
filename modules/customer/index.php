<?php
    define("IN_SITE", true);
    include_once("../../libs/functions.php");
    session_start();
    checkUser();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Khách hàng</title>
    <?php include_once('../components/style.php') ?>
</head>

<body class="fix-header" onload="viewData()"> 
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <?php include_once("../widgets/header.php");?>

        <?php include_once("../widgets/sidebar.php");?>
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bang danh sach cac admin -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 ">
                        <div class="white-box">
                            <h3 class="box-title">Danh sách các khách hàng</h3>
                            <div class="table-responsive">
                            </div>
                            <script>
                            function viewData(page){
                                $.ajax({
                                    url: 'process.php?p=view',
                                    method: 'GET',
                                    data: {page:page}
                                }).done(function(data){
                                    $('.table-responsive').html(data)
                                    tableData(page)
                                })
                            }
                            function tableData(page){
                                $('#tabledit').Tabledit({
                                    url: 'process.php',
                                    eventType: 'dblclick',
                                    editButton: true,
                                    deleteButton: true,
                                    hideIdentifier: false,
                                    buttons: {
                                        edit: {
                                            class: 'btn btn-sm btn-warning',
                                            html: '<span class="glyphicon glyphicon-pencil"></span> Sửa',
                                            action: 'edit'
                                        },
                                        delete: {
                                            class: 'btn btn-sm btn-danger',
                                            html: '<span class="glyphicon glyphicon-trash"></span> Xóa',
                                            action: 'delete'
                                        },
                                        save: {
                                            class: 'btn btn-sm btn-success',
                                            html: 'Lưu'
                                        },
                                        confirm: {
                                            class: 'btn btn-sm btn-primary',
                                            html: 'Xác nhận'
                                        }
                                    },
                                    columns: {
                                        identifier: [0, 'id'],
                                        editable: [[1, 'name'],[2, 'email'],[3, 'address'],[4, 'gender','{"Nam":"Nam", "Nữ":"Nữ", "Khác":"Khác"}'],[5, 'phone']]
                                    },
                                    onSuccess: function(data, textStatus, jqXHR) {
                                        viewData(page)
                                    },
                                    onFail: function(jqXHR, textStatus, errorThrown) {
                                        console.log('onFail(jqXHR, textStatus, errorThrown)');
                                        console.log(jqXHR);
                                        console.log(textStatus);
                                        console.log(errorThrown);
                                    },
                                    onAjax: function(action, serialize) {
                                        console.log('onAjax(action, serialize)');
                                        console.log(action);
                                        console.log(serialize);
                                    }
                                });
                            }
                            </script>
                        </div>
                    </div>
                </div>
    
                <!-- ============================================================== -->
                <!-- Thêm admin -->
                <!-- ============================================================== -->
                <!-- Hien thi ket qua sau khi them -->
                <div id="result"></div>

                <div class="container">
                    <div class="row white-box collapse" id="collapseAdd">

                        <div class="col-md-4 col-md-offset-4 col-xs-12">
                            <div>
                                <form class="form-horizontal form-material">
                                    <div class="form-group">
                                        <label class="col-md-12">Họ tên khách hàng</label>
                                        <div class="col-md-12">
                                            <input type="text" id="name" placeholder="Nhập họ tên" class="form-control form-control-line"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="text" id="email" placeholder="Nhập email" class="form-control form-control-line"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Địa chỉ</label>
                                        <div class="col-md-12">
                                            <input type="text" id="address" placeholder="Nhập địa chỉ" class="form-control form-control-line"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Giới tính</label>
                                        <div class="col-md-12">
                                            <label class="radio-inline"><input type="radio" class="gender" name="gender" value="Nam" checked>Nam</label>
                                            <label class="radio-inline"><input type="radio" class="gender" name="gender" value="Nữ">Nữ</label>
                                            <label class="radio-inline"><input type="radio" class="gender" name="gender" value="Khác">Khác</label> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Số điện thoại</label>
                                        <div class="col-md-12">
                                            <input type="text" id="phone" placeholder="Số điện thoại" class="form-control form-control-line"> </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button name="addCustomer" type="Submit" onclick="addCustomer()" value="add" class="btn btn-success">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                    <script type="text/javascript">
                        function addCustomer() {
                            var name = $('#name').val();
                            var email = $('#email').val();
                            var address = $('#address').val();
                            var gender = $('.gender').val();
                            var phone = $('#phone').val();

                            $.ajax({
                                type: 'POST',
                                url: 'process.php?p=add',
                                data: {
                                    name: name,
                                    email: email,
                                    address: address,
                                    gender: gender,
                                    phone: phone
                                },
                                success: function(result){
                                    $('#result').html(result);
                                    alert("Them thanh cong");
                                }
                            });
                        }

                    </script>
                </div>
            </div>
            <!-- /.container-fluid -->
            <?php include_once("../widgets/footer.php"); ?>

        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <?php include_once('../components/script.php') ?>

</body>

</html>