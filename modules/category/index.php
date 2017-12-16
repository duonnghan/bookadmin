<?php
define("IN_SITE", true);
include_once("../../libs/functions.php");
session_start();

$current_page = $_GET['page'] ?? 1;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Các danh mục</title>
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
                            <h3 class="box-title">Danh sách các danh mục</h3>
                            <div class="table-responsive">
                                <table class="table table-hover" id="tabledit" >
                                    <thead>
                                        <tr class="active">
                                            <th>#</th>
                                            <th>Tên danh mục</th>
                                            <th>Hành động</th>
                                            <th><button type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapseAdd" aria-expanded="false" aria-controls="collapseAdd"><i class=" fa fa-plus-square"></i>  Thêm</button></th>
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
                                        editable: [[1, 'name']]
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

                            <div>
                                <nav aria-label="Page navigation">
                                  <ul class="pagination">
                                    <li>
                                      <a href="#" class="disabled" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                      </a>
                                    </li>
                                    <li class="active"><a href="#">1<span class="sr-only">(current)</span></a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li>
                                      <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                      </a>
                                    </li>
                                  </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- ============================================================== -->
                <!-- Thêm danh muc -->
                <!-- ============================================================== -->
                <!-- Hien thi ket qua sau khi them -->
                <div id="result"></div>

                <div class="container">
                    <div class="row white-box collapse" id="collapseAdd">

                        <div class="col-md-4 col-md-offset-4 col-xs-12">
                            <div>
                                <form class="form-horizontal form-material">
                                    <div class="form-group">
                                        <label class="col-md-12">Tên danh mục</label>
                                        <div class="col-md-12">
                                            <input type="text" id="name" placeholder="Tên danh mục" class="form-control form-control-line"> </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button name="addcategory" type="Submit" onclick="addCategory()" value="add" class="btn btn-success">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                    <script type="text/javascript">
                        function addCategory() {
                            var name = $('#name').val();
                            $.ajax({
                                type: 'POST',
                                url: 'process.php?p=add',
                                data: {
                                    name: name
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