<?php


function getBlTruyen()
{
    global $objConn;
    try {
        $id_truyen = $_GET['id_truyen'];
        $sql_str = "SELECT * FROM `tb_binh_luan` WHERE `id_truyen` = '$id_truyen';";
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

function addBinhLuan()
{
    global $objConn;

    $id_truyen = $_POST['id_truyen'];
    $id_user = $_POST['id_user'];
    $noi_dung = $_POST['noi_dung'];
    $ngay_gio = date('H:i:s Y-m-d');

    if (empty($id_truyen)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập id truyện'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "INSERT INTO `tb_binh_luan`(`id`, `id_truyen`, `id_user`, `noi_dung`, `ngay_gio`) VALUES ('','$id_truyen','$id_user','$noi_dung','$ngay_gio')"
            );

            // gán tham số cho câu lệnh
            // $stmt->bindParam(":tham_so_username", $username);
            // thực thi
            $stmt->execute();

            $dataRes = [
                'status' => 1,
                'msg' => 'Đã thêm thành công'
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

function updateBinhLuan($_PUT)
{
    global $objConn;

    $id = $_PUT['id'];
    $noi_dung = $_PUT['noi_dung'];
    $id_truyen = $_PUT['id_truyen'];
    $id_user = $_PUT['id_user'];
    if (empty($id)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập id bình luận'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "UPDATE `tb_binh_luan` SET `noi_dung`='$noi_dung' WHERE id =$id AND `id_truyen` ='$id_truyen' AND `id_user` = '$id_user'" 
            );

            
            $stmt->execute();

            $dataRes = [
                'status' => 1,
                'msg' => 'Đã sửa thành công'
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

function deleteBinhLuan($_DELETE)
{
    global $objConn;

    $id = $_DELETE['id'];
    if (empty($id)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập id bình luận'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "DELETE FROM `tb_binh_luan` WHERE id = '$id'"
            );

            // gán tham số cho câu lệnh
            // $stmt->bindParam(":tham_so_username", $username);
            // thực thi
            $stmt->execute();

            $dataRes = [
                'status' => 1,
                'msg' => 'Đã xóa thành công',
                
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
    getBlTruyen();
}

if ($method == 'POST') { // đã là post thì chỉ thêm mới, muốn sửa thì dùng PUT
    addBinhLuan();
}
if ($method == 'PUT') {
    parse_str(file_get_contents('php://input'), $_PUT);
    updateBinhLuan($_PUT);
}
if ($method == 'DELETE') {
    parse_str(file_get_contents('php://input'), $_DELETE);
    deleteBinhLuan($_DELETE);

}