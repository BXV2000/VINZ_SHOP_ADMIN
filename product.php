<?php
include('connection.php');

global $line_number;
global $product_type;

if(isset($_POST['add'])){
    $TenHH = trim($_POST['TenHH']);
    $Gia = trim($_POST['Gia']);
    $SoLuongHang = trim($_POST['SoLuongHang']);
    $TenHinh=$_POST['TenHinh'];
    $MaLoaiHang=$_POST['TenLoaiHang'];
    $QuyCach=trim($_POST['QuyCach']);
    $insert_hanghoa="INSERT INTO `hanghoa` (`TenHH`,`QuyCach`,`Gia`,`SoLuongHang`,`MaLoaiHang`)
                     VALUES ('$TenHH','$QuyCach','$Gia','$SoLuongHang','$MaLoaiHang');";
    $result_insert_hanghoa=mysqli_query($connect,$insert_hanghoa);
    $query_get_mshh = "SELECT MAX(MSHH) AS max_msHh FROM hanghoa;";
    $result_get_mshh=mysqli_query($connect,$query_get_mshh);
    $row = mysqli_fetch_row($result_get_mshh);
    $max_mshh = $row[0];
    $insert_hinhhanghoa="INSERT INTO `hinhhanghoa` (`TenHinh`,`MSHH`)
                     VALUES ('$TenHinh','$max_mshh');";
    $result_insert_hanghoa=mysqli_query($connect,$insert_hinhhanghoa);
    echo"<script>alert(`Đã thêm hàng hóa`)</script>";
    echo"<script>window.location='product.php' </script>";
}

if(isset($_POST['delete'])){
    $MSHH=$_GET['delete'];
    $remove_product="DELETE FROM hanghoa WHERE MSHH='$MSHH'";
    $result_remove_product=mysqli_query($connect,$remove_product);
    echo"<script>alert(`Đã xóa hàng hóa`)</script>";
    echo"<script>window.location='product.php' </script>";
}

if(isset($_GET['search_product'])){
    $line_number=$_GET['line_number'];
    $product_type=$_GET['product_type'];
    
}

if(isset($_POST['add_category'])){
    $tenLoaiHang=trim($_POST['ThemTenLoaiHang']);
    $add_product_type="INSERT INTO `loaihanghoa` (`TenLoaiHang`) VALUES ('$tenLoaiHang');";
    $result_add_product_type=mysqli_query($connect,$add_product_type);
    echo"<script>alert(`Đã thêm danh mục`)</script>";
    echo"<script>window.location='product.php' </script>";
}

if(isset($_POST['edit'])){
    $MSHH=trim($_POST['edit_hidden_id']);
    $TenHH = trim($_POST['TenHH_edit']);
    $Gia = trim($_POST['Gia_edit']);
    $SoLuongHang = trim($_POST['SoLuongHang_edit']);
    $TenHinh=$_POST['TenHinh_edit'];
    $MaLoaiHang=$_POST['TenLoaiHang_edit'];
    $QuyCach=trim($_POST['QuyCach_edit']);
    if($TenHinh!=""){
        $update_product_img="UPDATE hinhhanghoa SET TenHinh='$TenHinh' WHERE MSHH='$MSHH'";
        $result_img = mysqli_query($connect,$update_product_img);
    }
    $update_product="UPDATE hanghoa
                    SET TenHH = '$TenHH', 
                        Gia= '$Gia',
                        QuyCach='$QuyCach',
                        SoLuongHang='$SoLuongHang',
                        MaLoaiHang='$MaLoaiHang'
                    WHERE MSHH = '$MSHH';";
    $result_update_product = mysqli_query($connect,$update_product);
    echo"<script>alert(`Đã sửa sản phẩm`)</script>";
    echo"<script>window.location='product.php' </script>";
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
    <?php include 'css/product.css'; ?>
    </style>
    <title>VINZ - SẢN PHẨM</title>
</head>
<body>
    <?php include 'login.php'; ?>
    <div class="products_container">
        <div class="add_new_area  hide" id="add_new_form_wrapper">
            <form action="./product.php" class="add_new_form" id="add_new_form" method="POST" >
                <h3>Thêm hàng hóa</h3>
                <label for="TenHH" class="input_fields">Tên hàng hóa <input type="text" name="TenHH" placeholder="Mì gói"></label>
                <label for="Gia" class="input_fields">Giá hàng hóa <input type="number" name="Gia" placeholder="2000"></label>
                <label for="SoLuongHang" class="input_fields">Số lượng <input type="number" name="SoLuongHang" placeholder="10"></label>
                <label for="TenLoaiHang" class="input_fields">Danh mục
                    <select name="TenLoaiHang" id="select_category" class="">
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
                </label>
                <label for="QuyCach" class="input_fields">Quy cách <textarea name="QuyCach" id="" cols="20" rows="3" placeholder="Khá rẻ"></textarea></label>
                <label for="TenHinh" class="input_fields">Hình ảnh <input class="upload" type="file" name="TenHinh"></label>
                <div class="form_btn_wrapper">
                    <button class="btn form_btn" name="add">Thêm</button>
                    <p class="btn form_btn " id="add_new_cancel" >Hủy</p>
                </div>
            </form>
        </div>
        <div class="add_new_area hide " id="edit_form_wrapper">
            <form action="./product.php" class="add_new_form" id="edit_form" method="POST" onsubmit="return confirm(`Bạn có muốn sửa ${document.getElementById('edit_hidden_name').value} ?`);" >
                <h3>Sửa hàng hóa</h3>
                <input type="hidden" id="edit_hidden_id" name="edit_hidden_id" value="">
                <input type="hidden" id="edit_hidden_name" value="">
                <label for="TenHH_edit" class="input_fields">Tên hàng hóa <input type="text" id="TenHH_edit" name="TenHH_edit"></label>
                <label for="Gia_edit" class="input_fields">Giá hàng hóa <input type="number" id ="Gia_edit" name="Gia_edit"></label>
                <label for="SoLuongHang_edit" class="input_fields">Số lượng <input type="number" id="SoLuongHang_edit" name="SoLuongHang_edit"></label>
                <label for="TenLoaiHang_edit" class="input_fields">Danh mục
                    <select name="TenLoaiHang_edit" id="select_edit_category" class="">
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
                </label>
                <label for="QuyCach_edit" id="" class="input_fields">Quy cách <textarea name="QuyCach_edit" id="QuyCach_edit" cols="20" rows="3"></textarea></label>
                <label for="TenHinh_edit" class="input_fields">Hình ảnh <input class="upload" type="file" name="TenHinh_edit"></label>
                <div class="form_btn_wrapper">
                    <button class="btn form_btn" name="edit">Sửa</button>
                    <p class="btn form_btn " id="edit_cancel" >Hủy</p>
                </div>
            </form>
        </div>
        <div class="add_new_area hide" id="add_new_category_wrapper">
            <form action="./product.php" class="add_new_form category_form" id="add_new_category_form" method="POST">
                <h3>Thêm danh mục hàng hóa</h3>
                <label for="ThemTenLoaiHang" class="input_fields">Tên danh mục <input type="text" name="ThemTenLoaiHang"placeholder="Sản phẩm dùng ngay"></label>
                <div class="form_btn_wrapper">
                    <button class="btn form_btn" name="add_category">Thêm</button>
                    <p class="btn form_btn " id="add_new_category_cancel" >Hủy</p>
                </div>
            </form>
        </div>
        <div class="label_area">
            <div class="page_name">
                <p><span><i class="fas fa-bars"></i></span> Sản phẩm</p>
            </div>
            <div class="greeting"></div>
        </div>
        
        <div class="function_area">
        
            <form action="./product.php" class="search_form" id="filter_form" method="GET">
                <label for="line_number" class="line_input_wrapper">Nhập số dòng:<input type="number" name="line_number" class="number_input line_number" value='10'></label>
                <select name="product_type" id="" class="curl_select">
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
                <button class="btn" name="search_product"id="search_btn">Tìm kiếm</button>
                <button class="btn btn_no_default " id="add_product">Thêm sản phẩm</button>
                <button class="btn btn_no_default " id="add_category">Thêm danh mục</button>
            </form>
            
        </div>
        <div class="display_area">
            <table>
                <tr class="table_label">
                    <th class="column center_text">Mã hàng hóa</th>
                    <th class="column center_text">Hình ảnh</th>
                    <th class="column ">Tên hàng hóa</th>
                    <th class="column" >Quy cách</th>
                    <th class="column " >Giá hàng hóa</th>
                    <th class="column center_text" >Số lượng tồn kho</th>
                    <th class="column " >Loại hàng</th>
                    <th class="column" ></th>
                </tr>
                <?php
                $query_product_type=" ";
                $query_line_number=" LIMIT 10; ";
                if($product_type!='0'&&$product_type!=null){
                    $query_product_type =" WHERE hanghoa.MaLoaiHang='$product_type'";
                }
                if($line_number!='0'&&$line_number!=null){
                    $query_line_number =" LIMIT $line_number;";
                }
                $query_product = 'SELECT hanghoa.MSHH,hanghoa.SoLuongHang,hanghoa.QuyCach, hanghoa.TenHH,hanghoa.Gia,loaihanghoa.TenLoaiHang,hinhhanghoa.TenHinh,hanghoa.MaLoaiHang    
                                    FROM hanghoa 
                                    JOIN loaihanghoa ON hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang
                                    JOIN hinhhanghoa  ON hinhhanghoa.MSHH = hanghoa.MSHH
                                    '.$query_product_type.'
                                    ORDER BY tenHH ASC 
                                    '.$query_line_number.'
                                    ';
                $result_product = mysqli_query($connect,$query_product);
                mysqli_fetch_all($result_product,MYSQLI_ASSOC);
                $row_product_count=mysqli_num_rows($result_product);
                if($row_product_count > 0){
                    foreach($result_product as $product)
                    {?>   
                        <tr class="">
                            <td class="column center_text"><?php echo $product['MSHH']?><input type="hidden" value="<?php echo $product['MSHH']?>" class="product_hidden_id"></td>
                            <td class="column center_item"><img src="../GUEST/img/<?php echo $product['TenHinh']?>" class="product_img" alt=""></td>
                            <td class="column product_name"><?php echo $product['TenHH']?></td>
                            <td class="column product_note" ><?php echo $product['QuyCach']?></td>
                            <td class="column product_price" ><?php echo $product['Gia']?> VNĐ</td>
                            <td class="column center_text product_stock" ><?php echo $product['SoLuongHang']?></td>
                            <td class="column " ><?php echo $product['TenLoaiHang']?><input type="hidden" class="product_category" value="<?php echo $product['MaLoaiHang']?>"></td>
                            <td class="column btn_wrapper" >
                                <form class="action_form" action="./product.php?delete=<?php echo $product['MSHH']?>" method="POST" onsubmit="return confirm('Bạn có muốn xóa <?php echo $product['TenHH']?>?');">
                                    <button class="small_btn delete_btn" name="delete"><i class="fas fa-times-circle"></i></button>
                                </form>
                                <form class="action_form" action="./product.php?edit=<?php echo $product['MSHH']?>" method="POST" > 
                                    <button class="small_btn edit_btn btn_no_default" name="edit"><i class="fas fa-pen"></i></button>
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
    <script>

        function searchProductValidation(){
            let lineNumber=document.querySelector('input[name="line_number"]').value;
            if(!lineNumber){
                alert('Vui lòng điền số dòng');
                return false;
            }
        }

        function addProductValidation(){
            let tenHH=document.querySelector('input[name="TenHH"]').value;
            let gia=document.querySelector('input[name="Gia"]').value;
            let soLuong=document.querySelector('input[name="SoLuongHang"]').value;
            let maLoaiHang=document.getElementById('select_category').value;
            let quyCach=document.querySelector('textarea[name="QuyCach"]').value;
            let tenHinh=document.querySelector('input[name="TenHinh"]').value;
            let error="";
            console.log(tenHH)
            if(tenHH.length<=0){
                error="Vui lòng điền tên hàng hóa";
            }
            if(gia.length<=0){
                error="Vui lòng điền giá hàng hóa";
            }
            if(soLuong.length<=0){
                error="Vui lòng điền số lượng hàng hóa";
            }
            if(maLoaiHang==='0'){
                error="Vui lòng chọn danh mục hàng hóa";
            }
            if(quyCach.length<=0){
                error="Vui lòng điền quy cách hàng hóa";
            }
            if(tenHinh.length<=0){
                error="Vui lòng chọn ảnh hàng hóa";
            }

            if(error!=""){
                alert(error);
                return false;
            }
        }

        function addProductValidation(){
            let tenLoaiHang=document.querySelector('input[name="ThemTenLoaiHang"]').value;
            if(!tenLoaiHang){
                alert('Vui lòng điền danh mục');
                return false;
            }
        }

    
        function btnPreventDefault(){
            let btn_count = document.getElementsByClassName("btn_no_default");
            for(let i =0;i<btn_count.length;i++){
                btn_count[i].addEventListener("click", function(event){      
                    event.preventDefault()
                });
            }
        }

        btnPreventDefault();

        document.getElementById("add_product").addEventListener("click", function(event){
            document.getElementById("add_new_form_wrapper").classList.remove("hide");
        });

        document.getElementById("add_category").addEventListener("click", function(event){
            document.getElementById("add_new_category_wrapper").classList.remove("hide");
        });

        function editButtonClick(){
            let editButtons=document.getElementsByClassName('edit_btn');
            let productHiddenId=document.getElementsByClassName('product_hidden_id');
            let productName = document.getElementsByClassName('product_name');
            let productPrice = document.getElementsByClassName('product_price');
            let productStock = document.getElementsByClassName('product_stock');
            let productCategory = document.getElementsByClassName('product_category');
            let productNote = document.getElementsByClassName('product_note');
            for(let i=0;i<editButtons.length;i++){
                editButtons[i].addEventListener("click", function(event){
                    document.getElementById("edit_form_wrapper").classList.remove("hide");
                    document.getElementById("edit_hidden_id").value=productHiddenId[i].value;
                    document.getElementById("edit_hidden_name").value=productName[i].innerHTML;
                    document.getElementById("TenHH_edit").value=productName[i].innerHTML;
                    document.getElementById("Gia_edit").value=parseInt(productPrice[i].innerHTML);
                    document.getElementById("SoLuongHang_edit").value=parseInt(productStock[i].innerHTML);
                    document.getElementById("select_edit_category").value=productCategory[i].value;
                    document.getElementById("QuyCach_edit").value=productNote[i].innerHTML;
                });
            }
        }
        editButtonClick();

        document.getElementById("add_new_cancel").addEventListener("click", function(event){
            document.getElementById("add_new_form_wrapper").classList.add("hide");
            document.getElementById("add_new_form").reset();
        });

        document.getElementById("add_new_category_cancel").addEventListener("click", function(event){
            document.getElementById("add_new_category_wrapper").classList.add("hide");
            document.getElementById("add_new_category_form").reset();
        });

        document.getElementById("edit_cancel").addEventListener("click", function(event){
            document.getElementById("edit_form_wrapper").classList.add("hide");
        });

        document.getElementById('add_new_form').onsubmit = function(e) {
            if(confirm('Bạn có muốn thêm hàng hóa?'))
                return addProductValidation();
            else e.preventDefault();
        };
        document.getElementById('filter_form').onsubmit = function(e) {
            return searchProductValidation();
        };

        document.getElementById('add_new_category_form').onsubmit = function(e) {
            if(confirm('Bạn có muốn thêm danh mục?'))
                return addProductValidation();
            else e.preventDefault();
        };

    

    </script>
</body>
</html>