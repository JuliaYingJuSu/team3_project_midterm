<?php
require_once("./connect.php");

if(!isset($_GET["id"])){
    echo "請由正常管道進入";
    exit;
}else{
    $id = $_GET["id"];
}

$sql = "SELECT * FROM `post` join `updating_restaurant` on post.updating_restaurant_ID = updating_restaurant.updating_restaurant_ID WHERE `post_ID` = $id;";
$sql2 ="SELECT * FROM `postimage` WHERE `postID`= $id;";


try{
  $result = $conn->query($sql);
  $result2 = $conn->query($sql2); 
  $rows = $result->fetch_all(MYSQLI_ASSOC);
  $row2s = $result2->fetch_all(MYSQLI_ASSOC);
  
}catch(mysqli_sql_exception $exc){
  die("讀取失敗：" .$exc->getMessage());
}
$conn->close();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <style>
        .img{
            width: 200px;
            height: 200px;
            object-fit: cover;
        }
        
        </style>
        <title>修改文章</title>
    </head>
    <body>
        <div class="container mt-3">        
          <form action="./post_Update.php" method="post" enctype="multipart/form-data">
              <input name="id" type="hidden" value="<?=$id?>">
              <div class="input-group">
                <span class="input-group-text">文章標題</span>
                <input name="name" type="text" class="form-control" placeholder="請重新輸入文章標題" value="<?=$row["name"]?>">
              </div>
              <div class="input-group mt-1">
                <span class="input-group-text">文章內容</span>
                <textarea name="content" class="form-control"><?=$row["content"]?></textarea>
              </div>
              <div class="input-group mt-1">
                <span class="input-group-text">餐廳名稱</span>
                <select name="updating_restaurant_name" class="form-select">
                        <?php foreach($rows as $row): ?>
                            <option selected value="<?=$row["updating_restaurant_ID"]?>"><?=$row["updating_restaurant_name"]?></option>
                        <?php endforeach; ?>
                </select>
              </div>
              <div class="input-group mt-1">
                <input class="form-control" type="file" name="myFile" accept=".png,.jpg,.jpeg">
              </div>
              <div class="mt-1 text-end">
                <button type="submit" class="btn btn-primary">送出</button>
              </div>
          </form>
        </div>
        <form id="form2" class="mt-5 p-2 bg-primary-subtle" method="post" action="./post_ImageInsert.php?id=<?=$id?>" enctype="multipart/form-data">
            <!-- <div class="contentArea">
                <div class="input-group mt-1">
                    <input class="form-control" type="file" name="imgFile[]" accept=".png,.jpg,.jpeg">
                </div>
            </div>
            <input type="hidden" name="postID" value="<?=$id?>">
            <div class="mt-1 text-end">
                <button type="submit" class="btn btn-primary btn-save">新增圖檔</button>
                <button class="btn btn-primary btn-add">+</button>
            </div> -->
            <div class="myFiles">
          <div class="input-group mt-1">
            <input class="form-control" type="file" name="myFile[]" accept=".png,.jpg,.jpeg">
            <div class="btn btn-info btn-add-file">+</div>
          </div>
        </div>
      <div class="mt-1 text-end">
        <button type="submit" class="btn btn-primary btn-send">新增圖檔</button>
         
        </form>
        <div class="photo d-flex">
          <img src="<?=$row["img"]?>" alt="" class="img">
        <?php foreach($row2s as $row2): ?>
          <img src="<?=$row2["file"]?>" alt="" class="img">
        <?php endforeach; ?>
        </div>
      
        <div class="product">
          <?php foreach($files as $index => $file): ?>
            <img class="pimg delImg" src="../pimg/<?=$file?>" pid="<?=$id?>" idn="<?=$fileIDs[$index]?>" alt="">

          <?php endforeach; ?>
        </div> 
        </div>
        <template id="myFile">
          <div class="input-group mt-1 pdUnit">
              <input class="form-control" type="file" name="imgFile[]" accept=".png,.jpg,.jpeg">
              <div class="btn btn-danger btn-del-file">-</div>
          </div>
    </div>
    </div>
        
        </template>
      <script src="../js/bootstrap.bundle.min.js"></script>
      <script>
        // const btn_add = document.querySelector(".btn-add");
        // const contentArea = document.querySelector(".contentArea");
        // const template = document.querySelector("#inputs");
        // btn_add.addEventListener("click", function(e) {
        //     e.preventDefault();
        //     const node = template.content.cloneNode(true);
        //     contentArea.append(node);
        // });
        const btnAddFile = document.querySelector(".btn-add-file");
        const myFiles = document.querySelector(".myFiles");
        btnAddFile.addEventListener("click", function(e){
        e.preventDefault();
        let template = document.querySelector("#myFile");
        let dom = template.content.cloneNode(true);
        removeEvent();
        myFiles.append(dom);
        setDelFileBtn();
      })

        function removeEvent(){
        const btnDelFiles = document.querySelectorAll(".btn-del-file");
        [...btnDelFiles].map(function(btn){
          btn.removeEventListener("click", _aa);
        });
      }

        function setDelFileBtn(){
        const btnDelFiles = document.querySelectorAll(".btn-del-file");
        [...btnDelFiles].map(function(btn){
          btn.addEventListener("click", _aa);
        });
      }
        function _aa(e){
        let tg = e.currentTarget;
        let dom = tg.closest(".pdUnit");
        dom.remove();
      }

      </script>
    </body>
</html>