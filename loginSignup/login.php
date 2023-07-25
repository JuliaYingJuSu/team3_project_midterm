<?php 
$is_invalid = false;

if($_SERVER["REQUEST_METHOD"] === "POST"){
    // 如果为post进行资料库连接
    $mysqli = require __DIR__ . "/../database.php";
    // 注意这个路径，会死人的

    $sql = sprintf("SELECT * FROM `restaurant_user` WHERE restaurant_email = '%s'",
    $mysqli -> real_escape_string($_POST["email"]));

    $result = $mysqli -> query($sql);
    // %s是占位符，最后回传转义后的email给sql语法，透过email抓取该笔资料，email登录

    $user = $result -> fetch_assoc();
    // 确认该笔email有资料

    if($user){
        if(password_verify($_POST["password"], $user["restaurant_password_hash"])){
            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["restaurant_id"];
            // 确保抓取用户资料及验证后记录会话阶段保持登录状态跳转index
            // 你其实搞不太懂session_start和session的运用
            header("Location: ../index.php");
            exit;
        }
    }
    // die了is_invalid不会继续执行
    $is_invalid = true;
}
// 回头看看能不能不使用nest if



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BS530 Template</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/signup.css">
</head>

<body>
    <h1 class="text-center my-3">Log in</h1>

    <?php if($is_invalid): ?>
        <p class="fst-italic text-center text-danger">Invalid Login</p>
    <?php endif; ?>

    <div class="loginbox border border-info-subtle rounded bg-light ">
        <form  method="post">
            <div class="d-flex flex-column">
                <label for="email">Email:</label>
                <input class="my-3 rounded" type="email" id="email" name="email" value=<?=htmlspecialchars($_POST["email"]??"") ?>>
                <!-- ??""是判断左侧为null则使用右侧，用户没有输入emial的时候则为“” -->
            </div>
            <div class="d-flex flex-column">
                <label for="password">Password</label>
                <input class="my-3 rounded" type="password" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-info my-3">Log in</button>
    </div>
    </form>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>