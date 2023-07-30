<?php

require_once("../connect.php");
// $sql = "SELECT * FROM `CartProduct_detail` ORDER BY `quantity` ASC;";
//下面是, 只取出cart_id為3的資料
// $sql = "SELECT * FROM `CartProduct_detail` WHERE cart_id = 3 ORDER BY `quantity` ASC;";
// $sql = "SELECT * FROM `CartProduct_detail` WHERE product_id = 34 ORDER BY `quantity` ASC;";
// $sql = "SELECT * FROM `CartProduct_detail` WHERE product_id LiKE '%3%' ORDER BY `quantity` ASC;";

//判斷是否有網址變數
$where1 = "";
if(isset($_GET["product_id"])){
    $product_id = $_GET["product_id"];
    //可將$where1變數, 插入sql語法中
    $where1 = "WHERE `product_id` = $product_id";
}

if(!isset($_GET["page"])){
    $page = 1;
}else{
    $page = $_GET["page"];
}


$perPage = 10;
$pageStart = ($page - 1) * $perPage;

//取得資料的總筆數
$totalSql = "SELECT COUNT(*) as total FROM `Oder_detail` $where1";
//$conn --> 連線物件
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalRows = $totalRow['total'];

//算出總頁數
$totalPages = ceil($totalRows / $perPage);

$sql = "SELECT * FROM `Oder_detail` ORDER BY `Oder_detail`.`product_id` ASC";
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
    <title>Order Detail 留言列表</title>
    <style>
    .msg{
        display: flex;
    }
    .id{
        width: 200px;
    }
    .pn{
        width: 200px;
    }
    .qt{
        width: 150px;
    }
    .name{
        width: 160px;
    }
    .edit{
        width: 150px;
    }
    .content{
        width: calc(100% - 200px - 160px - 160px - 230px - 150px)
    }
    .time{
        width: 230px;
    }
    </style>
</head>

<body> 
<div class="container">
  <h1 class="pt-4">訂單管理系統detail</h1>
        <?php if($msgNum > 0): ?>
            <div class="d-flex">
                <div class="my-2 me-auto">
                    目前共 <?=$msgNum?> 筆資料
                </div>
                <div>
                <a href="./orderForm04.html" class="btn btn-info btn-sm">增加資料</a>
                </div>
            </div>
            <div class="msg text-bg-dark">
                <div class="id">商品編號</div>
                <div class="content">商品名稱</div>
                <div class="pn">單價</div>
                <div class="qt">數量</div>
                <div class="name">小計</div>
                <div class="edit">編輯</div>  
            </div>

            <!-- 因已經用fetch_all()來取資料, 就無需用while跑迴圈 -->
            <!--  while($row = $result->fetch_assoc()):  有加php-->
        <?php foreach($rows as $row):?>
            <div class="msg my-1">
                <div class="id"><?=$row["product_id"]?></div>
                <div class="content"><?=$row["???"]?></div>
                <div class="pn"><?=$row["???"]?></div>
                <div class="qt"><?=$row["num"]?></div>
                <div class="name"><?=$row["delivery_method"]?></div>
                <div class="edit">  
                    <span class="btn btn-info btn-sm btn-del" idn="<?=$row["order_id"]?>">刪除</span>
                    <a href="./orderPage01.php?order_id=<?=$row["order_id"]?>" class="btn btn-info btn-sm">修改</a>
                </div> 
            </div>
        <?php endforeach; ?>
            <?php elseif($msgNum == 0): ?>
                目前沒有資料
            <?php else: ?>
                發生錯誤：<?php $errorMsg ?>
        <?php endif;  ?>

        <div class="row pt-5">
            <div class="col">合計： $NT1,210</div>
        </div>


        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i=1;$i<=$totalPages; $i++):?>
                    <li class="page-item">
                        <a class="page-link <?=($page==$i)?"active":""?>" href="./pageMsgsList2.php?page=<?=$i?>"><?=$i?></a>
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
        const btnDels = document.querySelectorAll(".btn-del");
        [...btnDels].map(function(btnDel, index){
            btnDel.addEventListener("click", function(){
                let order_id = parseInt(this.getAttribute("idn"));
                if(window.confirm("是否確認刪除？") === true){
                    window.location.href = `./orderDelete.php?order_id=${order_id}`;
                }
            })
        });
    </script>
</body>

</html>