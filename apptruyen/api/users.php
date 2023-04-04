<?php
// ?res=theloai  --> danh sách thể loại
// ?res=theloai&id=xxx ==> xem chi tiết 1 thể loại
function listAll(){
    global $objConn;
    try {
        $sql_str = "SELECT * FROM `tb_user`";
        // tạo đối tượng prepare chuẩn bị cho cú pháp thực thi truy vấn
        $stmt = $objConn->prepare(  $sql_str );
        // thực thi câu lệnh
        $stmt->execute(); 
        //thiết lập chế độ lấy dữ liệu
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
        // lấy dữ liệu:
        $danh_sach = $stmt->fetchAll();

        $dataRes = [
            'status'=> 1,
            'msg'=> 'Thành công',
            'data'=> $danh_sach
        ];
        
         die(   json_encode($dataRes) );  
         
    } catch (Exception $e) {
         die( 'Lỗi thực hiện truy vấn CSLD ' . $e->getMessage()  );
    }

}

function adduser(){
    global $objConn;

    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];
        if(empty ($username)||empty($passwd)){
            $dataRes =[
                'status'=>0,
                'msg'=> 'Chưa nhập ddur thoong tin'
            ];
  
        }else{
            // đã nhập full ==> lưu vào CSDL
            try {

                $stmt =  $objConn->prepare(
                    // "INSERT INTO `tb_user`(`id`, `username`, `passwd`, `fullname`, `email`) VALUES ('',':user_name',':passwd',':fullname',':email');"
                    "INSERT INTO `tb_user`(`id`, `username`, `passwd`, `fullname`, `email`) VALUES ('','$username','$passwd','$fullname','$email');"
                );
                
          
                $stmt->execute();
 
                $dataRes =[
                    'status'=>1,
                    'msg'=>  'Đã thêm thành công',
                    listAll()
                ];
            
            } catch (PDOException $e) {
                 
                $dataRes =[
                    'status'=>0,
                    'msg'=> 'Lỗi '. $e->getMessage()
                ];
            }
        }

        die(json_encode ($dataRes ));
}

function get_user_id($id){
    global $objConn;
    try {
        $sql_str = "SELECT * FROM `tb_user` WHERE `id` = '$id' ";
      
        $stmt = $objConn->prepare(  $sql_str );
        // thực thi câu lệnh
        $stmt->execute(); 
        //thiết lập chế độ lấy dữ liệu
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
        // lấy dữ liệu:
        $danh_sach = $stmt->fetchAll();

        $dataRes = [
            'status'=> 1,
            'msg'=> 'Thành công',
            'data'=> $danh_sach
        ];
        
         die(   json_encode($dataRes) );  
         
    } catch (Exception $e) {
         die( 'Lỗi thực hiện truy vấn CSLD ' . $e->getMessage()  );
    }

}



function update_usser($_PUT){
    global $objConn;

   
    $fullname = $_PUT['fullname'];
    $email = $_PUT['email'];
    $passwd = $_PUT['passwd'];
    $id = $_PUT['id'];
    if(empty($passwd)){
        $dataRes =[
            'status'=>0,
            'msg'=> 'Chưa nhập ddur thoong tin'
        ];

    }else{
        // đã nhập full ==> lưu vào CSDL
        try {

            $stmt =  $objConn->prepare(
               "UPDATE `tb_user` SET `passwd`='$passwd',`fullname`='$fullname',`email`='$email' WHERE `id`= $id"
            );
            
      
            $stmt->execute();

            $dataRes =[
                'status'=>1,
                'msg'=>  'sua thannh cong',
                listAll()
            ];
        
        } catch (PDOException $e) {
             
            $dataRes =[
                'status'=>0,
                'msg'=> 'Lỗi '. $e->getMessage()
            ];
        }
    }

    die(json_encode ($dataRes ));
}

function deleteUser($_DELETE)
{
    global $objConn;

    $id = $_DELETE['id'];
    if (empty($id)) {
        $dataRes = [
            'status' => 0,
            'msg' => 'Chưa nhập id user'
        ];

    } else {
        // đã nhập tên loại rồi ==> lưu vào CSDL
        try {

            $stmt = $objConn->prepare(
                "DELETE FROM `tb_user` WHERE id = '$id'"
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
if( $method == 'GET'){
    if(empty($_GET['id'])) 
        listAll(); 
}


if($method == 'GET'){
    get_user_id($_GET['id']);
}


if ($method == 'PUT') {
    parse_str(file_get_contents('php://input'), $_PUT);
    update_usser($_PUT);
    
}

if ($method == 'DELETE') {
    parse_str(file_get_contents('php://input'), $_DELETE);
    deleteUser($_DELETE);
   
}
if ($method == 'POST') { // đã là post thì chỉ thêm mới, muốn sửa thì dùng PUT
    parse_str(file_get_contents('php://input'), $_POST);
    adduser();
   
}

