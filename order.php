<?php
include('connection.php');

session_start();
if(isset($_SESSION['username']) && $_SESSION['username']){ 
}
else{
  echo"<script>alert(`Vui lòng đăng nhập`)</script>";
  echo"<script>window.location='login.php' </script>";
}

global $line_number;
global $order_status;
global $sort_by;



if(isset($_POST['delete'])){
    $MSDH=$_GET['delete'];
    $remove_order="DELETE FROM dathang WHERE SoDonDH='$MSDH'";
    $result_remove_order=mysqli_query($connect,$remove_order);
    echo"<script>alert(`Đã xóa đơn hàng`)</script>";
    echo"<script>window.location='order.php' </script>";
}

if(isset($_GET['search_order'])){
    $line_number=$_GET['line_number'];
    $order_status=$_GET['order_status'];
    $sort_by=$_GET['sort_by'];
    
}



if(isset($_POST['edit'])){
    $SoDonDH=$_POST['edit_hidden_id'];
    $MSNV=$_POST['MSNV_edit'];
    $TrangThaiDH=trim($_POST['TrangThaiDH_edit']);
    $update_order="UPDATE dathang
                    SET MSNV = '$MSNV', 
                        TrangThaiDH='$TrangThaiDH'
                    WHERE SoDonDH= '$SoDonDH';";
    $result_update_order = mysqli_query($connect,$update_order);
    echo"<script>alert(`Đã cập nhật đơn hàng`)</script>";
    echo"<script>window.location='order.php' </script>";
    // var_dump($TrangThaiDH);
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
    <?php include 'css/order.css'; ?>
    </style>
    <title>VINZ - ĐƠN HÀNG</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="orders_container">
        <?php
            if(isset($_POST['view'])){
                $view_id = $_GET['view'];
                
        ?> 
        <div class="add_new_area " id="order_detail">
            <div class="add_new_form  detail_area">
            <br>
            <h3 >Chi tiết đơn hàng</h3>
            <p>Mã đơn số:<?php echo $view_id?> </p>
            <br>
            <p class="exit_icon" id="exit_icon"><i class="far fa-times-circle"></i></p>
            <table>
                <tr>
                    <th class="center_text">STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
                <?php
                 $query_detail= "SELECT hanghoa.TenHH,chitietdathang.SoLuong,chitietdathang.GiaDatHang FROM chitietdathang JOIN hanghoa ON chitietdathang.MSHH=hanghoa.MSHH WHERE SoDonDH ='$view_id'";
                 $result_detail= mysqli_query($connect,$query_detail);
                 mysqli_fetch_all($result_detail,MYSQLI_ASSOC);
                 $row_detail_count=mysqli_num_rows($result_detail);
                 if($row_detail_count > 0){
                     $count=1;
                    foreach($result_detail as $detail){
                ?> 
                <tr>
                    <td class="center_text h3" ><?php echo $count?></td>
                    <td><?php echo $detail['TenHH']?></td>
                    <td class="center_text"><?php echo $detail['SoLuong']?></td>
                    <td class="center_text detail_sub_total"><?php echo $detail['GiaDatHang']?></td>
                </tr>
                <?php
                    $count++;}
                }
                ?>
                <tr >
                    <th colspan="3">Tổng tiền</th>
                    <th id="detail_total"></th>
                </tr>
            </table>
            </div>
        </div>
        <?php
            }
        ?>
        <div class="add_new_area hide " id="edit_form_wrapper">
            <form action="./order.php" class="add_new_form" id="edit_form" method="POST" onsubmit="" >
                <h3>Cập nhật đơn hàng</h3>
                <label for="SoDonDH_edit" class="input_fields">Mã đơn hàng <input type="text" id="SoDonDH_edit" name="SoDonDH_edit" value=""disabled ></label>
                <input type="hidden"  id="edit_hidden_id" name="edit_hidden_id" value="">
                <label for="MSNV_edit" class="input_fields">Nhân viên
                    <select name="MSNV_edit" id="edit_emp" class="">
                            <?php
                                $query_emp = 'SELECT * from nhanvien ORDER BY MSNV ASC' ;
                                $result_emp = mysqli_query($connect,$query_emp);
                                mysqli_fetch_all($result_emp,MYSQLI_ASSOC);
                                $row_sorting_count=mysqli_num_rows($result_emp);
                                if($row_sorting_count > 0){
                                    foreach($result_emp as $emp){?>
                                        <option value="<?php echo $emp['MSNV']?>"><?php echo $emp['HoTenNV']?> - <?php echo $emp['MSNV']?></option>
                                    <?php
                                    }
                                }
                            ?>
                    </select>
                </label>
                <label for="TrangThaiDH_edit" class="input_fields">Tình trạng đơn hàng
                    <select name="TrangThaiDH_edit" id="order_state" class="">
                        <option value="1">Đang chờ</option>
                        <option value="2">Đã giao</option> 
                        <option value="3">Đã hủy</option> 
                    </select>
                </label>
                <div class="form_btn_wrapper">
                    <button class="btn form_btn" name="edit">Cập nhật</button>
                    <p class="btn form_btn " id="edit_cancel" >Hủy</p>
                </div>
            </form>
        </div>
        <div class="label_area">
            <div class="page_name">
                <p><span><i class="fas fa-bars"></i></span> Đơn hàng</p>
            </div>
            <div class="greeting"></div>
        </div>
        
        <div class="function_area">
        
            <form action="./order.php" class="search_form" id="filter_form" method="GET">
       
            <label for="line_number" class="line_input_wrapper">Nhập số dòng:<input type="number" name="line_number" class="number_input line_number" value='10'></label>
                <select name="sort_by" id="" class="curl_select">
                    <option value="0">Chọn cách lọc</option>
                    <option value="SoDonDH">Đơn hàng</option>
                    <option value="MSKH">Mã số khách hàng</option> 
                    <option value="MSNV">Mã số nhân viên</option>   
                    <option value="NgayDH">Ngày đặt hàng</option>   
                    <option value="NgayGH">Ngày giao hàng</option> 
                </select>
                <select name="order_status" id="" class="curl_select">
                    <option value="0">Chọn tình trạng</option>
                    <option value="1">Đang chờ</option>
                    <option value="2">Đã giao</option> 
                    <option value="3">Đã hủy</option>   
                </select>
                <button class="btn" name="search_order"id="search_btn">Tìm kiếm</button>
            </form>
            
        </div>
        <div class="display_area">
            <table>
                <tr class="table_label">
                    <th class="column center_text">Mã đơn hàng</th>
                    <th class="column center_text">Mã khách hàng</th>
                    <th class="column center_text ">Mã nhân viên</th>
                    <th class="column" >Ngày đặt hàng</th>
                    <th class="column " >Ngày giao hàng</th>
                    <th class="column center_text" >Tình trạng đơn hàng</th>
                    <th class="column" ></th>
                </tr>
                <?php
                $query_order_status=" ";
                $query_line_number=" LIMIT 10; ";
                $query_sort_by = " ";
                if($order_status!='0'&&$order_status!=null){
                    $query_order_status =" WHERE TrangThaiDH='$order_status'";
                }
                if($line_number!='0'&&$line_number!=null){
                    $query_line_number =" LIMIT $line_number;";
                }
                if($sort_by!='0'&&$sort_by!=null){
                    $query_sort_by =" ORDER BY $sort_by ASC";
                }
                $query_product = 'SELECT * FROM dathang 
                                    '.$query_order_status.'
                                    '.$query_sort_by.'
                                    '.$query_line_number.'
                                    ';
                $result_product = mysqli_query($connect,$query_product);
                mysqli_fetch_all($result_product,MYSQLI_ASSOC);
                $row_product_count=mysqli_num_rows($result_product);
                if($row_product_count > 0){
                    foreach($result_product as $product)
                    {?>   
                        <tr class="">
                            <input type="hidden" value="<?php echo $product['TrangThaiDH']?>" class="order_hidden_state">
                            <input type="hidden" value="<?php echo $product['MSNV']?>" class="order_hidden_emp">
                            <td class="column center_text"><?php echo $product['SoDonDH']?><input type="hidden" value="<?php echo $product['SoDonDH']?>" class="order_hidden_id"></td>
                            <td class="column center_text"><?php echo $product['MSKH']?></td>
                            <td class="column center_text order_emp"><?php echo $product['MSNV']?></td>
                            <td class="column " ><?php echo $product['NgayDH']?></td>
                            <td class="column " ><?php echo $product['NgayGH']?> </td>
                            <td class="column center_text order_state" ><?php echo $product['TrangThaiDH']?></td>
                            <td class="column btn_wrapper" >
                                <form class="action_form" action="./order.php?view=<?php echo $product['SoDonDH']?>" method="POST"  > 
                                    <button class="small_btn view_btn" name="view"><i class="fas fa-sticky-note"></i></button>
                                </form>
                                <form class="action_form" action="./order.php?edit=<?php echo $product['SoDonDH']?>" method="POST" > 
                                    <button class="small_btn edit_btn btn_no_default" name="edit"><i class="fas fa-pen"></i></button>
                                </form>
                                <form class="action_form" action="./order.php?delete=<?php echo $product['SoDonDH']?>" method="POST" onsubmit="return confirm('Bạn có muốn xóa <?php echo $product['SoDonDH']?>?');">
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
    <script src="./js/order.js"></script>
    <script>
        if(document.getElementById("exit_icon")){
        document.getElementById("exit_icon").addEventListener("click",function(e){
            document.getElementById("order_detail").classList.add("hide");
        })
        
    
        function calDetailTotal(){
            let sub_totals=document.getElementsByClassName('detail_sub_total');
            let total=document.getElementById('detail_total');
            let cal=0;
            for(let i =0;i<sub_totals.length;i++){
                cal+=parseInt(sub_totals[i].innerHTML);
            }
            total.innerHTML=cal +" VNĐ";
        }
        calDetailTotal()
        }
    </script>
</body>
</html>