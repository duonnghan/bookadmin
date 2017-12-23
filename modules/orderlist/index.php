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
    <title>Đơn hàng</title>
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
                            <h3 class="box-title">Danh sách các đơn hàng</h3>
                            <div class="table-responsive">
                            </div>
                           
                            <script>

                            function viewData(page){
                                $.ajax({
                                    url: 'process.php?p=view',
                                    method: 'GET',
                                    data: {page: page}
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
                                        editable: [[2, 'orderdate'],[3, 'paiddate'],[4, 'shipstat','{"1":"Đã thanh toán", "0":"Chưa thanh toán"}'],[5, 'shipstat','{"1":"Đã giao hàng", "0":"Chưa giao hàng"}']]
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

<div id="orderModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="modal_view_form" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chi tiết đơn hàng</h4>
            </div>

                <div class="modal-body">
                    
                    <input type="hidden" name="modal_id" id="modal_id" />
                    <div class="col-md-6">
                        <strong>Họ tên: </strong>
                        <span id="modal_name"></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Giới tính: </strong>
                        <span id="modal_gender"></span>
                    </div>
                    <br><br>
                    <div class="col-md-12">
                        <strong>Địa chỉ: </strong>
                        <span id="modal_address"></span>
                    </div>
                    <br><br>
                    <div class="col-md-12">
                        <strong>Email: </strong>
                        <span id="modal_email"></span>
                    </div>
                    <br><br>
                    <div class="col-md-12">
                        <strong>Số điện thoại: </strong>
                        <span id="modal_phone"></span>
                    </div>

                    <div class="col-md-12">
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
                            <tbody id="modal_order_detail">
                            </tbody>

                        </table>
                    </div>
                    <br><br>
                    <div class="text-right col-md-12"><strong>Tổng: </strong>$ <span id="modal_amount"></span></div>
                    <br><br>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>

        </div>
        </form>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function(){

        $(document).on('click', '.view', function(){
            var order_id = $(this).attr("id");
            $.ajax({
                url: "process.php?p=fetch_order",
                method: "POST",
                data:{order_id:order_id},
                dataType: "json",
                success: function(data){
                    $('#modal_id').val(data.id);
                    $('#modal_name').val(data.c_name);
                    $('#modal_email').val(data.c_email);
                    $('#modal_address').val(data.c_address);
                    $('#modal_phone').val(data.c_phone);
                    $('#modal_gender').val(data.c_gender);
                    $('#modal_order_detail').html(data.order_detail);
                    $('#orderModal').modal('show');
                }
            })
        });

    });

    
</script>