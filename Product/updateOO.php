<!-- 按修改完跳轉的修改留言頁 -->

<?php
require_once("./connect.php");

if(!isset($_GET["id"])){
 exit;
}else{
    $id= $_GET["id"];
}

$sql="SELECT * FROM `product` WHERE product_id = $id;";
$sql2="SELECT * FROM `product_type`;";
$sql3="SELECT * FROM `product_type_list`;";
// $sql3="SELECT * FROM `imgs` WHERE `msgID` = $id;";

try{
    $result =$conn->query($sql);
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);
    // $result3 = $conn->query($sql3);
    $row= $result->fetch_assoc();
    $row2s = $result2->fetch_all(MYSQLI_ASSOC);
    $row3s = $result3->fetch_all(MYSQLI_ASSOC);

  }catch(mysqli_sql_exception $exc){
    die("讀取失敗" .$exc->getmessage());
  }

// var_dump($result3);

  $conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>修改商品</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        .img{
            width:200px;
            height:200px;
            object-fit:cover;
        }
    </style>
</head>

<body>
    <div class="container mt-3">

        <form action="./doUpdate.php" method="post" enctype="multipart/form-data">
            <!-- 讓doUpdate的$_POST["id"]抓得到東西 -->
            <input type="hidden" name="id" value="<?=$id?>"> 

            <div class="input-group">
                <span class="input-group-text">品名</span>
                <input name="name" type="text" class="form-control" placeholder="發文者名稱" value="<?=$row["product_name"]?>">
            </div>
            <div class="input-group">
                <span class="input-group-text">價錢</span>
                <input name="price" type="text" class="form-control" placeholder="發文者名稱" value="<?=$row["price"]?>">
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">介紹</span>
                <textarea name="description" class="form-control"><?=$row["product_description"]?></textarea>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">規格</span>
                <textarea name="specification" class="form-control"><?=$row["specification"]?></textarea>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">分類</span>
                <select name="type" id="type1" class=" form-select">
                    <option value disabled <?=($row["product_type_id"]===NULL)?"selected":""?>>請選擇</option>
                
                    <?php foreach($row2s as $row2): ?>
                        <option value="<?=$row2["product_type_id"]?>" <?=($row["product_type_id"] == $row2["product_type_id"])?"selected":""?> ><?=$row2["product_type_name"]?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">次分類</span>
                <select name="typeList" id="typeList1" class=" form-select">
                    <!-- product裡的product_type_list_id沒有值的話顯示請選擇 -->
                    <option value disabled <?=($row["product_type_list_id"]===NULL)?"selected":""?>>請選擇</option>

                    <?php foreach($row3s as $row3): ?>
                        <option value="<?=$row3["product_type_list_id"]?>" <?=($row["product_type_list_id"] == $row3["product_type_list_id"])?"selected":""?> ><?=$row3["product_type_list_name"]?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group mt-1">
                    <input class="form-control" type="file" name="myFile" accept=".png,.jpg,.jpeg">
            </div>
            
            <div class="mt-1 text-end">
                    <button type="submit" class="btn btn-info">送出</button>
            </div>
        </form>

         <!-- <form id="form2" class="mt-5 p-2 bg-primary-subtle" method="post" action="./doAddImg.php" enctype="multipart/form-data">
            <div class="contentArea">
                
                <div class="input-group mt-1">
                <input class="form-control" type="file" name="imgFile[]" accept=".png,.jpg,.jpeg">
                </div>
                
            </div>
            <input type="hidden" name="msgID" value="<?=$id?>">
            <div class="mt-1 text-end">
                <button type="submit" class="btn btn-info btn-save">寫入 img 資料庫</button>
                <button class="btn btn-primary btn-add">增加一組</button>
            </div>
        </form>
        <img src="../img/<?=$row["img"]?>" alt="" class="img">

        <?php foreach($row3s as $row3): ?>
        <img src="../img/<?=$row3["file"]?>" alt="" class="img">
        <?php endforeach; ?> -->
    </div>


        <template id="inputs">
        <div class="input-group mt-1">
            <input class="form-control" type="file" name="imgFile[]" accept=".png,.jpg,.jpeg">
        </div>
        </template>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous">
    </script>
    <script>
        
        //動態下拉選單
        let typeSelect=document.querySelector("#type1");
        let typeListSelect=document.querySelector("#typeList1");
        
        typeSelect.addEventListener("change",(e)=>{
            // console.log(e.target.value); 抓到大分類被選的值 1.2.3.4...
            
            // 清空次分類的select元素
            typeListSelect.innerHTML='<option value selected disabled>請選擇</option>';
            
            // 大分類被選的值塞進變數
            let selectedTypeID =e.target.value;
            // 次分類的每一筆值拿起來看，如果裡面的大分類ID跟選到的數字一樣， 就新增<option>把次分類ID跟名稱設進<option>，再把<option>放進次分類的<select>
            <?php foreach($row3s as $row3): ?>
                if (selectedTypeID === '<?=$row3["product_type_id"]?>'){
                    let option = document.createElement("option");
                    option.value ='<?=$row3["product_type_list_id"]?>';
                    option.text = '<?=$row3["product_type_list_name"]?>';
                    typeListSelect.appendChild(option);                
                }
            <?php endforeach; ?>
        })

      
    </script>

</body>

</html>