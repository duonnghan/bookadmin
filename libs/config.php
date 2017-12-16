<?php

    //
    if (!defined('IN_SITE')) die ('The request not found');

    // Cấu hình kết nối database
    $dbHost = '127.0.0.1';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'qlsach';
    //So record hien thi tren trang
    $limit = 10;
    
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

?>