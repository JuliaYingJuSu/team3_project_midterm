<?php
//刪除資料庫內容

require_once("../connect.php");

//因無表單, 因此使用GET變數
//為什麼不能用$cartproduct_id進入
if(!isset($_GET["order_id"])){
    echo "請由正常管道進入";
    exit;
}

$order_id = $_GET["order_id"];
// $orderproduct_id = $_GET["orderproduct_id"];

// $sql = "DELETE FROM CartProduct_detail 
// WHERE `cart_id` = $cart_id;";

$sql = "DELETE FROM Oder_detail WHERE `order_id` = $order_id;";


try{
    $conn->query($sql);
    // echo "資料刪除成功";
    $msg = "刪除成功";
    }catch(mysqli_sql_exception $exc){
    $msg = "刪除資料錯誤" .$exc->getMessage();
    //法一
    // echo "刪除資料錯誤" .$exc->getMessage();
    // exit;
    //錯誤還是會繼續執行下面的程式
    //若希望錯誤, 到此停止 使用exit 或 die
    //法二
    // die("刪除資料錯誤" .$exc->getMessage());
    }
    
    $conn->close();
//跳轉至列表頁
// header("location: ./pageMsgsList2.php");
//使用script的方法, 跳轉至列表頁
    echo  "<script>
        alert(`$msg`);
        window.location.href = \"./orderPage.php\";
   </script>";
    ?>