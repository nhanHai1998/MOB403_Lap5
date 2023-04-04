<?php
// PHP hỗ trợ các loại thư viện làm việc với SQL: MySQL, MySQLi, PDO
// Thực hành với PDO:

$objConn = null;
$db_host = 'localhost'; // 
$db_name = 'thuc_hanh';
$db_user = 'root';
$db_pass = '';
try{
    $objConn = new PDO("mysql:host=$db_host;dbname=$db_name",$db_user, $db_pass);
    $objConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Kết nối CSDL thành công';
}catch(Exception $e){
    die('Lỗi kết nối CSDL: ' . $e->getMessage());
}