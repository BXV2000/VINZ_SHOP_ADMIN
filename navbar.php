<?php
if(isset($_SESSION['username']) && $_SESSION['username']){ 
}
else{
  echo"<script>alert(`Vui lòng đăng nhập`)</script>";
  echo"<script>window.location='login.php' </script>";
}

if(isset($_GET['logout'])){
  $_SESSION = array(); 
  session_unset();
  session_destroy();
  echo"<script>window.location='login.php' </script>";
  exit();
}

?>

<html>
    <head>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <style> 
            <?php include 'css/navbar.css'; ?>
        </style>
    </head>
    <body>
    <div class="login_container">
      <div class="logo_area"> 
        <a href="index.php" ><img src="./img/logo.jpg" alt="Logo" class="logo_img" /></a>
      </div>
      <div class="function_area">
        <a href="index.php" ><i class="fas fa-columns"></i> Trang chủ</a>
        <a href="product.php" ><i class="fas fa-sitemap"></i> Sản phẩm</a>
        <a href="order.php"><i class="fas fa-stream"></i> Đơn hàng</a>
        <a href="customer.php"><i class="fas fa-user"></i> Khách hàng</a>
        <a href="staff.php"><i class="fas fa-address-card"></i> Nhân viên</a>
      </div>
      <form action="logout.php" method="GET" onsubmit="return confirm('Bạn có chắc muốn đăng xuất ?')">
        <button name="logout" class="logout_btn">Đăng xuất</button>
      </form>
    </div>
    </body>
</html>