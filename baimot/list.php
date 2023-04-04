<?php

require_once("db.php");

try {
    $sql_str = "SELECT * FROM `the_loai` ";
    $stmt = $objConn->prepare($sql_str);

    $stmt->execute();
    //lay dl
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $danh_sach = $stmt->fetchAll();

    echo'<pre>';
    print_r ($danh_sach);
    echo'</pre>';

} catch (Exception $e) {
    die('loi roi..........').$e->getMessage;
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
    <h1>Danh sachs theer loaij</h1>
    <table border="1">
        <tr>
            <th>ID</th> <th>Ten</th>
        </tr>
        
            <?php
            foreach($danh_sach as $k => $row){
                echo"
                <tr>
                <td>{$row['id']}</td>
                <td>{$row['ten_loai']}</td>
                 </tr>
                ";
            }
            ?>
        

    </table>
</body>
</html>
