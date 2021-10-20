<?php

session_start();
if(isset($_SESSION['username']) && $_SESSION['username']){ 
}
else{
  echo"<script>alert(`Vui lòng đăng nhập`)</script>";
  echo"<script>window.location='login.php' </script>";
}

?>
<html>
  <head>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <title>VINZ - TRANG CHỦ</title>
    <style>
      <?php include 'css/index.css'; ?>
    </style>
  </head>
  <body>
  <?php include 'navbar.php'; ?>
  <div class="index_container">
    <div class="label_area">
      <div class="page_name">
        <p><span><i class="fas fa-bars"></i></span> Trang chủ</p>
      </div>
      <div class="greeting">
        <p>Hi,<?php echo($_SESSION['username'])?></p>
      </div>
    </div>
    
  </div>
  </body>
</html>
