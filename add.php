<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>新增表單</title>
</head>
<body>
    <div class="container mt-5">
        <form action="./doadd.php" method="post">
            <h2 class="fw-bold my-3">新增使用者</h2>
        <div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold">email</span>
                <input name="email" type="text" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold">姓名</span>
                <input name="name" type="text" class="form-control" placeholder="請輸入">
            </div><div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold">密碼</span>
                <input name="password" type="password" class="form-control" placeholder="請輸入">
            </div><div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text text-light bg-primary fw-bold">再輸入一次密碼</span>
                <input name="password2" type="password" class="form-control" placeholder="請輸入">
            </div>
            <div class="mt-1 text-end">
                <button type="reset" class="btn btn-danger fw-bold">清除</button>
                <button type="submit" class="btn btn-primary btn-send fw-bold">送出</button>
            </div>
        </form>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>