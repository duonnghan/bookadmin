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

                            //Lay thong tin khach hang
                            $(document).ready(function(){  
                                   $('.hover').popover({  
                                        title:fetchData,  
                                        html:true,  
                                        placement:'right'  
                                   });  
                                   function fetchData(){  
                                        var fetch_data = '';  
                                        var element = $(this);  
                                        var id = element.attr("id");  
                                        $.ajax({  
                                             url:"fetch.php",  
                                             method:"POST",  
                                             async:false,  
                                             data:{id:id},  
                                             success:function(data){  
                                                alert("done");
                                                fetch_data = data;  
                                             }  
                                        });  
                                        return fetch_data;  
                                   }  
                              });
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