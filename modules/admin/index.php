<?php
define("IN_SITE", true);
include_once("../../libs/functions.php");
session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Người quản trị</title>
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
                            <h3 class="box-title">Danh sách admin</h3>
                            <div class="table-responsive">
                                <table class="table table-hover" id="tabledit" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tài khoản</th>
                                            <th>Mật khẩu</th>
                                            <th>Lân cuối đăng nhập</th>
                                            <th>Hành động</th>
                                            <th><button type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapseInsert" aria-expanded="false" aria-controls="collapseInsert"><i class=" fa fa-plus-square"></i>  Thêm</button></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <!-- <script src="../../js/jquery.min.js"></script>
                            <script src="../../js/bootstrap.min.js"></script>
                            <script src="../../js/jquery.tabledit.js"></script> -->
                            <script>
                            function viewData(){
                                $.ajax({
                                    url: 'process.php?p=view',
                                    method: 'GET'
                                }).done(function(data){
                                    $('tbody').html(data)
                                    tableData()
                                })
                            }
                            function tableData(){
                                $('#tabledit').Tabledit({
                                    url: 'process.php',
                                    eventType: 'dblclick',
                                    editButton: true,
                                    deleteButton: true,
                                    hideIdentifier: true,
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
                                            html: 'Save'
                                        },
                                        restore: {
                                            class: 'btn btn-sm btn-warning',
                                            html: 'Restore',
                                            action: 'restore'
                                        },
                                        confirm: {
                                            class: 'btn btn-sm btn-default',
                                            html: 'Confirm'
                                        }
                                    },
                                    columns: {
                                        identifier: [0, 'id'],
                                        editable: [[1, 'name'],[2, 'password']]
                                    },
                                    onSuccess: function(data, textStatus, jqXHR) {
                                        viewData()
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
                <!-- Them admin -->
                <!-- ============================================================== -->
                <!-- Hien thi ket qua sau khi them -->
                <div id="result"></div>

                <div class="container">
                    <div class="row white-box collapse" id="collapseInsert">

                        <div class="col-md-4 col-md-offset-4 col-xs-12">
                            <div>
                                <form class="form-horizontal form-material">
                                    <div class="form-group">
                                        <label class="col-md-12">Tài khoản</label>
                                        <div class="col-md-12">
                                            <input type="text" id="username" placeholder="Tài khoản" class="form-control form-control-line"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Mật khẩu</label>
                                            <div class="col-md-12">
                                                <input type="password" id="password" placeholder="Mật khẩu" class="form-control form-control-line"> </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button name="addadmin" type="Submit" value="add" class="btn btn-success" onclick="addAdmin()">Thêm</button>
                                                </div>
                                            </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        function addAdmin() {
                            var username = $('#username').val();
                            var password = $('#password').val();
                            $.ajax({
                                type: 'POST',
                                url: 'process.php?p=add',
                                data: 'user='+username+'&pass='+password,
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