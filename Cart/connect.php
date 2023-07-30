<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "mydb";
$port = 3306;

//使用mysqli去建立連線
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
  die("連線失敗：" .$conn->connect_error);
}

?>