<?php
require_once("./connect.php");

if(!isset($_GET["id"])){
    exit;
    }
    else {
     $id=$_GET["id"];  
    }

$sql = "SELECT * FROM `user` WHERE `user_id`=$id;";

  try {
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
  } catch (mysqli_sql_exception $exc){
    die ("讀取失敗" .$exc->getMessage());
  }

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>表單</title>
</head>

<body>
    <div class="border container mt-5 rounded bg-white">
        <div class="d-flex my-2 mt-3">
            <h2 class="fw-bold">修改會員資料</h2>
                <span class="btn btn-warning btn-sm fw-bold ms-2 mt-1 mb-3">會員</span>
                <span class="fs-5 ms-auto fw-bold border rounded-4 p-2 bg-primary mb-1 text-light">
                    最後修改時間:<?=$row["updatetime"];?></span>
        </div>    
        <form action="./doUpdate.php" method="post" enctype="multipart/form-data">
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4">email</span>
                <input name="email" type="text" class="form-control" value="<?=$row["user_email"];?>" disabled readonly>
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4">姓名</span>
                <input name="name" type="text" class="form-control" value="<?=$row["user_name"];?>">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4">暱稱</span>
                <input name="nickname" type="text" class="form-control" value="<?=$row["nickname"];?>">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4">手機</span>
                <input name="phone" type="text" class="form-control" value="<?=$row["user_phone"];?>">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4">密碼</span>
                <input name="password" type="password" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4">再輸入一次密碼</span>
                <input name="password2" type="password" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <div class="d-flex">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4">喜愛的食物種類</span>
                    <input type="checkbox" class="btn-check" id="btn-check-1" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-1">台式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-2" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-2">中式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-3" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-3">日式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-4" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-4">韓式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-5" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-5">港式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-6" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-6">美式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-7" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-7">義式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-8" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-8">法式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-9" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-9">西式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-10" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-10">泰式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-11" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-11">越式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-12" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-12">火鍋</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-13" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-13">燒烤</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-14" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-14">牛排</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-15" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-15">熱炒</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-16" name="likefoodtag[]">
                </div>
                <div class="d-flex mt-2">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-16">素食</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-17" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-17">飲品</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-18" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-18">酒吧</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-19" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-19">果汁</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-20" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-20">咖啡</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-21" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-21">茶</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-22" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-22">炸物</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-23" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-23">吃到飽</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-24" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-24">小吃</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-25" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-25">甜點</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-26" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-26">冰品</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-27" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-27">麵食</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-28" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-28">壽司</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-29" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-29">義大利麵</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-30" name="likefoodtag[]">
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-30">海鮮</label><br>
                </div>
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4">自我簡介</span>
                <textarea class="form-control" rows="3"><?=$row["self_intr"];?></textarea>
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4">創建帳號時間</span>
                <input name="phone" type="text" class="form-control" value="<?=$row["create_date"];?>" disabled readonly>
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold rounded-start-4" disabled readonly>最後上線時間</span>
                <input name="phone" type="text" class="form-control" value="<?=$row["last_login_time"];?>" disabled readonly>
            </div>
            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-lg btn-primary btn-send fw-bold">送出</button>
            </div>
        </form>
        
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script>
        // const btn_add = document.querySelector(".btn-add");
        // const contentArea = document.querySelector(".contentArea");
        // const template = document.querySelector("#inputs");
        //     btn_add.addEventListener("click", function(e) {
        //         e.preventDefault();
        //         const node = template.content.cloneNode(true);
        //         contentArea.append(node);
        // });
    </script>
</body>

</html>