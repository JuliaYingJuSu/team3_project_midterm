<!-- 上傳多張圖片用 -->

<?php
require_once("./connect.php");

// if(!isset($_POST["msgID"])){
//     echo "走開";
//     exit;
// }

if(!isset($_GET["id"])){
  exit;
 }else{
     $id= $_GET["id"];
 }

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

try{
    $conn->multi_query($sql);
    echo "資料表 msgs 修改完成";
  }catch(mysqli_sql_exception $exc){
    echo "修改資料表失敗" .$exc->getmessage();
  }
  $conn->close();

  
echo "<script>
alert (\"資料$msg 新增成功\");
window.location.href = \"./list.php\"
</script>";


