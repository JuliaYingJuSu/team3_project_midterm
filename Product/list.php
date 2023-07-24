<!-- 訊息列表 -->


<?php
require_once("./connect.php");


$where1="";
if(isset($_GET["product_id"])){
    $id= $_GET["product_id"];
    $where1="where `product_id` =$id";
}




//V
$tid=(isset($_GET["tid"]))?intval($_GET["tid"]):0;
if($tid == 0){
  $typeSQL = "";
}else{
  $typeSQL = "`product_type_id` = $tid AND";
}




$search = (isset($_GET["search"]))?$_GET["search"]:"";
$searchType = (isset($_GET["qtype"]))?$_GET["qtype"]:"";

if($search == ""){
  $searchSQL = "";
}else{
  $searchSQL = "`$searchType` LIKE '%$search%' AND ";
}

if(!isset($_GET["page"])){
  $page=1;
}else{
  $page =$_GET["page"];
}

$perPage = 10;
$pageStart = ($page - 1) * $perPage;
//索引>>從0開始取10筆/從10開始取10.....


$sql = "SELECT * FROM `product` WHERE  $typeSQL $searchSQL `isValid` = 1 LIMIT $pageStart, $perPage";
// limit0,5五個一頁  
$sqlAll = "SELECT * FROM `product` WHERE $typeSQL $searchSQL `isValid` = 1";


$sqlType="SELECT * FROM `product_type`";



try{
  $result =$conn->query($sql);
  $resultAll =$conn->query($sqlAll);
  $resultType =$conn->query($sqlType);

    //連線從資料庫抓sql語法的東西
  $msgNum=$result ->num_rows;
    //數幾個
  $rows=$result->fetch_all(MYSQLI_ASSOC);
  $rowsAll=$resultAll->fetch_all(MYSQLI_ASSOC);
  $totalAll = count($rowsAll);  
  $totalPage = ceil($totalAll/$perPage);

  $rowsType = $resultType->fetch_all(MYSQLI_ASSOC);
    //用fetch_all()方法取出全部
    //MYSQLI_ASSOC將內容轉成關聯式陣列
}catch(mysqli_sql_exception $exc){
  //die("讀取失敗" .$exc->getmessage());
  $errorMsg=$exc->getmessage();
  $msgNum=-1;
  //數字設-1下面可以顯示發生錯誤
}

$conn->close();

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>商品列表</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/list.css">
    <style>
        .msg{
          display: flex;
        }
        .id{
          width: 40px;
        }
        .name{
          width: 180px;
        }
        .price{
          width: 40px;
        }
        .description{
          width: calc((100% - 30px - 180px - 40px - 100px) / 2);
        }
        .specification{
          width: calc((100% - 30px - 180px - 40px - 100px) / 2);
        }
        .control{
          width: 100px;
        }
    </style>
  </head>
  <body>


  <div class="container">
  <h1>商品列表</h1>

  <?php if($msgNum>0): ?>
    <div class=" d-flex">
        <div class="my-2 me-auto"> 目前共<?=$totalAll?> 項商品</div>

        <div class="me-1">
          <div class="input-group input-group-sm">
            <div class="input-group-text">
              <input name="searchType" id="searchType1" type="radio" class="form-check-input" value="name" checked>
              <label for="searchType1" class="me-2">名字</label>

              <input name="searchType" id="searchType2" type="radio" class="form-check-input" value="content">
              <label for="searchType2">內文</label>
            </div>
              <input name="search" type="text" class="form-control form-control-sm" placeholder="搜尋">
              <div class="btn btn-primary btn-sm btn-search">送出搜尋</div>
          </div>
        </div>


        <div>
          <a href="./add.php" class="btn btn-warning">新增資料</a>
        </div>
    </div>

    <div class="nav nav-tabs">
        <a class="nav-link <?=($tid==0)?"active":""?>" href="./list.php">全部</a>
        
        <?php foreach($rowsType as $row): ?>
        <a class="nav-link <?=($tid==$row["product_type_id"])?"active":""?>" href="./list.php?tid=<?=$row["product_type_id"]?>"><?=$row["product_type_name"]?></a>
        <?php endforeach; ?>
    </div>



<!-- 重複一輪從這 -->
  <div class="border border-top-0 p-3 rounded rounded-top-0">
    <div class="msg text-bg-dark ">
        <div class="id">編號</div>
        <div class="name">品名</div>
        <div class="price">價錢</div>
        <div class="description">介紹</div>
        <div class="specification">規格</div>
        <div class="control">控制</div>
    </div>
    <?php foreach($rows as $index => $row): ?>
        <div class="msg my-1 p-3">
            <div class="id"><?=($index+1)?></div>
            <div class="name overflow-auto h70"><?=$row["product_name"]?></div>
            <div class="price"><?=$row["price"]?></div>
            <div class="description overflow-auto h70"><?=$row
            ["product_description"]?></div>
            <div class="specification overflow-auto h70"><?=$row["specification"]?></div>
            <div class="control">
                <span class="btn btn-danger btn-sm btn-del" idn="<?=$row["product_id"]?>">刪除</span>
                <a href="./update.php?id=<?=$row["product_id"]?>" class="btn btn-warning btn-sm" >修改</a>
            </div>
        </div>
    <?php endforeach; ?>

    <div aria-label="Page navigation example" class="m-auto">
      <ul class="pagination">
      <?php for($i=1;$i<=$totalPage;$i++): ?>

        <li class="page-item">
          <a class="page-link <?=($page==$i)?"active":""?>" 
              href="./list.php?
                  page=<?=$i?>
                  <?=($tid>0)?"&tid=$tid":""?>
                  <?=($search=="")?"":"&search=$search&qtype=$searchType"?>
                  "><?=$i?></a>
        </li>
      <?php endfor; ?>

      </ul>
    </div>
  </div>
<!-- 到這 -->
    

    <?php elseif($msgNum==0): ?>
        目前沒有商品
    <?php else: ?>
        發生錯誤:<?=$errorMsg?>
    <?php endif; ?>
</div>  


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script>
        const btnDels= document.querySelectorAll(".btn-del");
          // foreach=[...btnDels].map
        btnDels.forEach(function(btnDel,index){  
          btnDel.addEventListener("click", function(){
          let id = parseInt(this.getAttribute("idn"));
          if(window.confirm("確認要刪除嗎?") === true){
          window.location.href=`./doDelete.php?id=${id}`;
          }
        })
        });

        const btnSearch = document.querySelector(".btn-search");
        btnSearch.addEventListener("click", function(){
          let query = document.querySelector("input[name=search]").value;
          let queryType = document.querySelector("input[name=searchType]:checked").value;

          window.location.href = `./list.php?search=${query}&qtype=${queryType}`;
        })
    </script>
  </body>
</html>