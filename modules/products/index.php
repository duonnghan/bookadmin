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
                            <h3 class="box-title">Danh sách sản phẩm</h3>
                            <div class="table-responsive">
                                <table class="table table-hover" id="tabledit" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tựa sách</th>
                                            <th>Giá</th>
                                            <th>Mô tả</th>
                                            <th>Ảnh bìa</th>
                                            <th>Tác giả</th>
                                            <th>Số lượng</th>
                                            <th>Danh mục</th>
                                            <th>Nhà xuất bản</th>
                                            <th>Lần cuối cập nhật</th>
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
                                            editable:[  [1, 'name'],
                                                        [2,'price'],
                                                        [3,'description'],
                                                        [5,'author'],
                                                        [6,'quantity'],
                                                        [7,'category'],
                                                        [8,'publisher']
                                                    ]
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
                                        <label class="col-md-12">Tựa sách</label>
                                        <div class="col-md-12">
                                            <input type="text" id="name" placeholder="Nhập tiêu đề sách" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Giá</label>
                                        <div class="col-md-12">
                                            <input type="number" id="price" placeholder="Nhập giá" class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12">Tác giả</label>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <select class="form-control form-control-line"" id="author">
                                                    <option>1</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                    
                                                  </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12">Số lượng</label>
                                        <div class="col-md-12">
                                            <input type="text" id="quantity" class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12">Danh mục</label>
                                        <div class="col-md-12">
                                            <input type="text" id="category" class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12">Nhà xuất bản</label>
                                        <div class="col-md-12">
                                            <select class="form-control form-control-line"" id="publisher">
                                                <option>1</option>
                                                
                                              </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-12">Mô tả</label>
                                        <div class="col-md-12">
                                            <textarea type="text" rows="6" id="publisher" placeholder="Nhập mô tả sách..." class="form-control form-control-line"></textarea> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12">Ảnh bìa</label>
                                        <div class="col-md-12">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <span class="button"><span>Choose file</span><input type="file" id="cover" /></span>
                                                <span class="fileinput-filename"></span><span class="fileinput-new">No file chosen</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button name="addadmin" type="Submit" value="add" class="btn btn-success" onclick="addProduct()">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        function addProduct() {
                            var name = $('#name').val();
                            var price = $('#price').val();
                            var author = $('#author').val();
                            var quantity = $('#quantity').val();
                            var category = $('#category').val();
                            var description = $('#description').val();
                            var cover = $('#cover').val();

                            $.ajax({
                                type: 'POST',
                                url: 'process.php?p=add',
                                data: {
                                    name:           name,
                                    price:          price,
                                    author:         author,
                                    quantity:       quantity,
                                    category:       category,
                                    description:    description,
                                    cover:          cover
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