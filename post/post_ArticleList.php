<?php
require_once("../connect.php");


$search =(isset($_GET["search"]))?$_GET["search"]:"";
$searchType =(isset($_GET["qtype"]))?$_GET["qtype"]:"";
if($search == ""){
    $searchSQL="";
}else{
    $searchSQL ="`$searchType` like '%$search%' AND";
}

if(!isset($_GET["page"])){
    $page = 1;
}else{
    $page=$_GET["page"];
}
$perPage = 10;
$pageStart = ($page - 1)* $perPage;

$sql = "SELECT * FROM `post` join `user` on post.user_ID=user.user_id join updating_restaurant on post.updating_restaurant_ID = updating_restaurant.updating_restaurant_ID WHERE $searchSQL `postisValid` = 1 ORDER BY `create_time` DESC LIMIT $pageStart, $perPage;";
$sqlAll = "SELECT * FROM `post` WHERE $searchSQL `postisValid` = 1 ;";



try{
    $result = $conn -> query($sql);
    $resultAll = $conn->query($sqlAll);
    $msgNum = $result -> num_rows;
    $rows = $result ->fetch_all(MYSQLI_ASSOC);
    $rowsAll = $resultAll->fetch_all(MYSQLI_ASSOC);
    $totalAll = count($rowsAll);
    $totalPage = ceil($totalAll/ $perPage);

}catch(mysqli_sql_exception $exc){
    $errorMsg = $exc -> getMessage();
    $msgNum = -1;
}
$conn->close();

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>文章列表</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <style>
            .posts{
            display:flex;
            }
            .id{
            width:30px;
            }
            .name{
            width:100px;
            }
            .title {
            width:220px;
            }
            .post_content{
            width: 600px;
            }
            .restaurant_name {
            width:100px;
            }
            .restaurant_city{
            width:130px;
            }
            .createTime{
            width: 130px;
            }
            .editing_date{
            width:130px;
            }
            .editing{
            width:100px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>文章列表</h1>
                <?php if($msgNum > 0):?>
                <div class="d-flex">
                    <div class="my-2 me-auto">
                        目前共 <?=$totalAll?> 筆資料
                    </div> 
                    <div class="me-1">
                        <div class="input-group input-group-sm">
                            <div class="input-group-text">
                                <input name="searchType" id="searchType1" type="radio" class="form-check-input" value="restaurant_name" checked>
                                <label for="searchType1" class="me-2">餐廳名</label>
                                <input name="searchType" id="searchType2" type="radio" class="form-check-input" value="post_content">
                                <label for="searchType2">內文</label>   
                            </div>  
                            <input name="search" type="text" class="form-control form-control-sm" placeholder="搜尋">   
                        <div class="btn btn-primary btn-sm btn-search">送出搜尋</div>
                    </div>      
                </div>
                <div>
                    <a href="./post_NewArticle.php" class="btn btn-primary btn-sm">新增文章</a>
                </div> 
            </div>
            <div class="border border-top p-3 mb-5 rounded rounded-top-0">
                <div aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php for($i=1;$i<=$totalPage;$i++): ?>
                            <li class="page-item">
                             <a 
                             class="page-link <?=($page == $i)?"active":""?>" 
                             href="./navbar.php?webpage=post_ArticleList.php&page=<?=$i?><?=($search=="")?"":"&search=$search&qtype=$searchType"?>"><?=$i?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <div class="posts text-bg-primary ps-1">
                    <div class="id">#</div>
                    <div class="name">作者名稱</div>
                    <div class="title">文章標題</div>
                    <div class="post_content">文章內容</div>
                    <div class="restaurant_name">餐廳名稱</div>
                    <div class="createTime">發文日期</div>
                    <div class="editing_date">更新日期</div>
                    <div class="editing">修改刪除</div>
                </div>
                <?php foreach($rows as $index => $row): ?>
                <div class="posts my-1">
                    <div class="id"><?=$row["post_ID"]?></div>
                    <div class="name"><?=$row["nickname"]?></div>
                    <div class="title"><?=$row["post_title"]?></div>
                    <div class="post_content"><?=$row["post_content"]?></div>
                    <div class="restaurant_name"><?=$row["updating_restaurant_name"]?></div>
                    <div class="createTime"><?=$row["create_time"]?></div>
                    <div class="editing_date"><?=$row["editing_date"]?></div>
                    <div class="editing">
                    <span class="btn btn-danger btn-sm btn-del" idn="<?=$row["post_ID"]?>">刪除</span>
                    <a href="./post_ModifyArticle.php?id=<?=$row["post_ID"]?>" class="btn btn-primary btn-sm">修改</a>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <?php elseif($msgNum == 0): ?>
            目前沒有資料。
            <?php else: ?>
            發生錯誤: <?=$errorMsg?>  
            <?php endif; ?>
        </div>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script>
            const btnDels = document.querySelectorAll(".btn-del");
            [...btnDels].map(function(btnDel){
            btnDel.addEventListener("click", function(){

            let post_ID = parseInt(this.getAttribute("idn"));
            if(window.confirm("確定要刪除嗎？")===true){
                window.location.href = `./post_Delete.php?post=${post_ID}`;
            }
            })
            })
            const btnSearch = document.querySelector(".btn-search");
            btnSearch.addEventListener("click",function(){
            let query = document.querySelector("input[name=search]").value;
            let queryType = document.querySelector("input[name=searchType]:checked").value;
            window.location.href = `./post_Articlelist.php?search=${query}&qtype=${queryType}`;
            })
        </script>
    </body>
</html>