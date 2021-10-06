<?php
include('connection.php');

global $line_number;



if(isset($_POST['delete'])){
    $MSKH=$_GET['delete'];
    $remove_customer="DELETE FROM khachhang WHERE MSKH='$MSKH'";
    $result_remove_customer=mysqli_query($connect,$remove_customer);
    echo"<script>alert(`Đã xóa thông tin khách hàng`)</script>";
    echo"<script>window.location='customer.php' </script>";
}

if(isset($_GET['search_product'])){
    $line_number=$_GET['line_number']; 
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
    <?php include 'css/customer.css'; ?>
    </style>
    <title>VINZ - KHÁCH HÀNG</title>
</head>
<body>
    <?php include 'login.php'; ?>
    <div class="products_container">
        
        <div class="label_area">
            <div class="page_name">
                <p><span><i class="fas fa-bars"></i></span> Khách hàng</p>
            </div>
            <div class="greeting"></div>
        </div>
        
        <div class="function_area">
        
            <form action="./customer.php" class="search_form" id="filter_form" method="GET">
                <label for="line_number" class="line_input_wrapper">Nhập mã khách hàng <input type="number" name="line_number" class="number_input line_number" value=''></label>
                <button class="btn" name="search_product"id="search_btn">Tìm kiếm</button>
            </form>
            
        </div>
        <div class="display_area">
            <table>
                <tr class="table_label">
                    <th class="column center_text">Mã khách hàng</th>
                    <th class="column ">Tên khách hàng</th>
                    <th class="column" >Tên công ty</th>
                    <th class="column " >Số điện thoại</th>
                    <th class="column " >Số fax</th>
                    <th class="column " >Địa chỉ</th>
                    <th class="column" ></th>
                </tr>
                <?php
                $query_line_number=" ";
                if($line_number!='0'&&$line_number!=null){
                    $query_line_number =" WHERE khachhang.MSKH='$line_number'";
                }
                $query_customer = 'SELECT khachhang.MSKH,HoTenKH,TenCongTy,SoDienThoai,SoFax,DiaChi    
                                    FROM khachhang
                                    JOIN diachikh ON khachhang.MSKH = diachikh.MSKH
                                    '.$query_line_number.'
                                    ORDER BY khachhang.MSKH ASC 
                                    ';
                $result_customer = mysqli_query($connect,$query_customer);
                mysqli_fetch_all($result_customer,MYSQLI_ASSOC);
                $row_customer_count=mysqli_num_rows($result_customer);
                if($row_customer_count > 0){
                    foreach($result_customer as $customer)
                    {?>   
                        <tr class="">
                            <td class="column center_text"><?php echo $customer['MSKH']?><input type="hidden" value="<?php echo $customer['MSKH']?>" class="product_hidden_id"></td>
                            <td class="column product_name"><?php echo $customer['HoTenKH']?></td>
                            <td class="column product_note" ><?php echo $customer['TenCongTy']?></td>
                            <td class="column product_price" ><?php echo $customer['SoDienThoai']?></td>
                            <td class="column  product_stock" ><?php echo $customer['SoFax']?></td>
                            <td class="column " ><?php echo $customer['DiaChi']?></td>
                            <td class="column btn_wrapper" >
                                <form class="action_form" action="./customer.php?delete=<?php echo $customer['MSKH']?>" method="POST" onsubmit="return confirm('Bạn có muốn xóa khách hàng <?php echo $customer['HoTenKH']?>?');">
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
    <script src="./js/customer.js"></script>
</body>
</html>