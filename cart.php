<?php

session_start();
include('connection.php');

if(isset($_POST['remove'])){
    if($_GET['action']=='remove'){
        foreach($_SESSION['cart']as $key=>$value){
            if($value['MSHH']==$_GET['id']){
                unset($_SESSION['cart'][$key]);
                echo"<script>alert(`Đã bỏ hàng khỏi giỏ`)</script>";
                echo"<script>window.location='cart.php' </script>";
            }
        }
    }
}

if(isset($_POST['checkout'])){
    $so_luong_sp=$_POST['check_out_items'];
    $HoTenKH = trim($_POST['HoTenKH']);
    $TenCongTy = trim($_POST['TenCongTy']);
    $SoDienThoai = trim($_POST['SoDienThoai']);
    $SoFax = trim($_POST['SoFax']);
    $DiaChi = trim($_POST['DiaChi']);
    $query_khachhang = "INSERT INTO `khachhang` (`HoTenKH`, `TenCongTy`, `SoDienThoai`, `SoFax`) VALUES ('$HoTenKH', '$TenCongTy', '$SoDienThoai', '$SoFax');";
    $result_khachhang=mysqli_query($connect,$query_khachhang);
    $query_get_mskh = "SELECT MAX(MSKH) AS max_mskh FROM khachhang;";
    $result_get_mskh=mysqli_query($connect,$query_get_mskh);
    $row = mysqli_fetch_row($result_get_mskh);
    $max_mskh = $row[0];
    $query_diachi = "INSERT INTO `diachikh` (`MaDC`, `DiaChi`, `MSKH`) VALUES (NULL, '$DiaChi', '$max_mskh');";
    $result_diachi=mysqli_query($connect,$query_diachi);
    $query_dathang = "INSERT INTO `dathang` (`MSKH`, `MSNV`) VALUES ('$max_mskh', '1');";
    $result_diachi=mysqli_query($connect,$query_dathang);
    $query_get_sddh = "SELECT MAX(SoDonDH) AS max_sddh FROM dathang;";
    $result_get_sddh=mysqli_query($connect,$query_get_sddh);
    $row = mysqli_fetch_row($result_get_sddh);
    $max_sddh = $row[0];
    
    for($i=0;$i<$so_luong_sp;$i++)
    {   
        $id_sp = $_POST["id_$i"];
        $sl_sp = $_POST["quantity_$i"];
        $tong_sp = $_POST["total_$i"];
        $query="INSERT INTO `chitietdathang` (`SoDonDH`,`MSHH`,`SoLuong`,`GiaDatHang`,`GiamGia`)
        VALUES ('$max_sddh','$id_sp','$sl_sp','$tong_sp','0');";
        $statement = mysqli_query($connect,$query);
    }
    session_destroy();
    echo"<script>window.location='endpoint.php' </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
      <?php include 'css/cart.css'; ?>
    </style>
    <title>VINZ - GIỎ HÀNG</title>
</head>
<body>
    <?php include 'login.php'; ?>
    <div class="cart_container">
        <div class="label_area">
            <h1>GIỎ HÀNG</h1>
        </div>
        <div class="detail_area">
            <table>
                <tr class="table_label">
                    <th class="delete_column"></th>
                    <th class="img_column"></th>
                    <th class="name_column" style='color:#342828'>Sản phẩm</th>
                    <th class="price_column" style='color:#342828'>Giá</th>
                    <th class="quantity_column" style='color:#342828'>Số lượng</th>
                    <th class="total_column" style='color:#342828'>Tổng tiền</th>
                </tr>
                <?php
                
                if(isset($_SESSION['cart']))
                {
                $query = 'SELECT hanghoa.MSHH, hanghoa.TenHH,hanghoa.Gia,loaihanghoa.TenLoaiHang,hinhhanghoa.TenHinh    
                FROM hanghoa 
                JOIN loaihanghoa ON hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang
                JOIN hinhhanghoa  ON hinhhanghoa.MSHH = hanghoa.MSHH
                WHERE SoLuongHang > "0"
                ORDER BY tenHH ASC' ;
                $product_id=array_column($_SESSION['cart'],'MSHH');
                $total=0;
                $result = mysqli_query($connect,$query);
                mysqli_fetch_all($result,MYSQLI_ASSOC);
                $rowcount=mysqli_num_rows($result);
                foreach($result as $row) {
                    foreach($product_id as $id){
                        if($row['MSHH'] == $id){
                            ?>
                            <form action="cart.php?action=remove&id=<?php echo $row['MSHH']; ?>" method="post" class="item">
                            <input type="hidden" class="cart_product_id" value="<?php echo $row['MSHH']; ?>">  
                            <input type="hidden" class="cart_product_price" value="<?php echo $row['Gia']; ?>">  
                            <tr>
                                <td class="delete_column"><button type="submit" name='remove' class='item_remove'><i class="fas fa-times"></i></button></td>
                                <td class="img_column"><a href="./product.php?id=<?php echo $row['MSHH']; ?>" target="_blank"><img src="img/<?php echo $row['TenHinh']; ?>" alt="" class="item_img"></a></td>
                                <td class="name_column"><a href="./product.php?id=<?php echo $row['MSHH']; ?> " target="_blank" class="item_name"><?php echo $row['TenHH']; ?></a></td>
                                <td class="price_column"><p class="item_price"><?php echo $row['Gia']; ?> VNĐ</p></td>
                                <td class="quantity_column"><input type="number" class='item_quantity' name='quantity' value='1' ></td>
                                <td class="total_column"><input type="text" class='item_total' value="" disabled></td>
                            </tr>   
                            </form>
                        <?php 
                        $total = $total + (int)$row['Gia'];
                        }
                    }
                }
                }

                ?> 
            </table>
        </div>
        <div class="bill_area">
            <form action="cart.php" id='hoa_don' method="POST" class="bill_form">
                <?php
                 if(isset($_SESSION['cart']))
                 {
                    $i = 0;
                    foreach($result as $row) {
                        foreach($product_id as $id){
                            if($row['MSHH'] == $id){
                                ?>
                                <input type="hidden" class="check_out_quantity" id="cart_item" name="id_<?php echo $i; ?>" value="<?php echo $row['MSHH']; ?>"> 
                                <input type="hidden" class="check_out_quantity" id="" name="quantity_<?php echo $i; ?>" value="1">          
                                <input type="hidden" class="check_out_price" id="" name="price_<?php echo $i; ?>" value="<?php echo $row['Gia']; ?>">       
                                <input type="hidden" class="check_out_total" id="" name="total_<?php echo $i; ?>" value="<?php echo $row['Gia']; ?>">            
                            <?php 
                            $i++;
                            }
                        }
                    }
                }
                ?>
                <input type="hidden" name="check_out_items" id="check_out_items" value="">
                
                <div class="user_info_side">
                    <h2>Thông tin khách hàng</h2>
                    <label for="HoTenKH">Họ và tên <span>*</span></label> <input type="text" name="HoTenKH" require placeholder="VD: Trần Hữu Trí">
                    <label for="TenCongTy">Tên công ty</label> <input type="text" name="TenCongTy"  placeholder="VD: Công ty của Lâm">
                    <label for="SoDienThoai">Số điện thoại <span>*</span></label> <input type="text"  name="SoDienThoai" require placeholder="VD: 0123 456 789">
                    <label for="SoFax">Số fax</label> <input type="text" name="SoFax" placeholder="VD: 0123 456 789">
                    <label for="DiaChi">Địa chỉ <span>*</span></label> <input type="text" name="DiaChi" require placeholder="VD: Nhà bạn Vũ">
                </div>
                <div class="payment_side">
                    <h2>Tổng hóa đơn</h2>
                  
                    <label for="total_cost" class="total_cost_label" id="first_total_label"><b>Tổng tiền</b><input type="text" name='total_cost' class="total_output" id="total_cost" value="" disabled></label> 
                    <label for="discount" class="total_cost_label"><b>Giảm giá</b><input type="text" name='discount' class="total_output" id="" value="0" disabled></label> 
                    <input type="submit" name="checkout" id="check_out_btn" value="Thanh toán" class="check_out_button" >
                    
                </div>
            </form> 
        </div>
        <div class="empty_cart none" id="empty_alert">
            <p class=" empty_cart_text" >Giỏ hàng của bạn đang rỗng.</p>
        </div>
        <div class="empty_cart_buttons none" id="empty_alert_buttons">
            <a href="index.php"  class="check_out_button">Trang chủ</a>
            <a href="shop.php"  class="check_out_button">Cửa hàng</a>   
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script>
        let itemQuantityList = [];

        function updateProductList(){
            let itemList = document.getElementsByClassName("cart_product_id");
            let itemQuantity = document.getElementsByClassName("check_out_quantity");
            let itemPrice = document.getElementsByClassName("check_out_price");
            let itemTotal = document.getElementsByClassName("check_out_total");
            let itemQuantityField = document.getElementsByClassName("item_quantity");
            document.getElementById("check_out_items").value = itemList.length;
            for(let i = 0; i<itemList.length;i++){
                itemQuantityField[i].addEventListener("change",()=>{
                    itemQuantity[i].value = itemQuantityField[i].value;
                    itemTotal[i].value = itemQuantity[i].value*itemPrice[i].value;
                });
            }    
        }

        function getItemQuantity(){
            itemList = document.getElementsByClassName("cart_product_id");
            if(getItemQuantity.length===0){
                for(let i = 0; i<itemList.length;i++){
                    itemQuantityList.push(1);
                }
            }
        }

        function quantityUpdate(){
            let itemList = document.getElementsByClassName("cart_product_id");
            let itemQuantity = document.getElementsByClassName("item_quantity");
            for(let i = 0; i<itemList.length;i++){
                itemQuantity[i].addEventListener('change', () => {
                    itemQuantityList[i]=parseInt(itemQuantity[i].value);
                    billTotal();
                    itemTotal();
                });
            }
        }

        function billTotal(){
            let itemList = document.getElementsByClassName("cart_product_id");
            let itemPrices = document.getElementsByClassName("cart_product_price");
            let billTotal=0;
            for(let i = 0; i<itemList.length;i++){
                billTotal += parseInt(itemPrices[i].value) *  itemQuantityList[i];
            }
            document.getElementById("total_cost").value = billTotal;
        }

        function itemTotal(){
            let itemList = document.getElementsByClassName("cart_product_id");
            let itemPrices = document.getElementsByClassName("cart_product_price");
            let itemTotal = document.getElementsByClassName("item_total");
            for(let i = 0; i<itemList.length;i++){
                itemTotal[i].value = parseInt(itemPrices[i].value) *  itemQuantityList[i];
            }

        }

        function phoneValidation(number){
            return /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/.test(number);
        }

        function numberCheck(text){
            return /^[0-9]*$/.test(text);
        }

        function textCheck(text){
            let check =/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
            return check.test(text);
        }

        function checkCart(){
            let cart_item = document.getElementById("check_out_items").value;
            console.log(cart_item)
            if(cart_item==0){
                document.getElementsByClassName('detail_area')[0].classList.add("none");
                console.log(document.getElementsByClassName('detail_area')[0])
                document.getElementsByClassName('bill_area')[0].classList.add("none");
                document.getElementById('empty_alert').classList.remove("none");
                document.getElementById('empty_alert_buttons').classList.remove("none");
            }
        }
        

        function formValidation(){
            let ho_ten = document.querySelector('input[name="HoTenKH"]').value;
            let sdt = document.querySelector('input[name="SoDienThoai"]').value;
            let dia_chi = document.querySelector('input[name="DiaChi"]').value;
            let cart_item = document.getElementById("check_out_items").value;
            let error ="";
            if(dia_chi.length<=0||dia_chi.length>100){
                error="Vui lòng điền địa chỉ hợp lệ";
            }
            if(sdt.length<=0){
                error="Vui lòng điền số điện thoại";
            }
            else if(phoneValidation(sdt)===false||(sdt.length>25)){
                error="Vui lòng điền số điện thoại hợp lệ";
            }
            if(ho_ten.length<=0){
                error="Vui lòng điền họ tên";
            }
            if(error!=""){
                alert(error);
                return false;
            }
        }
        

       getItemQuantity();
       billTotal();
       itemTotal();
       updateProductList()
       quantityUpdate();
       checkCart();
       document.getElementById('hoa_don').onsubmit = function() {
            return formValidation();
        };
       
    </script>
</body>
</html>