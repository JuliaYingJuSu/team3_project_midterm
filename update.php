<?php
require_once("../connect.php");

if(!isset($_GET["id"])){
    exit;
    }
    else {
     $id=$_GET["id"];  
    }

$sql = "SELECT * FROM `user` WHERE id=$id;";

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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>表單</title>
    <style>
        img{
            width:200px;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="border container mt-5 rounded bg-white">
        <h2>修改會員資料
            <span class="btn btn-info btn-sm">會員</span>
        </h2>
        <form action="./doUpdate.php" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text">email</span>
                <input name="email" type="text" class="form-control"  value="<?=$row["email"];?>" readonly>
            </div>
            <div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text">姓名</span>
                <input name="name" type="text" class="form-control" placeholder="發文者名稱" value="<?=$row["name"];?>">
            </div><div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text">密碼</span>
                <input name="password" type="password" class="form-control" placeholder="請輸入">
            </div><div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text">再輸入一次密碼</span>
                <input name="password2" type="password" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text">level</span>
                <input max="9" min="1" name="level" type="number" class="form-control" placeholder="level" value="<?=$row["level"];?>">


            <div class="mt-1 text-end">
                <button type="submit" class="btn btn-info">送出</button>
            </div>
        </form>
        
    <script src="../js/bootstrap.bundle.min.js"></script>
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