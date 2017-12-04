<?php

    //
    if (!defined('IN_SITE')) die ('The request not found');

    // Cấu hình kết nối database
    $dbHost = '127.0.0.1';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'qlsach';

    //Thiet lap salt cho qua trinh ma hoa password
    define('PASSWORD_DEFAULT','ltweb20171');

    // tùy chỉnh web root và server root cho ứng dụng book shopping cart
    //__FILE__: đường dẫn đến tập tin hiện tại
    $thisFile = str_replace('\\', '/', __FILE__);//C:/xampp/htdocs/admincp/libs/config.php
    $docRoot = $_SERVER['DOCUMENT_ROOT'];// C:/xampp/htdocs

    $webRoot  = str_replace(array($docRoot, 'libs/config.php'), '', $thisFile);//   /admincp/
    $srvRoot  = str_replace('libs/config.php', '', $thisFile);//    C:/xampp/htdocs/admincp/

    define('WEB_ROOT', 'localhost:8080'.$webRoot);//    localhost:8080//admincp/
    define('SRV_ROOT', $srvRoot);// C:/xampp/htdocs/admincp/

    // các thư mục mà bạn muốn chứa tất cả thư mục và ảnh sản phẩm
    define('CATEGORY_IMAGE_DIR', 'images/category/');
    define('PRODUCT_IMAGE_DIR',  'images/product/');

    // vài giới hạn cỡ cho danh mục và ảnh sản phẩm

    // tất cả ảnh danh mục với chiều rộng không quá 75 pixel
    define('MAX_CATEGORY_IMAGE_WIDTH', 75);

    // ta cần giới hạn chiều rộng ảnh sản phẩm
    // chỉnh giá trị là 'true' thì tốt hơn
    define('LIMIT_PRODUCT_WIDTH',     true);

    // chiều rộng tối đa cho tất cả ảnh sản phẩm
    define('MAX_PRODUCT_IMAGE_WIDTH', 300);

    // chiều rộng cho thumbnail sản phẩm
    define('THUMBNAIL_WIDTH',         75);

    //thong bao loi
    $error= array();

?>