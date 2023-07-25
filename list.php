<?php
// session_start();
// if(!isset($_SESSION["user"])){
//   header("location: ./login.php");
// }
// require_once("./connect.php");

$where1="";
if(isset($_GET["id"])){
    $id=$_GET["id"];
    $where1="WHERE `user_id`=$id AND";
}

$cid=(isset($_GET["cid"]))?intval($_GET["cid"]):0;

$search=(isset($_GET["search"]))?($_GET["search"]):"";
$searchType=(isset($_GET["qtype"]))?($_GET["qtype"]):"";
if($search==""){
    $searchSQL = "";
}else{
    $searchSQL = "`$searchType` LIKE '%$search%' AND";
}

if($cid==0){
    $catSQL="";
}else{
    $catSQL="`category` = $cid AND";
}

//每頁抓取10筆資料
if(!isset($_GET["page"])){
    $page = 1;
}else{
    $page =$_GET["page"];
}
$perPage = 10;
$pageStart = ($page - 1) * $perPage;
$sql = "SELECT * FROM `user` WHERE `isValid` = 1 LIMIT $pageStart, $perPage";
$sqlAll = "SELECT * FROM `user` WHERE `isValid` = 1";

  try {
    $result=$conn->query($sql);
    $msgnub=$result->num_rows;
    $rows=$result->fetch_all(MYSQLI_ASSOC);
    $resultAll=$conn->query($sqlAll);
    $rowsAll=$resultAll->fetch_all(MYSQLI_ASSOC);
    $totalAll=count($rowsAll);
    $totalPage = ceil($totalAll/$perPage);
  } catch (mysqli_sql_exception $exc) {
    // die ("讀取失敗" .$exc->getMessage());
    $errorMsg = $exc->getMessage();
    // $msgnub = -1;
  }
  
  $conn->close();
  
?>
<!DOCTYPE html>
<html lang="ZH-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .msg {
            display: flex;
        }

        .id {
            width: 30px;
        }

        .name {
            width: 100px;
        }

        .content {
            width: calc(100% - 30px - 100px - 180px)
        }

        .time {
            width: 180px;
        }
    </style>
    <title>使用者列表</title>
</head>

<body>
    <div class="container mt-5">
        <h1>使用者列表</h1>
        <?php if($msgnub>0):?>
            <div class="d-flex">
                <div class="my-2 me-auto">
                    目前共<?=$totalAll?> 個使用者
                </div>
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
                    <a href="./add.php" class="btn btn-info btn-sm">新增資料</a>
                </div>
            </div>
        <div class="border p-3 mb-5 rounded">
                <div class="msg text-bg-primary ps-1">
                    <div class="id">ID</div>
                    <div class="name">Name</div>
                    <div class="name ms-3">暱稱</div>
                    <div class="content ms-5 text-center">E-mail</div>
                    <div class="time">控制</div>
                </div>
            
            <?php foreach($rows as $index => $row):?>
            <div class="msg ps-1 my-1">
                <div class="id"><?=($index+1)?></div>
                <div class="name"><?=$row["user_name"]?></div>
                <div class="name ms-3"><?=$row["nickname"]?></div>
                <div class="content ms-5 text-center"><?=$row["user_email"]?></div>
                <div class="time">
                    <span class="btn btn-danger btn-sm btn-del" idn="<?=$row["user_id"]?>">刪除</span>
                    <a href="./update.php?id=<?=$row["user_id"]?>" class="btn btn-info btn-sm">修改</a>
                </div>
            </div>
            <?php endforeach;?>
         <?php elseif($msgnub==0):?>
                目前沒有資料喔!
        <?php else:?>
                錯誤:<?=$msgnub?>
        <?php endif; ?>
        </div>
        <div aria-label="Page navigation example border border-top-0 p-3 rounded rounded-top-0">
                <ul class="pagination justify-content-center">
                    <?php for($n=1;$n<=$totalPage;$n++):?>
                    <li class="page-item">
                        <a 
                        class="page-link
                         <?=($page==$n)?"active":""?>"
                          href="./navbar.php?webpage=list.php&page=<?=$n?>
                          <?=($cid>0)?"&cid=$cid":""?>
                          <?=($search=="")?"":"&search=$search&qtype=$searchType"?>
                          ">
                          <?=$n?>
                        </a>
                    </li>
                    <?php endfor?>
                </ul>
            </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        const btnDels=document.querySelectorAll(".btn-del");
        [...btnDels].map(function(btnDel, index){
            btnDel.addEventListener("click",function(){
                let id= parseInt(this.getAttribute("idn"));
                if(window.confirm("真的要刪除嗎??")=== true){
                window.location.href=`./doDelete.php?id=${id}`;    
                }
            })
        });
        const btnSearch=document.querySelector(".btn-search");
        btnSearch.addEventListener("click",function(){
            let query=document.querySelector("input[name=search]").value;
            let querytype=document.querySelector("input[name=searchType]:checked").value;
            window.location.href=`./list.php?search=${query}&qtype=${querytype}`
        }
        );
        
    </script>
</body>

</html>