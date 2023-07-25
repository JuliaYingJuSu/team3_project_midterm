<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>新增表單</title>
</head>
<body>
    <div class="container mt-3">
        <form action="./doadd.php" method="post">
        <div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text">email</span>
                <input name="email" type="text" class="form-control">
            </div>
            <div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text">姓名</span>
                <input name="name" type="text" class="form-control" placeholder="發文者名稱">
            </div><div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text">密碼</span>
                <input name="password" type="password" class="form-control" placeholder="請輸入">
            </div><div class="input-group">
                <input name="id" type="hidden" value="<?=$id?>">
                <span class="input-group-text">再輸入一次密碼</span>
                <input name="password2" type="password" class="form-control" placeholder="請輸入">
            </div>
            <div class="mt-1 text-end">
                <button type="submit" class="btn btn-info btn-send">送出</button>
            </div>
        </form>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>