<?php
    
session_start();
include('connection.php');

if(!empty($_SESSION['username']))
{
    echo"<script>alert(`Đã đăng nhập rồi`)</script>";
    echo"<script>window.location='index.php'</script>";
}

if(isset($_POST['login'])){
    $username   = addslashes($_POST['username']);
    $password   = addslashes($_POST['password']);
    $query = "SELECT MSNV,MatKhau FROM nhanvien WHERE MSNV='$username'";
    $result_login=mysqli_query($connect,$query);
    $data = mysqli_fetch_array($result_login);
    if (mysqli_num_rows($result_login) == 0) {
        echo"<script>alert(`Tài khoản không tồn tại`)</script>";
        echo"<script>window.location='login.php' </script>";
    }
    if($password != $data['MatKhau']){
        echo"<script>alert(`Sai mật khẩu`)</script>";
        echo"<script>window.location='login.php' </script>";
    }
    else{
        $_SESSION['username'] = $username;
        echo"<script>window.location='index.php'</script>";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style> 
        <?php include 'css/login.css'; ?>
    </style>
</head>
<body>
    <div class="login_container">
        <form class="login_menu" id="login_form" method="POST" action="login.php">
            <h1>ĐĂNG NHẬP</h1>
            <div class="username item">
                <label for="username"><i class="fas fa-user"></i></label>
                <input type="text" id="username" name="username">
            </div>
            <div class="password item">
            <label for="password"><i class="fas fa-key"></i></label>
                <input type="password" id="password" name="password">
            </div>
            <div class="buttons">
                <button class="button" name="login">Đăng nhập</button>
                <button class="button">Quên mật khẩu</button>
            </div>
        </form>
    </div>
    <script>
        function loginValidation(){
            let usr = document.getElementById("username").value;
            let pwd = document.getElementById("password").value;
            let err ="";
            if(usr.length<=0){
                error="Vui lòng điền tên đăng nhập";
            }
            if(error!=""){
                alert(error);
                return false;   
            }
        }
        document.getElementById('login_form').onsubmit = function(e) {
            return loginValidation();
        };
    </script>
</body>
</html>