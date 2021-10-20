<?php
include('connection.php');

session_start();
if(isset($_SESSION['username']) && $_SESSION['username']){ 
}
else{
  echo"<script>alert(`Vui lòng đăng nhập`)</script>";
  echo"<script>window.location='login.php'</script>";
}
global $line_number;

if(isset($_POST['add'])){
    $HoTenNV = trim($_POST['HoTenNV']);
    $SoDienThoai = trim($_POST['SoDienThoai']);
    $ChucVu=$_POST['ChucVu'];
    $DiaChi=trim($_POST['DiaChi']);
    $insert_staff="INSERT INTO `nhanvien` (`HoTenNV`,`ChucVu`,`DiaChi`,`SoDienThoai`)
                     VALUES ('$HoTenNV','$ChucVu','$DiaChi','$SoDienThoai');";
    $result_insert_staff=mysqli_query($connect,$insert_staff);
    echo"<script>alert(`Đã thêm nhân viên`)</script>";
    echo"<script>window.location='staff.php' </script>";
}

if(isset($_POST['delete'])){
    $MSNV=$_GET['delete'];
    $remove_staff="DELETE FROM nhanvien WHERE MSNV='$MSNV'";
    $result_remove_staff=mysqli_query($connect,$remove_staff);
    echo"<script>alert(`Đã xóa nhân viên`)</script>";
    echo"<script>window.location='staff.php' </script>";
}

if(isset($_GET['search_staff'])){
    $line_number=$_GET['line_number'];

}



if(isset($_POST['edit'])){
    $MSNV=trim($_POST['edit_hidden_id']);
    $HoTenNV = trim($_POST['HoTenNV_edit']);
    $SoDienThoai = trim($_POST['SoDienThoai_edit']);
    $ChucVu=$_POST['ChucVu_edit'];
    $DiaChi=trim($_POST['DiaChi_edit']);
    $update_staff="UPDATE nhanvien
                    SET HoTenNV = '$HoTenNV', 
                        SoDienThoai= '$SoDienThoai',
                        ChucVu='$ChucVu',
                        DiaChi='$DiaChi'
                    WHERE MSNV = '$MSNV';";
    $result_update_staff = mysqli_query($connect,$update_staff);
    echo"<script>alert(`Đã cập nhật thông tin nhân viên`)</script>";
    echo"<script>window.location='staff.php' </script>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <style>
    <?php include 'css/staff.css'; ?>
    </style>
    <title>VINZ - NHÂN VIÊN</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="products_container">
        <div class="add_new_area  hide" id="add_new_form_wrapper">
            <form action="./staff.php" class="add_new_form" id="add_new_form" method="POST" >
                <h3>Thêm nhân viên</h3>
                <label for="HoTenNV" class="input_fields">Tên nhân viên <input type="text" name="HoTenNV" placeholder="William"></label>
                <label for="SoDienThoai" class="input_fields">Số điện thoại <input type="number" name="SoDienThoai" placeholder="0123243567"></label>
                <label for="ChucVu" class="input_fields">Chức vụ
                    <select name="ChucVu" id="select_staff_grade" class="">
                        <option value="0">Chọn chức vụ</option>
                        <option value="Quản lí">Quản lí</option>
                        <option value="Nhân viên tư vấn">Nhân viên tư vấn</option>
                        <option value="Nhân viên giao hàng">Nhân viên giao hàng</option>
                        <option value="Tập sự">Tập sự</option>
                    </select>
                </label>
                <label for="DiaChi" class="input_fields">Địa chỉ <textarea name="DiaChi" id="" cols="20" rows="3" placeholder="Khá rẻ"></textarea></label>
                <div class="form_btn_wrapper">
                    <button class="btn form_btn" name="add">Thêm</button>
                    <p class="btn form_btn " id="add_new_cancel" >Hủy</p>
                </div>
            </form>
        </div>
        <div class="add_new_area hide " id="edit_form_wrapper">
            <form action="./staff.php" class="add_new_form" id="edit_form" method="POST"  >
                <h3>Thông tin nhân viên</h3>
                <input type="hidden" id="edit_hidden_id" name="edit_hidden_id" value="">
                <input type="hidden" id="edit_hidden_name" value="">
                <label for="HoTenNV_edit" class="input_fields">Tên nhân viên <input type="text" name="HoTenNV_edit" id="HoTenNV_edit" placeholder="William"></label>
                <label for="SoDienThoai_edit" class="input_fields">Số điện thoại <input type="number" name="SoDienThoai_edit" id="SoDienThoai_edit" placeholder="0123243567"></label>
                <label for="ChucVu_edit" class="input_fields">Chức vụ
                    <select name="ChucVu_edit" id="ChucVu_edit" class="">
                        <option value="0">Chọn chức vụ</option>
                        <option value="Quản lí">Quản lí</option>
                        <option value="Nhân viên tư vấn">Nhân viên tư vấn</option>
                        <option value="Nhân viên giao hàng">Nhân viên giao hàng</option>
                        <option value="Tập sự">Tập sự</option>
                    </select>
                </label>
                <label for="DiaChi_edit" class="input_fields">Địa chỉ <textarea name="DiaChi_edit" id="DiaChi_edit" cols="20" rows="3" placeholder="Khá rẻ"></textarea></label>
                <div class="form_btn_wrapper">
                    <button class="btn form_btn" name="edit">Cập nhật</button>
                    <p class="btn form_btn " id="edit_cancel" >Hủy</p>
                </div>
            </form>
        </div>
        <div class="label_area">
            <div class="page_name">
                <p><span><i class="fas fa-bars"></i></span> Nhân viên</p>
            </div>
            <div class="greeting"></div>
        </div>
        
        <div class="function_area">
        
            <form action="./staff.php" class="search_form" id="filter_form" method="GET">
            <div class="search_section">
                <label for="line_number" class="line_input_wrapper">Nhập mã nhân viên <input type="number" name="line_number" class="number_input line_number" value=''></label>
                <button class="btn" name="search_staff"id="search_btn">Tìm kiếm</button>
            </div>
                <button class="btn btn_no_default " id="add_product">Thêm nhân viên</button>
            </form>
            
        </div>
        <div class="display_area">
            <table>
                <tr class="table_label">
                    <th class="column center_text">Mã nhân viên</th>
                    <th class="column ">Họ tên nhân viên</th>
                    <th class="column center_text" >Chức vụ</th>
                    <th class="column " >Địa chỉ</th>
                    <th class="column " >Số điện thoại</th>
                    <th class="column" ></th>
                </tr>
                <?php
                $query_line_number="  ";
                if($line_number!='0'&&$line_number!=null){
                    $query_line_number =" WHERE MSNV='$line_number'";
                }
                $query_staff = 'SELECT * FROM nhanvien
                                    '.$query_line_number.'
                                    ORDER BY MSNV ASC 
                                    
                                    ';
                $result_staff = mysqli_query($connect,$query_staff);
                mysqli_fetch_all($result_staff,MYSQLI_ASSOC);
                $row_staff_count=mysqli_num_rows($result_staff);
                if($row_staff_count > 0){
                    foreach($result_staff as $staff)
                    {?>   
                        <tr class="">
                            <td class="column center_text"><?php echo $staff['MSNV']?><input type="hidden" value="<?php echo $staff['MSNV']?>" class="staff_hidden_id"></td>
                            <td class="column staff_name"><?php echo $staff['HoTenNV']?></td>
                            <td class="column staff_grade center_text" ><?php echo $staff['ChucVu']?></td>
                            <td class="column staff_address" ><?php echo $staff['DiaChi']?></td>
                            <td class="column  staff_phone" ><?php echo $staff['SoDienThoai']?></td>
                            <td class="column btn_wrapper" >
                                <form class="action_form" action="./staff.php?edit=<?php echo $staff['MSNV']?>" method="POST" > 
                                    <button class="small_btn edit_btn btn_no_default" name="edit"><i class="fas fa-pen"></i></button>
                                </form>
                                <form class="action_form" action="./staff.php?delete=<?php echo $staff['MSNV']?>" method="POST" onsubmit="return confirm('Bạn có muốn xóa <?php echo $staff['HoTenNV']?>?');">
                                    <button class="small_btn delete_btn" name="delete"><i class="fas fa-times-circle"></i></button>
                                </form>
                                
                            </td>
                        </tr>
                         
                    <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <script src="./js/staff.js"></script>
</body>
</html>