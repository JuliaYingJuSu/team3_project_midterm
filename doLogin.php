<?php
session_start();
require_once("./connect.php");

if(!isset($_POST["email"])){
    alertgoBack("請透過正常方式進入");
    exit;
  }


$useremail = $_POST["email"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];

$msg="";
$sql="SELECT * FROM `user` WHERE `user_email` = '$useremail';";

try{
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    if($result->num_rows>0){
        if(password_verify($password1, $row["user_password"])){
            // $msg=true;
        }else{
            $msg="不要再試惹!!";
        }
    }else{
        $msg="沒有這個人!!";
    }
  }catch (mysqli_sql_exception $exc) {
    $msg= "請洽錯誤請洽管理人員";
  }

if($msg !==""){
    alertgoBack($msg);
}

$_SESSION["user"]=[
    "email"=>$row["email"],
    "name"=>$row["name"],
];

header("location:./list.php");

function alertgoBack($msg){
    echo "<script>
            alert(\"$msg\")
                window.history.back();
        </script>";
    exit;
}