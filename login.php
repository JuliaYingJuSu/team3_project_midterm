<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>登入頁面</title>
    <style>
        .block{
                width: 300px;
                height: 250px;
        }        
    </style>
</head>

<body>
    <div class="block bg-primary-subtle p-3 position-absolute start-0 end-0 m-auto rounded-2 mt-5">
        <h1>登入</h1>
            <form action="./doLogin.php" method="post">
                <input type="text" name="email" class="form-control mb-1" placeholder="使用者帳號">
                <input type="password" name="password1" class="form-control mb-1" placeholder="使用者密碼">
                <input type="password" name="password2" class="form-control mb-1" placeholder="再輸入一次使用者密碼">
                <div class="text-end">
                <button class="btn btn-info btn-send me-1">送出</button>
                <a class="btn btn-info btn-send">註冊</a>
                </div>
            </form>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>