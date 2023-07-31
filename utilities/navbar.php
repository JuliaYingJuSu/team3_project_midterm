<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: ../User/login.php");
}

require("../connect.php");
$webpage = "";
if (isset($_GET["webpage"])) {
    $webpage = $_GET["webpage"];
}


?>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,	initial-scale=1">
    <title>選單</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand ms-5 text-light fw-bold fs-3" href="#">
                <img src="../img/logo.png" alt="Logo" width="110" height="80" class="d-inline-block">
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav fw-bold">
                    <span class="text-light d-flex align-items-center fs-5">
                        <i class="fa-solid fa-hands me-2" style="color: #ffffff;"></i>Hi~歡迎回來，
                        <?= $_SESSION["user"]["name"] ?>
                    </span>
                    <li class="nav-item dropdown pe-1">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <?php if (isset($_SESSION["user"]["img"]) && !empty($_SESSION["user"]["img"])) : ?>
                                <img src="../img/<?= $_SESSION["user"]["img"] ?>" width="60" height="60" class="d-inline-block align-text-bottom rounded-circle img-fluid">
                            <?php else : ?>
                                <img src="../img/noimg.png" width="60" height="60" class="d-inline-block align-text-bottom rounded-circle img-fluid">
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-light">
                            <li><a class="dropdown-item fw-bold" href="#">更換大頭照</a></li>
                            <li><a class="dropdown-item fw-bold" href="../User/logout.php">登出</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <div class="side-menu d-flex h-100">
        <nav class="bg-primary position-relative pt-5" style="width: 15%">
            <div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn btn-primary fs-4 fw-bold" type="button" data-bs-target="#menu1" data-bs-toggle="collapse">
                        <i class="fa-solid fa-user fa-sm me-2" style="color: #ffffff;"></i>使用者</button>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold
                    <?= ($webpage == "user_list.php") ? "active" : "" ?>" id="menu1" href="?webpage=user_list.php">
                        <i class="fa-solid fa-user-gear fa-sm me-2" style="color: #ffffff;"></i>使用者管理</a>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu1">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #ffffff;"></i>統計</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn btn-primary fs-4 fw-bold" type="button" data-bs-target="#menu2" data-bs-toggle="collapse">
                        <i class="fa-solid fa-utensils fa-sm me-2" style="color: #ffffff;"></i>餐廳</button>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu2">
                        <i class="fa-solid fa-folder fa-sm me-2" style="color: #ffffff;"></i>餐廳管理</a>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu2">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #ffffff;"></i>統計</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn btn-primary fs-4 fw-bold" type="button" data-bs-target="#menu3" data-bs-toggle="collapse">
                        <i class="fa-solid fa-bowl-rice fa-sm me-2" style="color: #ffffff;"></i>訂位</button>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu3" <?= ($webpage == "book_list.php") ? "active" : "" ?> id="menu6" href="?webpage=book_list.php">
                        <i class="fa-solid fa-folder fa-sm me-2" style="color: #ffffff;"></i>訂位管理</a>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu3">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #ffffff;"></i>統計</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn btn-primary fs-4 fw-bold" type="button" data-bs-target="#menu4" data-bs-toggle="collapse">
                        <i class="fa-solid fa-cart-shopping fa-sm me-2" style="color: #ffffff;"></i>購物車</button>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu4" <?= ($webpage == "cartPage.php") ? "active" : "" ?> id="menu6" href="?webpage=cartPage.php">
                        <i class="fa-solid fa-folder fa-sm me-2" style="color: #ffffff;"></i>購物車管理</a>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu4">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #ffffff;"></i>統計</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn btn-primary fs-4 fw-bold" type="button" data-bs-target="#menu5" data-bs-toggle="collapse">
                        <i class="fa-solid fa-store fa-sm me-2" style="color: #ffffff;"></i>商城</button>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu5" <?= ($webpage == "product_list.php") ? "active" : "" ?> id="menu5" href="?webpage=product_list.php">
                        <i class="fa-solid fa-cash-register fa-sm me-2" style="color: #ffffff;"></i>商品管理</a>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu5" <?=($webpage == "style-product_list.php") ? "active" : "" ?> id="menu5"  href="?webpage=style-product_list.php">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #ffffff;"></i>分類管理</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn btn-primary fs-4 fw-bold" type="button" data-bs-target="#menu6" data-bs-toggle="collapse">
                        <i class="fa-solid fa-camera-retro fa-sm me-2" style="color: #ffffff;"></i>食記</button>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu6" <?= ($webpage == "post_ArticleList.php") ? "active" : "" ?> id="menu6" href="?webpage=post_ArticleList.php">
                        <i class="fa-solid fa-pen-to-square me-2" style="color: #ffffff;"></i>食記管理</a>
                    <a type="button" class="collapse text-light fs-5 text-decoration-none text-center fw-bold" id="menu6">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #ffffff;"></i>統計</a>
                </div>
            </div>
        </nav>
        <main class="w-100 bg-body-tertiary">
            <?php if ($webpage == "") {
                require("../index.php");
            } ?>
            <?php if ($webpage == "user_list.php") {
                require("../User/user_list.php");
            } ?>
            <?php if ($webpage == "user_add.php") {
                require("../User/user_add.php");
            } ?>
            <?php if ($webpage == "user_update.php") {
                require("../User/user_update.php");
            } ?>
            <?php if ($webpage == "post_ArticleList.php") {
                require("../post/post_ArticleList.php");
            } ?>


            <?php if ($webpage == "product_list.php") {
                require("../Product/product_list.php");
            } ?>
            <?php if ($webpage == "product_add.php") {
                require("../Product/product_add.php");
            } ?>
            <?php if ($webpage == "product_doAdd.php") {
                require("../Product/product_doAdd.php");
            } ?>
            <?php if ($webpage == "product_doAddImg.php") {
                require("../Product/product_doAddImg.php");
            } ?>
            <?php if ($webpage == "product_doDelete.php") {
                require("../Product/product_doDelete.php");
            } ?>
            <?php if ($webpage == "product_doDelImg.php") {
                require("../Product/product_doDelImg.php");
            } ?>
            <?php if ($webpage == "product_doUpdateOO.php") {
                require("../Product/product_doUpdateOO.php");
            } ?>
            <?php if ($webpage == "product_ImgOO.php") {
                require("../Product/product_ImgOO.php");
            } ?>
            <?php if ($webpage == "product_updateOO.php") {
                require("../Product/product_updateOO.php");
            } ?>

            <?php if ($webpage == "style-product_add.php") {
                require("../Product/Style/product_add.php");
            } ?>
            <?php if ($webpage == "style-product_addL.php") {
                require("../Product/Style/product_addL.php");
            } ?>
            <?php if ($webpage == "style-product_doAdd.php") {
                require("../Product/Style/product_doAdd.php");
            } ?>
            <?php if ($webpage == "style-product_doAddL.php") {
                require("../Product/Style/product_doAddL.php");
            } ?>
            <?php if ($webpage == "style-product_doDelete.php") {
                require("../Product/Style/product_doDelete.php");
            } ?>
            <?php if ($webpage == "style-product_doDeleteL.php") {
                require("../Product/Style/product_doDeleteL.php");
            } ?>
            <?php if ($webpage == "style-product_doUpdate.php") {
                require("../Product/Style/product_doUpdate.php");
            } ?>
            <?php if ($webpage == "style-product_doUpdateL.php") {
                require("../Product/Style/product_doUpdateL.php");
            } ?>
            <?php if ($webpage == "style-product_list.php") {
                require("../Product/Style/product_list.php");
            } ?>
            <?php if ($webpage == "style-product_update.php") {
                require("../Product/Style/product_update.php");
            } ?>
            <?php if ($webpage == "style-product_updateL.php") {
                require("../Product/Style/product_updateL.php");
            } ?>
            

            <?php if ($webpage == "cartPage.php") {
                require("../Cart/cart/cartPage.php");
            } ?>
            <?php if ($webpage == "pageBooksList3.php") {
                require("../book/pageBooksList3.php");
            } ?>
            <?php if ($webpage == "post_NewArticle.php") {
                require("../post/post_NewArticle.php");
            } ?>


            <?php if($webpage == "book_list.php"){require("../book/book_list.php");}?>
            <?php if($webpage == "book_dashboard.php"){require("../book/book_dashboard.php");}?>
            <?php if($webpage == "book_add.html"){require("../book/book_add.html");}?>              
            <?php if($webpage == "book_delete.php"){require("../book/book_delete.php");}?>
            <?php if($webpage == "book_insert.php"){require("../book/book_insert.php");}?>
            <?php if($webpage == "book_pageBook.php"){require("../book/book_pageBook.php");}?>
            <?php if($webpage == "book_update.php"){require("../book/book_update.php");}?>

        </main>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>