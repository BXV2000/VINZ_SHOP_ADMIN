<?php

session_start();
include('connection.php');
 
if(isset($_POST['add'])){
  
    if(isset($_SESSION['cart'])){
      $item_array_id=array_column($_SESSION['cart'],'MSHH');
  
      if(in_array($_POST['id'],$item_array_id)){
          echo"<script>alert(`Hàng đã nằm trong giỏ`)</script>";
          echo"<script>window.location='shop.php' </script>";
      }else{
        $count = count($_SESSION['cart']);
        $item_array=array(
          'MSHH'=>$_POST['id']
        );
        $_SESSION['cart'][$count] = $item_array;
      }
    }
    else
    {
      $item_array=array(
        'MSHH'=>$_POST['id']
      );
      $_SESSION['cart'][0]=$item_array;

    }
}







?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    <?php include 'css/auto_shop.css'; ?>
    </style>
    <title>VINZ - CƯA HÀNG</title>
</head>
<body>
    <?php include 'login.php'; ?>
    <div class="shop_container">
        <div class="label_area">
            <h1>CỬA HÀNG TỰ ĐỘNG</h1>
        </div>
        <div class="shop_area">
            <div class="product_area">
                
                <form action="auto_shop.php" class="criteria_section" id="smart_form" method="GET">
                <select name="smart_category" id="smart_category" class="criteria_category">
                <option value="0">Chọn danh mục</option>
                    <?php
                        $query_sorting = 'SELECT * from loaihanghoa ORDER BY TenLoaiHang ASC' ;
                        $result_sorting = mysqli_query($connect,$query_sorting);
                        mysqli_fetch_all($result_sorting,MYSQLI_ASSOC);
                        $row_sorting_count=mysqli_num_rows($result_sorting);
                        if($row_sorting_count > 0){
                            foreach($result_sorting as $row_sorting){?>
                                <option value="<?php echo $row_sorting['MaLoaiHang']?>"><?php echo $row_sorting['TenLoaiHang']?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
               
                <input type="number" id="smart_money" name="smart_money" class="criteria_money" placeholder="Số tiền cần nhập" >
                <input type="number" id="smart_spare" name="smart_spare" disabled class="criteria_money" placeholder="Tiền thừa" >
                <input type="submit" name="smart_sort" class="basic_button" id="calculate_btn"value="Tính toán">
                </form>
                
                <div class="products">
                    <?php  
                    if(isset($_GET['smart_sort'])){
                    $category= $_GET['smart_category'];
                    $input_cash=$_GET['smart_money'];   
                    $query = 'SELECT hanghoa.MSHH,hanghoa.DinhDuong, hanghoa.TenHH,hanghoa.Gia,loaihanghoa.TenLoaiHang,hinhhanghoa.TenHinh,hanghoa.MaLoaiHang    
                     FROM hanghoa 
                     JOIN loaihanghoa ON hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang
                     JOIN hinhhanghoa  ON hinhhanghoa.MSHH = hanghoa.MSHH
                     WHERE hanghoa.MaLoaiHang = '.$category.'
                     ORDER BY Gia DESC' ;
                    $result = mysqli_query($connect,$query);
                    mysqli_fetch_all($result,MYSQLI_ASSOC);
                    $rowcount=mysqli_num_rows($result);
                    if($rowcount > 0)
	                {
		                foreach($result as $row)
		                {
                        ?>
                            <form method="post" class="product none" action="./auto_shop.php?smart_category=<?php echo $category?>&smart_money=<?php echo $input_cash?>&smart_sort=Tính+toán">
                                <a href="./product.php?id=<?php echo $row['MSHH']?>"target="_blank"><img src="./img/<?php echo $row['TenHinh']?>"  alt="" class="product_img"></a>
                                <input type="hidden" name="id" value="<?php echo $row['MSHH']?>">
                                <input type="hidden" name="name" value="<?php echo $row['TenHH']?>">
                                <input type="hidden"  name="price" value="<?php echo $row['Gia']?>">
                                <input type="hidden"  name="nutrition" value="<?php echo $row['DinhDuong']?>">
                                <a href="./product.php?id=<?php echo $row['MSHH']?>" class="product_name" target="_blank"><?php echo $row['TenHH']?></a>
                                <a href="./category_shop.php?id=<?php echo $row['MaLoaiHang']?>" class = "product_tag" target="_blank"><?php echo $row['TenLoaiHang']?></a>
                                <h3 class="product_price"><?php echo $row['Gia']?> VNĐ</h3>
                                <input class="product_add" type="submit" name="add" value="Thêm vào giỏ">
                            </form>   
                        <?php
                        }
                    }
                    else
                    {   
                        echo '<h3>No data found</h3>';
                    }
                }
                    ?>
                     <input type="hidden" id="hidden_money" value="<?php echo $input_cash?>">
                </div>
            </div>
            <div class="sidebar">
                <div class="sorting_label">
                    <h2 class="area_label_text">Danh mục sản phẩm</h2>
                </div>
                <div class="sort_categories">
                    <?php
                        $query_sorting = 'SELECT * from loaihanghoa ORDER BY TenLoaiHang ASC' ;
                        $result_sorting = mysqli_query($connect,$query_sorting);
                        mysqli_fetch_all($result_sorting,MYSQLI_ASSOC);
                        $row_sorting_count=mysqli_num_rows($result_sorting);
                        if($row_sorting_count > 0){
                            foreach($result_sorting as $row_sorting){?>
                                <a href="./category_shop.php?id=<?php echo $row_sorting['MaLoaiHang']?>" target="_blank" class="sort_category"><?php echo $row_sorting['TenLoaiHang']?></a>
                            <?php
                            }
                        }

                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        
        function inputValidation(){
            let money = document.getElementById("smart_money").value;
            let category = document.getElementById( "smart_category").value;
            let error="";
            console.log(category);
            if(category==='0'){
                error="Vui lòng chọn danh mục";
            }
            if(money.length<=0){
                error="Vui lòng nhập số tiền";
            }
            if(error!=""){
                alert(error);
                return false;
            }
        }

        function sorting(array){
            for (let i = 0; i < array.length; i++) {
                for (let x = 0; x < array.length - 1 - i; x++) {
                if (array[x][1] > array[x + 1][1]) {
                    [array[x], array[x + 1]] = [array[x + 1], array[x]];
                }
                }
            }
            return array;
        }

        function smartBuy(){
            let tsdd=[];
            let cashInput=document.getElementById("hidden_money").value;
            let itemList= document.getElementsByClassName("product");
            let itemPriceList= document.querySelectorAll('input[name="price"]');
            let itemNutritionList= document.querySelectorAll('input[name="nutrition"]');
                for(let i = 0 ;i<itemList.length;i++){
                    tsdd.push([i,itemNutritionList[i].value/itemPriceList[i].value])
                }
            sorting(tsdd);
                for(let j =0;j<tsdd.length;j++){
                    if(cashInput-itemPriceList[tsdd[j][0]].value>0){
                        itemList[tsdd[j][0]].classList.remove("none");
                        cashInput =cashInput-itemPriceList[tsdd[j][0]].value;
                    }
                }
                document.getElementById("smart_spare").value=cashInput;
        }
        smartBuy()
        document.getElementById("smart_form").onsubmit = function() {
            return inputValidation();
        };
        

    </script>
</body>
</html>