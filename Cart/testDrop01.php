<?php

require_once("./connect.php");

$sql= "DROP TABLE `cart`";

//使用query的方法去取得$sql並連線
  if($conn->query($sql) === true){
    echo "資料表 cart 刪除完成";
  }else{
    echo "資料表刪除錯誤" .$conn->error;
  }

  $conn->close();





?>