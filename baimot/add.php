<?php
require_once("db.php");
$msg ='';
if (isset($_POST['ten_loai'])) {//khi post
$ten_loai = $_POST['ten_loai'];
if(empty($ten_loai)){
    $msg = 'chưa nhập tên loại';
}else{
try {
    $stmt = $objConn->prepare(
     "INSERT INTO the_loai (ten_loai) VALUES (:tham_so_ten);"
     // gán tso cho cau lenh
    );
    $stmt->bindParam(":tham_so_ten",$ten_loai);
    //thự thi
    $stmt->execute();
    $msg = 'thêm thành công';
} catch (\Throwable $th) {
    $msg = 'cutttttt'.$th->getMessage();
}
}

   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Thêm Thể Loại</h1>
    <?php echo $msg?>
    <form action="" method="post">
        <input type="text" name="ten_loai" placeholder="tên loại"><br>
        <button type="submit">Thêm</button>
    </form>
</body>
</html>
