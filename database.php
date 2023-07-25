<?php
$host = "localhost";
$dbname = "midterm";
$username = "root";
$password = "";

// $mysqli = new mysqli($host, $username, $password, $dbname);
// 此变量顺序必须固定

// if($mysqli -> connect_errno){
//     die("Connection error :" . $mysqli -> connect_errno);
// }
// connect_errono没有错误回传0，有错误die显示错误讯息

try {
    $mysqli = new mysqli($host, $username, $password, $dbname);
  } catch (mysqli_sql_exception $exception) {
    die("連線失敗：" . $exception->getMessage());
  }
//   try catch回传的错误的可读性较高

return $mysqli;

?>