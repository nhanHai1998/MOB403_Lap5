<?php

function listAll()
{
    global $objConn;
    try {
        $sql_str = "SELECT * FROM `tb_truyen`";
        // tạo đối tượng prepare chuẩn bị cho cú pháp thực thi truy vấn
        $stmt = $objConn->prepare($sql_str);
        // thực thi câu lệnh
        $stmt->execute();
        //thiết lập chế độ lấy dữ liệu
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // lấy dữ liệu:
        $danh_sach = $stmt->fetchAll();

        $dataRes = [
            'status' => 1,
            'msg' => 'Thành công',
            'data' => $danh_sach
        ];
        echo '<pre>';
        print_r($danh_sach);
        echo '</pre>';
        die(json_encode($dataRes));

    } catch (Exception $e) {
        die('Lỗi thực hiện truy vấn CSLD ' . $e->getMessage());
    }

}

function getid($id)
{
    global $objConn;
    try {
        $sql_str = "SELECT * FROM `tb_truyen` WHERE id = $id";
        // tạo đối tượng prepare chuẩn bị cho cú pháp thực thi truy vấn
        $stmt = $objConn->prepare($sql_str);
        // thực thi câu lệnh
        $stmt->execute();
        //thiết lập chế độ lấy dữ liệu
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // lấy dữ liệu:
        $danh_sach = $stmt->fetchAll();

        $dataRes = [
            'status' => 1,
            'msg' => 'Thành công',
            'data' => $danh_sach
        ];
        echo '<pre>';
        print_r($danh_sach);
        echo '</pre>';
        die(json_encode($dataRes));

    } catch (Exception $e) {
        die('Lỗi thực hiện truy vấn CSLD ' . $e->getMessage());
    }

}

function addTruyen()
{
    global $objConn;

    $ten_truyen = $_POST['ten_truyen'];
    $tac_gia = $_POST['tac_gia'];
    $nam_sx = $_POST['nam_xb'];
    $anh_bia = $_POST['anh_bia'];

    if (empty($ten_truyen)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập tên truyện'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "INSERT INTO `tb_truyen`(`id`, `ten_truyen`, `tac_gia`, `nam_xb`, `anh_bia`) VALUES ('','$ten_truyen','$tac_gia','$nam_sx','$anh_bia')"
            );

            // gán tham số cho câu lệnh
            // $stmt->bindParam(":tham_so_username", $username);
            // thực thi
            $stmt->execute();

            $dataRes = [
                'status' => 1,
                'msg' => 'Đã thêm thành công',
                listAll()

            ];

        } catch (PDOException $e) {

            $dataRes = [
                'status' => 0,
                'msg' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    die(json_encode($dataRes));
}

function updateTruyen($_PUT)
{
    global $objConn;

    $id = $_PUT['id'];
    $ten_truyen = $_PUT['ten_truyen'];
    $tac_gia = $_PUT['tac_gia'];
    $nam_sx = $_PUT['nam_xb'];
    $anh_bia = $_PUT['anh_bia'];
    if (empty($id)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập id truyện'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "UPDATE `tb_truyen` SET `ten_truyen`='$ten_truyen',`tac_gia`='$tac_gia',`nam_xb`='$nam_sx',`anh_bia`='$anh_bia' WHERE id ='$id'"
            );

            // gán tham số cho câu lệnh
            // $stmt->bindParam(":tham_so_username", $username);
            // thực thi
            $stmt->execute();

            $dataRes = [
                'status' => 1,
                'msg' => 'Đã sửa thành công',
                listAll()
            ];

        } catch (PDOException $e) {

            $dataRes = [
                'status' => 0,
                'msg' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    die(json_encode($dataRes));
}

function deleteTruyen($_DELETE)
{
    global $objConn;

    $id = $_DELETE['id'];
    if (empty($id)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập id truyện'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "DELETE FROM `tb_truyen` WHERE id = '$id'"
            );

            // gán tham số cho câu lệnh
            // $stmt->bindParam(":tham_so_username", $username);
            // thực thi
            $stmt->execute();

            $dataRes = [
                'status' => 1,
                'msg' => 'Đã xóa thành công',
                listAll()
            ];

        } catch (PDOException $e) {

            $dataRes = [
                'status' => 0,
                'msg' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    die(json_encode($dataRes));
}


//---- xử lý gọi hàm 

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    if (empty($_GET['id'])) // không có id là trang danh sách, có id là chi tiết
        listAll(); // gọi hàm listAll;
    else {
        getid($_GET['id']);
    }
}

if ($method == 'POST') { // đã là post thì chỉ thêm mới, muốn sửa thì dùng PUT
    parse_str(file_get_contents('php://input'), $_POST);
    addTruyen();
}
if ($method == 'PUT') {
    parse_str(file_get_contents('php://input'), $_PUT);
    updateTruyen($_PUT);
}
if ($method == 'DELETE') {
    parse_str(file_get_contents('php://input'), $_DELETE);
    deleteTruyen($_DELETE);
}