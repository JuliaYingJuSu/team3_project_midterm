<!-- 可同時新增多筆資料更新資料庫 -->
<?php
require_once("./connect.php");

$sql="SELECT * FROM `product_type`";
$sql2nd="SELECT * FROM `product_type_list`";

// $sql2nd="SELECT product_type_list_id,product_type_list_name 
// FROM `product_type_list` JOIN `product_type` 
// ON product_type_list.product_type_id = product_type.product_type_id
// WHERE product_type_list.product_type_id = 1;
// ";

try{
    $result = $conn->query($sql);
    $result2nd = $conn->query($sql2nd);
    //將結果取出為關聯式陣列
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $rows2nd = $result2nd->fetch_all(MYSQLI_ASSOC);

    $count = count($rows);
    $count2nd = count($rows2nd);
    
  }catch(mysqli_sql_exception $exc){
  }
  $conn->close();
  ?>

<!doctype html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>新增商品</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <div class="container mt-3">
            <form action="./doAdd.php" method="post" enctype="multipart/form-data">
                <div class="contentArea">
                    <div class="input-group mt-2">
                        <span class="input-group-text">商品名稱</span>
                        <input name="name[]" type="text" class="form-control" placeholder="商品名稱">
                    </div>
                    <div class="input-group mt-2">
                        <span class="input-group-text">價格</span>
                        <input name="price[]" type="text" class="form-control" placeholder="價格">
                    </div>
                    <!-- <div class="input-group mt-1">
                        <input class="form-control" type="file" multiple="multiple" name="myFile[]" accept=".png,.jpg,.jpeg">
                    </div> -->
                    <div class="input-group mt-1">
                        <span class="input-group-text">介紹</span>
                        <textarea name="description[]" class="form-control"></textarea>
                    </div>
                    <div class="input-group mt-1">
                        <span class="input-group-text">規格</span>
                        <textarea name="specification[]" class="form-control"></textarea>
                    </div>
                    <div class="input-group mt-1">
                        <span class="input-group-text">分類</span>
                        <select  id="type1" name="type[]" class="form-select">
                            <option value selected disabled>請選擇</option>
                            <?php foreach($rows as $row): ?>
                                <option value="<?=$row["product_type_id"]?>"><?=$row["product_type_name"]?></option>
                            <?php endforeach; ?>        
                        </select>
                        </div>
                    <div class="input-group mt-1">
                        <span class="input-group-text">次分類</span>
                        <select id="typeList1" name="typeList[]" class="form-select">
                            <option value selected disabled>請選擇</option>
                            
                            <?php foreach($rows2nd as $row2nd): ?>
                                <option value="<?=$row2nd["product_type_list_id"]?>"><?=$row2nd["product_type_list_name"]?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

            </div>
            <div class="mt-1 text-end">
                <button type="submit" class="btn btn-info btn-send">送出</button>
                <button class="btn btn-info btn-add ">增加一組</button>
            </div>
        </form>
    </div>
<template id="inputs">
<div class="contentArea">
                <div class="input-group mt-2">
                    <span class="input-group-text">商品名稱</span>
                    <input name="name[]" type="text" class="form-control" placeholder="商品名稱">
                </div>
                <div class="input-group mt-2">
                    <span class="input-group-text">價格</span>
                    <input name="price[]" type="text" class="form-control" placeholder="價格">
                </div>
                <!-- <div class="input-group mt-1">
                    <input class="form-control" type="file" multiple="multiple" name="myFile[]" accept=".png,.jpg,.jpeg">
                </div> -->
                <div class="input-group mt-1">
                    <span class="input-group-text">介紹</span>
                    <textarea name="description[]" class="form-control"></textarea>
                </div>
                <div class="input-group mt-1">
                    <span class="input-group-text">規格</span>
                    <textarea name="specification[]" class="form-control"></textarea>
                </div>
                <div class="input-group mt-1">
                        <span class="input-group-text">分類</span>
                        <select  id="type1" name="type[]" class="form-select">
                            <option value selected disabled>請選擇</option>
                            <?php foreach($rows as $row): ?>
                                <option value="<?=$row["product_type_id"]?>"><?=$row["product_type_name"]?></option>
                            <?php endforeach; ?>        
                        </select>
                        </div>
                    <div class="input-group mt-1">
                        <span class="input-group-text">次分類</span>
                        <select id="typeList1" name="typeList[]" class="form-select">
                            <option value selected disabled>請選擇</option>
                            
                            <?php foreach($rows2nd as $row2nd): ?>
                                <option value="<?=$row2nd["product_type_list_id"]?>"><?=$row2nd["product_type_list_name"]?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

            </div>
</template>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

    <script>
        const btn_add = document.querySelector(".btn-add");
        const btn_send = document.querySelector(".btn-send");
        const form = document.querySelector("form");
        const contentArea = document.querySelector(".contentArea");
        btn_add.addEventListener("click", function (e) {
            //避免按新增按鈕的時候直接做送出動作
            e.preventDefault();
            let template = document.querySelector("#inputs");
            let node = template.content.cloneNode(true);
            
            contentArea.append(node);
    
        });
        // btn_send.addEventListener("click", function (e) {
        //     e.preventDefault();
        //     let files =  document.querySelectorAll("input[type=file]");
        //     let fileCheck = false;
        //         // 總項files單項file
        //     files.forEach(function(file){
        //         if(file.value == ""){
        //             fileCheck = true;
        //         }
        //     });

        //     if(fileCheck == true){
        //         alert("請選擇圖片！");
        //     }else{
        //         form.submit();
        //     }
        // });
        let typeSelect=document.querySelector("#type1");
        let typeListSelect=document.querySelector("#typeList1");

        typeSelect.addEventListener("change",(e)=>{
            // console.log(e.target.value); 抓到大分類被選的值 1.2.3.4...
            
            // 清空次分類的select元素
            typeListSelect.innerHTML='<option value selected disabled>請選擇</option>';

            // 大分類被選的值塞進變數
            let selectedTypeID =e.target.value;

            // 次分類的每一筆值拿起來看，如果裡面的大分類ID跟選到的數字一樣，
            // 就新增<option>把次分類ID跟名稱設進<option>，再把<option>放進次分類的<select>
            <?php foreach($rows2nd as $row2nd): ?>
                if (selectedTypeID === '<?=$row2nd["product_type_id"]?>'){
                    let option = document.createElement("option");
                    option.value = '<?=$row2nd["product_type_list_id"]?>';
                    option.text = '<?=$row2nd["product_type_list_name"]?>';
                    typeListSelect.appendChild(option);                
                }
            <?php endforeach; ?>

        })


    </script>
</body>

</html>