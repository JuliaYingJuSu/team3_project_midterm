<?php
require_once("./connect.php");

if(!isset($_POST["name"])){
    echo "走開";
    exit;
}
$id=$_POST["id"];

$name = $_POST["name"];
$price= $_POST["price"];
$desc = $_POST["description"];
$spec = $_POST["specification"];
$type = $_POST["type"];
$typeList = $_POST["typeList"];
$discount = $_POST["discount"];

// $count = count($nameValues);
// $endWording = ($count>1)?"多筆":"";


// X
if(empty($name)){
    echo "寫名字!";
    echo "<button onclick='goback()'>回上一頁</button>";
    echo "<script>
    function goback(){
        window.history.back();
    }
    </script>";
     // window物件的history物件的back()方法
    exit;
}

// V
if($content ===""){

    echo "<script>
    alert(\"請輸入留言\");
    window.history.back();
    </script>";
    exit;
}

// $img = "";
// if($_FILES["myFile"]["error"] == 0){
//     $ext = pathinfo($_FILES["myFile"]["name"],PATHINFO_EXTENSION);
//     $timestamp = time();
//     $file = $timestamp.".".$ext;
//     $result = move_uploaded_file($_FILES["myFile"]["tmp_name"],"../img/".$file);
//     echo "222";
//     if($result){
//         $img = $file;
//     }
// }


// if($img == ""){
    if($discount == ""){
    $sql="UPDATE product SET 
        `product_name` = '$name',
        `price` = $price, 
        `product_description` = '$desc',
        `specification` = '$spec', 
        `product_type_id` = '$type', 
        `product_type_list_id` = '$typeList'
        WHERE product_id = $id;";
// }else{
}else{
    // $sql="UPDATE product SET 
    //     `product_name` = '$name',
    //     `price` = $price, 
    //     `product_description` = '$desc',
    //     `specification` = '$spec', 
        
    //     `img` = '$img',
        
    //     `product_type_id` = '$type', 
    //     `product_type_list_id` = '$typeList',
    //     `discount_rate_id` = '$discount',
    //     WHERE product_id = $id;";
    $sql="UPDATE product SET 
        `product_name` = '$name',
        `price` = $price, 
        `product_description` = '$desc',
        `specification` = '$spec', 
        `product_type_id` = '$type', 
        `product_type_list_id` = '$typeList',
        `discount_rate_id` = '$discount'
        WHERE product_id = $id;";
// }
}

try{
    $conn->query($sql);
   $msg="修改成功!!!";
  }catch(mysqli_sql_exception $exc){

    $msg="修改失敗" .$exc->getmessage();
  }

  $conn->close();

echo "<script>
alert (\"$msg\");
window.location.href = \"./list.php\"
</script>";