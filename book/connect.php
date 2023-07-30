<?php
$servername = "localhost";
$username = "Monica";
$password = "a12345";
$dbname = "midterm";
$port = 3306;

try{
  $conn = new mysqli($servername, $username, $password, $dbname, $port);
}catch(mysqli_sql_exception $exc){
  die("連線失敗：" . $exc->getMessage());
}
