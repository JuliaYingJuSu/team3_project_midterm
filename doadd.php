<?php
require_once("./connect.php");

if(!isset($_POST["email"])){
    echo "請透過正常方式進入";
    exit;
  }
  
$name = $_POST["name"];
$nickname = $_POST["nickname"];
$email = $_POST["email"];
$phone=$_POST["phone"];
$password = $_POST["password"];
$password2 = $_POST["password2"];

$msg="";
$sql="SELECT * FROM `user` WHERE `user_email` = '$email';";
try{
  $result=$conn->query($sql);
  $count = $result->num_rows;
}catch (mysqli_sql_exception $exc) {
  $msg= "資料新增錯誤：" .$exc->getMessage();
}

if($msg!==""){
  alertgoBack("email空白喔!");
  exit;
}

if($count>0){
  alertgoBack("這個email已經有人用過囉!");
}

// $password=password_hash($password,PASSWORD_BCRYPT);

$sql = "INSERT INTO `user` 
    (`user_id`, `user_name`,`nickname`,`user_email`,`user_password`,`user_phone`,`create_date`, `updatetime`, `last_login_time`) VALUES 
    ('', '$name','$nickname','$email','$password','$phone',NOW(),NOW(),NOW());";

  try {
    $conn->query($sql);
    $msg= "資料新增成功";
  } catch (mysqli_sql_exception $exc) {
    echo "資料新增錯誤：" .$exc->getMessage();
  }
  $conn->close();

  echo "<script>
          alert(\"$msg\")
            window.location.href=\"navbar.php?webpage=list.php\";
        </script>";

function alertgoBack($msg2){
echo "<script>
        alert(\"$msg2\")
          window.history.back();
      </script>";
        exit;
      }
