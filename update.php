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