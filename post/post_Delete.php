<?php
require_once("./connect.php");

if(!isset($_GET["post"])){
    echo "請由正常管道進入";
    exit;
}

$post_ID = $_GET["post"];


$sql = "UPDATE `post` SET `isValid` = 0 WHERE  `post_ID` = '$post_ID';";

try{
    $conn->query($sql);
    $msg="刪除成功！！";
}catch(mysqli_sql_exception $exc){
    $msg="刪除錯誤：" .$exc->getMessage();
}

$conn->close();

echo "<script>
    alert(\"$msg\");
    window.location.href = \"./post_ArticleList.php\";</script>";
?>

