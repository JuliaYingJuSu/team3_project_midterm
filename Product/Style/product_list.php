<?php
// session_start();
require_once("../../connect.php"); // 引用連線
require_once("../utilities/alertFunc.php"); // 引用常用函數

$error = ""; // 初始化錯訊訊息，預設無錯誤
//分類頁籤
$perPage = 6; // 每頁筆數
// 抓取網址變數 頁數
if (isset($_GET["page"])) {
  $page = intval($_GET["page"]);
} else {
  $page = 1;
}
// 計算初始筆數
$pageStart = ($page - 1) * $perPage;

//次分類頁籤
$perPageL = 6; // 每頁筆數
// 抓取網址變數 頁數
if (isset($_GET["pageL"])) {
  $pageL = intval($_GET["pageL"]);
} else {
  $pageL = 1;
}
// 計算初始筆數
$pageStartL = ($pageL - 1) * $perPageL;


// 判斷使用者與其額外的 SQL 語句
// $uid = $_SESSION["user"]["id"];
// $level = $_SESSION["user"]["level"];
// if($level == 9){
//   $uSQL = "";
// }else{
//   $uSQL = "`uid` = $uid AND";
// }

//分類變數
$sql = "SELECT * FROM product_type WHERE `isValid` = 1 LIMIT $pageStart, $perPage";
$sqlAll = "SELECT * FROM product_type WHERE `isValid` = 1";
// $sql = "SELECT * FROM product_type WHERE $uSQL isValid = 1 LIMIT $pageStart, $perPage";
// $sqlAll = "SELECT * FROM product_type WHERE $uSQL `isValid` = 1";
try {
  $result = $conn->query($sql);
  $userCount = $result->num_rows;
  $rows = $result->fetch_all(MYSQLI_ASSOC);
  $resultAll = $conn->query($sqlAll);
  $totalCount = $resultAll->num_rows;
  $totalPage = ceil($totalCount / $perPage);
} catch (mysqli_sql_exception $exception) {
  $error = "資料讀取錯誤：" . $conn->error;
}
//次分類變數
// $sqlL = "SELECT * FROM product_type_list WHERE `isValid` = 1 LIMIT $pageStartL, $perPageL";
$sqlL = "SELECT * FROM product_type_list JOIN product_type ON product_type_list.product_type_id = product_type.product_type_id WHERE product_type_list.isValid = 1 AND product_type.isValid = 1 LIMIT $pageStartL, $perPageL";

// echo($sqlL);
// exit;
//數筆數用
$sqlAllL = "SELECT * FROM product_type_list WHERE `isValid` = 1";
// $sql = "SELECT * FROM product_type WHERE $uSQL isValid = 1 LIMIT $pageStart, $perPage";
// $sqlAll = "SELECT * FROM product_type WHERE $uSQL `isValid` = 1";
try {
  $resultL = $conn->query($sqlL);
  $userCountL = $resultL->num_rows;
  $rowsL = $resultL->fetch_all(MYSQLI_ASSOC);
  $resultAllL = $conn->query($sqlAllL);
  $totalCountL = $resultAllL->num_rows;
  $totalPageL = ceil($totalCountL / $perPageL);
} catch (mysqli_sql_exception $exception) {
  $error = "資料讀取錯誤：" . $conn->error;
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>分類列表</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
      .category{
        display: flex;
        justify-content: space-between;
      }
      .sn{

        padding-left: 10px;
        padding-right: 10px;
      }
      .name{

        padding-left: 10px;
        padding-right: 10px;
      }
      .ctrl{
        padding-left: 10px;
        padding-right: 10px;
      }

    </style>
    
  </head>
  <body>

    <div class="container my-3 ">

<!-- 分類 -->
      <div class="d-flex mb-2">
        <h1 class=" align-middle ms-1">分類列表</h1>
      </div>
      <div class=" d-flex justify-content-end ">
        <a class="btn btn-info btn-sm my-1" href="./product_add.php">增加分類</a>

      </div>
      <?php if($error !== ""): ?>
        <div class="text-danger fw-bold fs-3">發生錯誤，請洽管理人員</div>
      <?php else:?>
        <div class="category data head bg-secondary p-1 text-white rounded p-2 mb-2">
          <div class="sn">編號</div>
          <div class="name">分類名稱</div>
          <!-- <div class="cTime">建立時間</div> -->
          <div class="ctrl text-center">操作管理</div>
        </div>

          <?php foreach($rows as $index => $row): ?>
          <div class="category data py-2">
            <div class="sn "><?=($perPage*($page-1))+$index+1?></div>
            <div class="name"><?=$row["product_type_name"]?></div>
            <!-- <div class="cTime"><?=$row["createTime"]?></div> -->
            <div class="ctrl text-center">
              <a href="./product_update.php?id=<?=$row["product_type_id"]?>" class="btn btn-primary btn-sm">管理</a>
              <div href="#" class="btn btn-danger btn-sm btn-del" idn="<?=$row["product_type_id"]?>">刪除</div>
            </div>
          </div>
          <?php endforeach; ?>

          <div class="category data footer bg-primary"></div>
          <div class="pagination pagination-sm justify-content-center my-2">
            <?php for($i=1;$i<=$totalPage;$i++): ?>
              <div class="page-item">
                <a href="?page=<?=$i?>" class="page-link <?=($page==$i)?"active":""?>"><?=$i?></a>
              </div>
            <?php endfor; ?>
          </div>
          <?php endif; ?>

<!-- 次分類 -->
          <div class="d-flex mb-2">
            <h1 class=" align-middle ms-1">次分類列表</h1>
           </div>
          <div class=" d-flex justify-content-end ">
            <a class="btn btn-info btn-sm my-1" href="./product_addL.php">增加分類</a>
          </div>

     
      <?php if($error !== ""): ?>
        <div class="text-danger fw-bold fs-3">發生錯誤，請洽管理人員</div>
      <?php else:?>
        <div class="category data head bg-secondary p-1 text-white rounded p-2 mb-2">
          <div class="sn">編號</div>
          <div class="name">次分類名稱</div>
          <div class="cTime">所屬分類</div>
          <div class="ctrl text-center">操作管理</div>
        </div>

          <?php foreach($rowsL as $index => $rowL): ?>
          <div class="category data py-2">
            <div class="sn"><?=($perPageL*($pageL-1))+$index+1?></div>
            <div class="name"><?=$rowL["product_type_list_name"]?></div>
            <div class="cTime"><?=$rowL["product_type_name"]?></div>
            <div class="ctrl text-center">
              <a href="./product_updateL.php?id=<?=$rowL["product_type_list_id"]?>" class="btn btn-primary btn-sm">管理</a>
              <div href="#" class="btn btn-danger btn-sm btn-delL" idnL="<?=$rowL["product_type_list_id"]?>">刪除</div>
            </div>
          </div>
          <?php endforeach; ?>
          
          <div class="category data footer bg-primary"></div>
          <div class="pagination pagination-sm justify-content-center my-2">
            <?php for($i=1;$i<=$totalPageL;$i++): ?>
              <div class="page-item">
                <a href="?pageL=<?=$i?>" class="page-link <?=($pageL==$i)?"active":""?>"><?=$i?></a>
              </div>
            <?php endfor; ?>
          </div>
          <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<!-- 分類 -->
    <script>
      let btnDels = document.querySelectorAll(".btn-del");
      [...btnDels].map(function(btnDel){
        btnDel.addEventListener("click", function(){
          let id = this.getAttribute("idn");
          if(confirm("確定要刪除嗎？")){
            window.location.href = `./product_doDelete.php?id=${id}`;
          }
        })
      });
    </script>
<!-- 次分類 -->
    <script>
      let btnDelsL = document.querySelectorAll(".btn-delL");
      [...btnDelsL].map(function(btnDelL){
        btnDelL.addEventListener("click", function(){
          let idL = this.getAttribute("idnL");
          if(confirm("確定要刪除嗎？")){
            window.location.href = `./product_doDeleteL.php?idL=${idL}`;
          }
        })
      });
    </script>
  </body>
</html>