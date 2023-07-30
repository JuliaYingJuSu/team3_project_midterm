<?php
//將表單內容送出後, 新增至資料庫 (針對單筆資料)

require_once("../connect.php");


if(!isset($_POST["cart_id"])){
    echo "請由正常管道進入";
    exit;
}


$cart_id = $_POST["cart_id"];
$user_id = $_POST["user_id"];
$groupbuy_id = $_POST["groupbuy_id"];

$sql = "INSERT INTO `cart` (`cart_id`, `user_id`, `groupbuy_id`) 
VALUES 
($cart_id, $user_id, '$groupbuy_id')";

try{
$conn->query($sql);
echo "資料新增成功";
}catch(mysqli_sql_exception $exc){
echo "資料新增失敗" .$exc->getMessage();
}

$conn->close();
?>