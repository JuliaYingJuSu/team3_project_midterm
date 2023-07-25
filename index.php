<?php
// index主页用来表示登入状态
session_start();
// print_r($_SESSION);

if(isset($_SESSION["user_id"])){
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM `restaurant_user` WHERE `restaurant_id` = {$_SESSION["user_id"]}";

    $result = $mysqli -> query($sql);

    $user = $result -> fetch_assoc();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>

<body>
    <h1>Home</h1>

    <?php if (isset($user)):?>

    <p class="fs-2 text-primary">Hello <?= htmlspecialchars($user["restaurant_name"])?></p>

    <div>
        
    </div>










    <?php if(empty($user["restaurant_address"])):?>
                    <a class="text-danger mx-2" href="#">请继续完善你的资料!</a>
                <?php endif;?>

    <a class="btn btn-info btn-sm" href="./loginSignup/logout.php">Log out</a>

    <?php else: ?>

        <p><a href="./loginSignup/login.php">Log in</a> or <a href="./loginSignup/signUp.html"> Sign up</a></p>

    <?php endif;?>

    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>