<?php

// $_POST为关联阵列，列印出来看有没有成功submit
if(empty($_POST["name"])){
die("Name is required");
}
else if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
    die("E-mail is not valid");
}
else if(strlen($_POST["password"]) < 6){
    die("Password must be at least 6 characters") ;
}
else if(!preg_match("/[a-z]/i",$_POST["password"])){
    die ("Password must contain at least one letter");
}
else if(!preg_match("/[0-9]/",$_POST["password"])){
    die ("Password must contain at least one number");
}
else if($_POST["password"] !== $_POST["password_confirmation"]){
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"],PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/../database.php";
// 解决相对路径问题

$sql = "INSERT INTO restaurant_user (restaurant_name,restaurant_password_hash,	restaurant_email) VALUES (?,?,?)";

$stmt = $mysqli ->  stmt_init();
// 这边不懂,说到底为什么要exit呢!!!!!
// 这边是insert a new record做的很多sql注入的安全预处理
if(!$stmt-> prepare($sql)){
    die("SQL error:". $mysqli->error);
}

$stmt -> bind_param("sss",$_POST["name"],$password_hash,$_POST["email"]);

try {
    if ($stmt->execute()) {
        header("Location: signupSuccess.html");
        exit;
    } 
} catch (mysqli_sql_exception $exception) {
    die("Signup failed: " . $exception->getMessage());
}
// 显示资料库错误，如果没有问题才执行try转跳注册成功

// if($stmt -> execute()){
//     echo "Signup successful";
// }else{
//     die($mysqli->error . " " . $mysqli->errno);
// }
// 要记得执行execute啊大哥,這個是影片的範例，他的錯誤訊息不如預期，所以改用ben老師的錯誤訊息傳遞



?>