<?php
require_once("./connect.php");

$sql = "SELECT * FROM `book` WHERE `book_isValid` = 1 ORDER BY `book_create_time` DESC;";

$search = isset($_GET["search"])?$_GET["search"]:"";
$searchType = isset($_GET["qtype"])?$_GET["qtype"]:"";

if($search == ""){
    $searchSQL = "";
}else{
    $searchSQL = "`$searchType` LIKE '%$search%' AND";
}

if(!isset($_GET["page"])){
    $page = 1;
}else{
    $page = $_GET["page"];
}

$perPage = 10;
$pageStart = ($page - 1) * $perPage;


$sql = "SELECT * FROM `book` WHERE $searchSQL `book_isValid` = 1 ORDER BY `book_id` DESC LIMIT $pageStart, $perPage";
$sqlAll = "SELECT * FROM `book` WHERE $searchSQL `book_isValid` = 1";


try{
  $result = $conn->query($sql);
  $resultAll = $conn->query($sqlAll);
  $msgNum = $result -> num_rows;
  $rows = $result -> fetch_all(MYSQLI_ASSOC);
  $rowsAll = $resultAll -> fetch_all(MYSQLI_ASSOC);
  $totalAll = count($rowsAll);
  $totalPage = ceil($totalAll/$perPage);
}catch(mysqli_sql_exception $exc){
    $errorMsg = $exc->getMessage();
    $msgNum = -1;
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body{
        font-size: 14px;
        }
        .msg{
        display: flex;
        }
        .book_id{
        width: 80px;
        }
        .user_id{
        width: 80px;
        }
        .restaurant_id{
        width: 100px;
        }
        .available_date{
        width: 120px;
        }
        .available_time{
        width: 150px;
        }
        .customer_nums{
        width: 100px;
        }
        .book_create_time{
        width: calc(100% - 80px - 80px - 100px - 180px - 150px - 100px - 120px)
        }
        .time{
        width: 180px;
        }
        .msg .btn{
        height: 30px;
        }

        .name{
        width: 120px;
        }
        .photo{
        width: 200px;
        }
        .restaurant{
        width: calc(100% - 120px - 200px - 400px)
        }
        .note{
        width: 400px;
        }
        .card{
        width:95%;
        }

        .lh{
        line-height: 1.8rem;
        }
    </style>
    <title>訂位總表</title>
</head>
<body>
    <div class="container">
        <h1 class="mt-2">訂位總表</h1>
        <?if($msgNum > 0):?>
            <div class="d-flex">
                <div class="my-2 me-auto">
                    目前共 <?=$totalAll?> 筆資料
                </div>
                <div class="me-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-text">
                            <input name="searchType" id="searchType1" type="radio" class="form-check-input" value="book_id" checked>
                            <label for="searchType1" class="me-2">訂位編號</label>

                            <input name="searchType" id="searchType2" type="radio" class="form-check-input" value="user_id">
                            <label for="searchType2" class="me-2">會員編號</label>

                            <input name="searchType" id="searchType3" type="radio" class="form-check-input" value="restaurant_id">
                            <label for="searchType3" class="me-2">餐廳編號</label>

                            <input name="searchType" id="searchType4" type="radio" class="form-check-input" value="available_date">
                            <label for="searchType4" class="me-2">日期</label>

                            <input name="searchType" id="searchType6" type="radio" class="form-check-input" value="customer_nums">
                            <label for="searchType6" class="me-2">人數</label>

                        </div>
                            <input name="search" type="text" class="form-control form-control-sm me-2" placeholder="搜尋">
                            <div class="btn btn-primary btn-sm btn-search">送出搜尋</div>
                        </div>
                    </div>
                <div>
                    <a href="./add.html" class="btn btn-info btn-sm">增加資料</a>
                </div>
            </div>

            <div class="d-flex justify-content-between">

                <div aria-label="Page navigation example me-auto">
                    <ul class="pagination">
                        <?php for($i=1;$i<=$totalPage;$i++):?>
                        <li class="page-item"><a class="page-link <?=($page == $i)?"active":""?>" href="./pageBooksList3.php?page=<?=$i?>"><?=$i?></a></li>
                        <?php endfor;?>
                    </ul>
                </div>

                <div>
                    <a href="./pageBooksList3.php" class="btn btn-light btn-sm mt-2">重置</a>
                    <a href="./dashboard.php" class="btn btn-light btn-sm mt-2">圖表</a>
                </div>
            
            </div>

            
            <div class="msg text-bg-dark ps-1">
                <div class="book_id">訂位編號</div>
                <div class="user_id">會員編號</div>
                <div class="restaurant_id">餐廳編號</div>
                <div class="available_date">日期</div>
                <div class="available_time">時間</div>
                <div class="customer_nums">人數</div>
                <div class="book_create_time">訂位成立時間</div>
                <div class="time">控制</div>
            </div>
            
            <?foreach($rows as $row):?>
                    <div class="msg my-1">
                        <div class="book_id"><?=$row["book_id"]?></div>
                        <div class="user_id"><?=$row["user_id"]?></div>
                        <div class="restaurant_id"><?=$row["restaurant_id"]?></div>
                        <div class="available_date"><?=$row["available_date"]?></div>
                        <div class="available_time"><?=$row["available_time"]?></div>
                        <div class="customer_nums"><?=$row["customer_nums"]?></div>
                        <div class="book_create_time"><?=$row["book_create_time"]?></div>
                        <div class="time">
                            <span class="btn btn-danger btn-sm btn-del" idn="<?=$row["book_id"]?>">刪除</span>
                            <a href="./pageBook.php?book_id=<?=$row["book_id"]?>" class="btn btn-info btn-sm">修改</a>
                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?=$row["book_id"]?>" aria-expanded="false" aria-controls="collapseExample">展開</button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample<?=$row["book_id"]?>">
                        <div class="card card-body">
                        </div>
                    </div>
            <?endforeach;?>
        <?elseif($msgNum == 0):?>
            目前沒有資料。
        <?else:?>
            發生錯誤: <?=$errorMsg?>
        <?endif;?>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        const btnDels = document.querySelectorAll(".btn-del");
        [...btnDels].map(function(btnDel, index){
            btnDel.addEventListener("click",function(){
                let id = parseInt(this.getAttribute("idn"));
                if(window.confirm("確認要刪除嗎?") === true ){
                    window.location.href = `./Delete01.php?id=${id}`;
                }
            })
        });
        const btnSearch = document.querySelector(".btn-search");
        btnSearch.addEventListener("click",function(){
            let query = document.querySelector("input[name=search]").value;
            let queryType = document.querySelector("input[name=searchType]:checked").value;
            window.location.href = `./pageBooksList3.php?search=${query}&qtype=${queryType}`;
        })

        const demo1 = document.getElementById("collapseExample48");
        demo1.innerHTML = `<div class="card card-body mb-3">
                    <div class="msg text-bg-secondary ps-1">
                        <div class="name">會員姓名</div>
                        <div class="photo">會員頭像</div>
                        <div class="restaurant">餐廳名稱</div>
                        <div class="note">備註</div>
                    </div>
                    <div class="msg my-2">
                        <div class="name">維尼那隻熊</div>
                        <div class="photo"><img src="./bimg/winnie.png" alt="小熊維尼"></div>
                        <div class="restaurant">朵拉鬆餅坊</div>
                        <div class="note lh">
                            請幫我準備給小豬的生日蛋糕~~<br>
                            在所有人用完餐後拿進來~~<br>
                            小豬是粉紅色長得像兔子的那一位~~ (最小隻的就是了!!)<br><br>
                            還有啊...可以的話蛋糕的蜂蜜能放多少就放多少~~<br>
                            要貼錢再跟我說~~~3Q~~
                        </div>
                    </div>
                </div>`;

        const demo2 = document.getElementById("collapseExample47");
        demo2.innerHTML = `<div class="card card-body mb-3">
                    <div class="msg text-bg-secondary ps-1">
                        <div class="name">會員姓名</div>
                        <div class="photo">會員頭像</div>
                        <div class="restaurant">餐廳名稱</div>
                        <div class="note">備註</div>
                    </div>
                    <div class="msg my-2">
                        <div class="name">Alex Wu</div>
                        <div class="photo"><img src="./bimg/alex.jpg" alt="大帥哥"></div>
                        <div class="restaurant">陶板屋</div>
                        <div class="note lh">
                            這天下午預計改同學的作業<br>
                            先看了一下, SQL語法寫得各式各樣, 到時候肯定看得頭昏眼花<br>
                            再麻煩陶板屋不要讓我候位太久, 我需要好好放鬆身心!<br>
                        </div>
                    </div>
                </div>`;
    </script>
</body>
</html>