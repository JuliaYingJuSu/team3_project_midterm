<!-- 上傳多張圖片用 -->

<?php
require_once("./connect.php");

if(!isset($_GET["id"])){
    echo "走開";
    exit;
}


if(!isset($_GET["id"])){
  exit;
 }else{
     $id= $_GET["id"];
 }

// $showed_1st = $_POST["showed_1st"];

$sql="";
$timestamp = time();
$fileCount = count($_FILES["myFile"]["name"]);
for($i=0;$i<$fileCount;$i++){
if($_FILES["myFile"]["error"][$i] == 0){
    $ext = pathinfo($_FILES["myFile"]["name"][$i],PATHINFO_EXTENSION);
    $file = ($timestamp + $i).".".$ext;
    $result = move_uploaded_file($_FILES["myFile"]["tmp_name"][$i],"./img/".$file);
    $pathFile = $file;
    if($result){
        $sql.="INSERT INTO `product_img` (`product_img_id`, `product_id`, `product_img`, `showed_1st`) VALUES (NULL, '$id', '$pathFile', '0');";
    }
}   
}
// $sql2="UPDATE `product_img` SET `showed_1st` = $showed_1st WHERE `product_img`.`product_img_id` = $id;";
// var_dump($sql);
// exit;

try{
    $conn->multi_query($sql);
    // $conn->multi_query($sql2);

  }catch(mysqli_sql_exception $exc){
    echo "圖片新增失敗" .$exc->getmessage();
  }
  $conn->close();

  
echo "<script>
alert (\"圖片新增成功\");
window.location.href = \"./updateOO.php?id=$id\"
</script>";

