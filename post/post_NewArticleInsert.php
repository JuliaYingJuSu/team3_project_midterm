<?php
require_once("../connect.php");

if(!isset($_POST["name"])){
  echo "請由正式方法進入頁面";
  exit;
}

$id =$_POST["id"];
$name = $_POST["name"];
$content = $_POST["content"];
$updating_restaurant_ID = $_POST["updating_restaurant_ID"];
$restaurant_name = $_POST["updating_restaurant_name"];
$post_ID=$_POST["post_ID"];

$img = "";
if($_FILES["myFile"]["error"] == 0){
  $ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
  $timestamp = time();
  $file = $timestamp ."." .$ext;
  $result = move_uploaded_file($_FILES["myFile"]["tmp_name"], "./img/" .$file);
  if($result){
    $img = "./img/" .$file;
  }
}

$sql ="INSERT INTO `post` 
  (`post_ID`, `post_title`, `post_content`, `img`,`updating_restaurant_ID`, `restaurant_name`, `price_range_ID`, `create_time`, `user_ID`, `editing_date`, `flag_ID`, `isValid`) 
  VALUES 
  (NULL, '$name', '$content', '$img','$updating_restaurant_ID', '$restaurant_name', NULL, current_timestamp(), 22, NULL, '1', '1');";
$sql1 = "select scope identity();";

$sql2 = "INSERT INTO `postimage` 
(`postimage_ID`, `post_ID`, `postimage_name`) 
VALUES 
(NULL, '$post_ID', '$img')";




try {
  $conn->query($sql);
  $conn->query($sql1);
  $conn->query($sql2);
  echo "資料新增成功";
} catch (mysqli_sql_exception $exception) {
  echo "資料新增錯誤：" .$exception->getMessage();
}
$conn->close();

echo "<script>
    alert(\"資料新增成功\")
    window.location.href = \"./post_ArticleList.php\";
    </script>";

function alertGoBack(){
    echo "<scrip>
    alert(\"新增錯誤\");
    window.history.back();
    </script>";
}

?>


