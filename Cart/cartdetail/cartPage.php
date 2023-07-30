<?php

require_once("../connect.php");
// $sql = "SELECT * FROM `CartProduct_detail` ORDER BY `quantity` ASC;";
//下面是, 只取出cart_id為3的資料
// $sql = "SELECT * FROM `CartProduct_detail` WHERE cart_id = 3 ORDER BY `quantity` ASC;";
// $sql = "SELECT * FROM `CartProduct_detail` WHERE product_id = 34 ORDER BY `quantity` ASC;";
// $sql = "SELECT * FROM `CartProduct_detail` WHERE product_id LiKE '%3%' ORDER BY `quantity` ASC;";

//判斷是否有網址變數
$where1 = "";
if(isset($_GET["cart_id"])){
    $cart_id = $_GET["cart_id"];
    //可將$where1變數, 插入sql語法中
    $where1 = "WHERE `cart_id` = $cart_id";
}

//程式會檢查網址中是否有名為 "page" 的參數（也就是 $_GET["page"]）。
//如果有這個參數，代表使用者正在看某個特定的頁面，比如第 3 頁或第 5 頁，程式就會將 $_GET["page"] 的值存入變數 $page，以便後續使用。

$search = (isset($_GET["search"]))?$_GET["search"]:"";
$searchType = (isset($_GET["type"]))?$_GET["type"]:"";

if($search == ""){
    $searchSQL = "";
}else{
    //搜索匡有東西，才用WHERE ～～
    $searchSQL = "WHERE `$searchType` LIKE '%$search%'";
}


if(!isset($_GET["page"])){
    $page = 1;
}else{
    $page = $_GET["page"];
}


$perPage = 10;
// $page = 1;
//需註解$page = 1, 不然if...else邏輯會被覆蓋
//該頁面應從第幾筆資料開始顯示
$pageStart = ($page - 1) * $perPage;

//取得資料的總筆數
$totalSql = "SELECT COUNT(*) as total FROM `CartProduct_detail` $where1";
//$conn --> 連線物件
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalRows = $totalRow['total'];

// 計算總頁數
$totalPages = ceil($totalRows / $perPage);

// var_dump($totalPages);

// $sql = "SELECT * FROM `CartProduct_detail` $where ORDER BY `quantity` ASC LIMIT $pageStart, $perPage;";

$sql = "SELECT * FROM `CartProduct_detail` $searchSQL ORDER BY `quantity` ASC LIMIT $pageStart, $perPage;";
// var_dump($sql );
// exit;
// $sql = "SELECT * FROM `CartProduct_detail`WHERE $searchSQL ORDER BY `quantity` ASC LIMIT $pageStart, $perPage;";
//  var_dump($sql);
//  exit;
try{
    //使用result來承接內容
     $result = $conn->query($sql);
     $msgNum = $result -> num_rows;
     //把所有資料一次取出, 便關聯式陣列, 並且最後一筆停在第0筆
     $rows = $result -> fetch_all(MYSQLI_ASSOC);
    }catch(mysqli_sql_exception $exc){
    //  die("讀取失敗:" .$exc->getMessage());
     //將錯誤訊息存到$errorMsg變數
     $errorMsg = $exc->getMessage();
     $msgNum = -1;
    }
    $conn->close();
   
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <title>留言列表</title>
    <style>
    .msg{
        display: flex;
    }
    .id{
        width: 180px;
    }
    .name{
        width: 160px;
    }
    .content{
        width: calc(100% - 180px - 160px - 100px)
    }
    .time{
        width: 100px;
    }
    </style>
</head>

<body> 
<div class="container">
  <h1 class="pt-4">購物車detail</h1>
        <?php if($msgNum > 0): ?>
            <div class="d-flex">
                <div class="my-2 me-auto">
                    目前共 <?=$msgNum?> 筆資料
                </div>

                <!-- 增加的部份 start -->
                <div class="me-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-text">
                            <input name="searchType" id="searchType1" type="radio" class="form-check-input" value="cart_id" checked>
                            <label for="searchType1" class="me-2">購物車編號</label>
                            <input name="searchType" id="searchType2" type="radio" class="form-check-input" value="product_id">
                            <label for="searchType2">產品編號</label>
                        </div>
                        <input name="search" type="text" class="form-control form-control-sm" placeholder="搜尋">
                        <div class="btn btn-secondary btn-sm btn-search">送出搜尋</div>
                    </div>
                </div>
                <!-- 增加的部份 end -->

                <div>
                <a href="./cartForm04.html" class="btn btn-secondary btn-sm">增加資料</a>
                </div>
            </div>
            <div class="msg text-bg-dark ps-1">
                <div class="id">購物車編號</div>
                <div class="name">商品編號</div>
                <div class="content">數量</div>
                <div class="time">編輯</div>
                
            </div>
            <!-- 因已經用fetch_all()來取資料, 就無需用while跑迴圈 -->
            <!--  while($row = $result->fetch_assoc()):  有加php-->
        <?php foreach($rows as $row):?>
            <div class="msg my-1">
                <div class="id"><?=$row["cart_id"]?></div>
                <div class="name"><?=$row["product_id"]?></div>
                <div class="content"><?=$row["quantity"]?></div>
                <div class="time">
                <!-- <a href="./doDelete01.php?cart_id=" class="btn btn-info btn-sm">刪除</a> -->
                <span class="btn btn-info btn-sm btn-del" idn="<?=$row["cart_id"]?>" >刪除</span>
                <a href="./cartpage01.php?cart_id=<?=$row["cart_id"]?>" class="btn btn-info btn-sm">修改</a>
                </div>
            </div>
        <?php endforeach; ?>
            <?php elseif($msgNum == 0): ?>
                目前沒有資料
            <?php else: ?>
                發生錯誤：<?= $errorMsg ?>
        <?php endif; ?>


        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i=1;$i<=$totalPages; $i++): ?>
                    <li class="page-item">
                        <a class="page-link <?= ($page==$i)?"active":""?>" href="./cartPage.php?page=<?=$i?>"><?=$i?></a>
                    </li>
                <?php endfor; ?>

                    <!-- 下一頁 -->
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
            </ul>
        </nav>

</div>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script>
        //選取出所有具有btn-del的元素
        const btnDels = document.querySelectorAll(".btn-del");
        //為所有class為btn-del的元素添加點擊事件監聽器
        //使用展開運算子..., 將類陣列轉為陣列, 再使用陣列的方法map, 
        //回調函式 function(btnDel, index) 用於處理每個 .btn-del 元素，btnDel 代表每個元素本身，index 則代表每個元素在陣列中的索引位置。透過這兩個參數，你可以對每個元素進行相應的操作或處理。
        [...btnDels].map(function(btnDel, index){
            btnDel.addEventListener("click", function(){
                // this 指的是被點擊的具有btnDel類別的元素
                // getAttribute, 用於獲取指定屬性的值 
                let cart_id = parseInt(this.getAttribute("idn"));
                    //window.confirm, 是JavaScript內建的函數, 可顯示確定, 取消的對話筐
                if(window.confirm("是否確認刪除？") === true){
                    window.location.href = `./cartDelete.php?cart_id=${cart_id}`;
                }
                
            });
        });

        const btnSearch = document.querySelector(".btn-search");
        btnSearch.addEventListener("click", function(){
            let query = document.querySelector("input[name=search]").value;
            let queryType = document.querySelector("input[name=searchType]:checked").value;
           window.location.href = `./cartPage.php?search=${query}&type=${queryType}`;

        });


    </script>
</body>

</html>