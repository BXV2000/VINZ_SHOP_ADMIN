<?php

session_start();
include('connection.php');

$query_order = "SELECT * FROM dathang WHERE SoDonDH =(SELECT MAX(SoDonDH) FROM dathang)";
$result_order = mysqli_query($connect,$query_order);
$order=mysqli_fetch_assoc($result_order);
$query_detail = "SELECT *
                 FROM chitietdathang 
                 JOIN hanghoa ON chitietdathang.MSHH=hanghoa.MSHH
                 WHERE SoDonDH =(SELECT MAX(SoDonDH) FROM dathang)";
$result_detail = mysqli_query($connect,$query_detail);
mysqli_fetch_all($result_detail,MYSQLI_ASSOC);
$rowcount=mysqli_num_rows($result_detail);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
      <?php include 'css/endpoint.css'; ?>
    </style>
    <title>VINZ - THANH TOÁN</title>
</head>
<body>
    <?php include 'login.php'; ?>
    <div class="endpoint_container">
        <div class="label_area">
            <h1 class="label_area_text">THANH TOÁN</h1>
        </div>
        <div class="order_area">
            <h3 class="order_area_text">Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được tiếp nhận.</h3>
            <table>
                <tr class="table_label">
                    <th class="name_column" style='color:#342828'>Mã đặt hàng</th>
                    <th class="price_column" style='color:#342828'>Ngày đặt hàng</th>
                    <th class="quantity_column" style='color:#342828'>Ngày giao hàng dự kiến</th>
                    <th class="total_column" style='color:#342828'>Tổng tiền</th>
                </tr>
                <tr >
                    <td class="name_column" style='color:#342828'><?php echo $order['SoDonDH']; ?></td>
                    <td class="price_column" style='color:#342828'><?php echo $order['NgayDH']; ?></td>
                    <td class="quantity_column" style='color:#342828'><?php echo $order['NgayGH']; ?></td>
                    <td class="total_column" id="order_total" style='color:#342828'></td>
                </tr>
            </table>
        </div>
        <div class="order_detail_area">
            <h2>Chi tiết đơn hàng</h2>
        <table>
                <tr class="table_label">
                    <th class="name_column" style='color:#342828'>Sản phẩm</th>
                    <th class="total_column"  style='color:#342828'>Tổng tiền</th>
                </tr>
                <?php
                    if($rowcount > 0)
	                {
		                foreach($result_detail as $row)
		                {
                        ?>
                            <tr class="table_label">
                                <td class="name_column" style='color:#342828'><?php echo $row['TenHH']; ?> x <?php echo $row['SoLuong']; ?></td>
                                <td class="total_column pay_item" style='color:#342828'><?php echo $row['GiaDatHang']; ?> VNĐ</td>
                            </tr>
                        <?php
                        }
                    }
                    else
                    {
                        echo '<h3>No data found</h3>';
                    }?>
                <tr class="table_label">
                    <td class="name_column"  style='color:#342828'>Tổng giá sản phẩm:</td>
                    <td class="total_column" id="sub_total" style='color:#342828'> VNĐ</td>
                </tr>
                <tr class="table_label">
                    <td class="name_column"  style='color:#FE2F41;'>Tổng cộng:</td>
                    <td class="total_column" id ="total" style='color:#FE2F41;'>VNĐ</td>
                </tr>
        </table>
        </div>
        <div class="button_area">
                    <a href="index.php" class="basic_button">Trang chủ</a>
                    <a href="shop.php" class="basic_button">Cửa hàng</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        function getTotal(){
            let pay_item = document.getElementsByClassName("pay_item");
            let total="0";
            for (let i =0;i<pay_item.length;i++){
                total+='+'+(pay_item[i].innerHTML).replace("VNĐ","").replace(" ","");
            }
            document.getElementById("sub_total").innerHTML=eval(total)+" VNĐ";
            document.getElementById("total").innerHTML=eval(total)+" VNĐ";
            document.getElementById("order_total").innerHTML=eval(total)+" VNĐ";
        }

        getTotal();
    </script>
</body>
</html>