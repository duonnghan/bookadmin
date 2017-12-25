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
    <title>Tác giả</title>
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
                            <h3 class="box-title">Danh sách tác giả</h3>
                            <div class="table-responsive">
                            </div>
                            
                        </div>
                    </div>
                </div>
    
                <!-- ============================================================== -->
                <!-- Add author -->
                <!-- ============================================================== -->
                <!-- Then display result after add -->
                <div id="result"></div>

                <div class="container">
                    <div class="row white-box collapse" id="collapseInsert">

                        <div class="col-md-4 col-md-offset-4 col-xs-12">
                            <div>
                                <form class="form-horizontal form-material" method="post" id="insert_form">
                                    <div class="form-group">
                                        <label class="col-md-12">Tên tác giả</label>
                                        <div class="col-md-12">
                                            <input type="text" id="name" name="name" placeholder="Nhập tên tác giả" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Ngày sinh</label>
                                        <div class="col-md-12">
                                            <input class="form-control" id="dob" name="dob" placeholder="YYYY-MM-DD" type="text"/>
                                            <span class="error"> Invalid Date.(yyyy-mm-dd)</span>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Địa chỉ</label>
                                        <div class="col-md-12">
                                            <input type="text" id="address" name="address" placeholder="Nhập địa chỉ" class="form-control form-control-line">
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="col-md-12">Tiểu sử</label>
                                        <div class="col-md-12">
                                            <textarea rows="6" id="bio" name="bio" placeholder="Nhập tiểu sử tác giả..." class="form-control form-control-line"></textarea> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12">Ảnh</label>
                                        <div class="col-md-12">
                                            <div class="box">
                                                <input type="file" id="image" name="image" class="inputfile" />
                                                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="submit" value="Thêm" class="btn btn-success">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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

<!-- Update author's infomation through modal dialog -->
<div id="authorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="modal_update_form" method="post" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cập nhật thông tin tác giả</h4>
            </div>

                <div class="modal-body">
                
                    <input type="hidden" name="modal_id" id="modal_id" />
                    <div class="form-group">
                        <label>Tên tác giả</label>
                        <input type="text" class="form-control" id="modal_name" name="modal_name"><br>
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh</label>
                        <input class="form-control" id="modal_dob" name="modal_dob" placeholder="YYYY-MM-DD" type="text"/>
                    </div>    
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" id="modal_address" name="modal_address"><br>
                    </div> 
                    <div class="form-group">
                        <label>Tiểu sử</label>
                        <textarea class="form-control" id="modal_bio" rows="7" name="modal_bio"></textarea><br>
                    </div>
                    <div class="form-group">
                        <label>Ảnh</label>
                        <input type="file" name="modal_image" id="modal_image"/><br>
                        <span id="author_uploaded_image"></span>
                    </div>
                
                </div>

            <div class="modal-footer">
                <input type="submit" name="update" id="update" value="Cập nhật" class="btn btn-info" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>

        </div>
        </form>
    </div>
</div>

<!-- Add date picker -->
<script type="text/javascript" src="../../js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="../../css/bootstrap-datepicker3.css"/>

<script type="text/javascript">
    viewData();

    function viewData(page){
        $.ajax({
            url:"process.php?p=view",
            method:'GET',
            data: {page: page},
            success:function(data){
                $('.table-responsive').html(data);
            }
        })
    }
    
    function datepicker(){
        var date_input=$('input[name="modal_dob"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy-mm-dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    }

    $(document).ready(function(){
        $('.error').hide();

        $('form#insert_form').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var image = $('#image').val();
            var dob = $('#dob').val();
            if(ValidateDate(dtVal)){
                $('.error').hide();
            }
                else{
                $('.error').show();
                event.preventDefault();
            }

            if (image == '') {
                alert("Vui lòng chọn tập tin");
                return false;
            }else{
                //Dinh dang cua anh
                var extension = $('#image').val().split('.').pop().toLowerCase();
                //Neu anh upload khong thuoc cac dinh dang thong tuong
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1){
                    alert("Định dạng file ảnh không hợp lệ");
                    $('#image').val('');
                    return false;
                }

                $.ajax({
                    url: "process.php?p=add",
                    method: "POST",
                    data: formData,
                    success: function (data) {
                        viewData();
                        $('#insert_form')[0].reset();
                        $('#collapseInsert').toggle();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

        });

        $('form#modal_update_form').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var currentPage = $('.current_page').text();

            var image = $('#modal_image').val();
            if (image != ''){
                //Dinh dang cua anh
                var extension = $('#modal_image').val().split('.').pop().toLowerCase();
                //Neu anh upload khong thuoc cac dinh dang thong tuong
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1){
                    alert("Định dạng file ảnh không hợp lệ");
                    $('#image').val('');
                    return false;
                }
            }

            $.ajax({
                url: "process.php?p=update",
                method: "POST",
                data: formData,
                success: function (data) {
                    $('#authorModal').modal('hide');
                    // $('#authorModal')[0].reset();
                    viewData(currentPage);
                    // location.reload();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $(document).on('click', '.update', function(){
            var author_id = $(this).attr("id");

            $.ajax({
                url: "process.php?p=fetch_author",
                method: "POST",
                data:{ author_id: author_id},
                dataType: "json",
                success: function(data){
                    $('#modal_id').val(data.id);
                    $('#modal_name').val(data.name);
                    $('#modal_dob').val(data.dob);
                    $('#modal_address').val(data.address);
                    $('#modal_bio').val(data.bio);
                    $('#author_uploaded_image').html(data.image);
                    $('#authorModal').modal('show');
                    datepicker();
                }
            })
        });

        $(document).on('click', '.delete', function(){
                var author_id = $(this).attr("id");
                var currentPage = $('.current_page').text();
                if(confirm("Bạn có muốn chắc chắn muốn xóa bản ghi không?"))
                {
                    $.ajax({
                        url:"process.php?p=delete",
                        method:"POST",
                        data:{author_id: author_id},
                        success:function(data){
                            alert(data);
                            // location.reload();
                            viewData(currentPage);
                        }
                   })
               }
               else
               {
                 return false;
               }
            });

        function ValidateDate(dtValue){
            var dtRegex = new RegExp(/\b\d{4}[-]\d{1,2}[-]\d{1,2}\b/);
            return dtRegex.test(dtValue);
        }

    });

    
</script>