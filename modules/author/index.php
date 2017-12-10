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
                            <h3 class="box-title">Danh sách tác giả</h3>
                            <div class="table-responsive">
                                <table class="table table-hover" id="tabledit" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên tác giả</th>
                                            <th>Địa chỉ</th>
                                            <th>Tiểu sử</th>
                                            <th>Ảnh</th>
                                            <th><button type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapseInsert" aria-expanded="false" aria-controls="collapseInsert"><i class=" fa fa-plus-square"></i>  Thêm</button></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div>
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
                <!-- Them author -->
                <!-- ============================================================== -->
                <!-- Hien thi ket qua sau khi them -->
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
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" id="modal_address" name="modal_address"><br>
                    </div> 
                    <div class="form-group">
                        <label>Tiểu sử</label>
                        <textarea class="form-control" id="modal_bio" name="modal_bio"></textarea><br>
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

<script type="text/javascript">

    $(document).ready(function(){

        fetch_data();

        function fetch_data(){
            $.ajax({
                url:"process.php?p=view",
                method:"POST",
                success:function(data){
                    $('tbody').html(data);
                }
            })
        }

        

        $('form#insert_form').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var image = $('#image').val();

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
                        fetch_data();
                        $('#insert_form')[0].reset();
                        // $('#collapseInsert').toggle();
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
                    $('#authorModal')[0].reset();
                    fetch_data();
                    location.reload();
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
                    $('#modal_name').val(data.name);
                    $('#modal_address').val(data.address);
                    $('#modal_bio').val(data.bio);
                    $('#author_uploaded_image').html(data.image);
                    $('#authorModal').modal('show');
                }
            })
        });

        $(document).on('click', '.delete', function(){
                var author_id = $(this).attr("id");
                if(confirm("Bạn có muốn chắc chắn muốn xóa bản ghi không?"))
                {
                    $.ajax({
                        url:"process.php?p=delete",
                        method:"POST",
                        data:{author_id: author_id},
                        success:function(data){
                            alert(data);
                            location.reload();
                            fetch_data();
                        }
                   })
               }
               else
               {
                 return false;
               }
            });

    });

    
</script>