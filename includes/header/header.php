<?php
include("../lib/session.php");
Session::init();
if (Session::get("PhanQuyen") == "admin") {
    header("Location:./quanLyPhim.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../vender/Boostrap/css/bootstrap.css" rel="stylesheet">
    <script src="../vender/Boostrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../font/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../font/fontawesome-free-6.4.2-web/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/background.css">
    <title>Star Live Cinema</title>
</head>

<body>
    <header id="header" class="header-all">
        <nav class="header navbar">
            <div class="container-fluid">
                <div class="menu-nav">
                    <button class="btn-select-menu" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="phone">
                        <img id="iconPhone" src="../images/phone-call-icon.svg" alt="phone icon">
                        <span id="phone">09xxxxxxxx</span>
                    </div>
                </div>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header d-flex justify-content-center">
                        <div class="nav-logo">
                            <a href="../pages/index.php">
                                <img src="../images/logo.png" alt="logo">
                            </a>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="nav-menu navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../pages/index.php">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/danhMuc.php">Danh sách</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Tin tức</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/lienHe.php">Liên hệ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/veChungToi.php">Về chúng tôi</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="d-flex justify-content-end pe-5">
                    <form  id="formSearch"
                        class="button-icon search d-flex justify-content-end align-items-center">
                        <input name="searchText" id="searchText" class="search-input form-control" type="search"
                            placeholder="Tìm kiếm..." aria-label="Search" onchange="handleOnchangeSearch()" >
                        <button type="submit" name="submit" class="btn">
                            <img id="iconSearch" src="../images/searchIcon.svg" alt="search icon">
                        </button>
                    </form>
                    <div class="button-icon button-user">
                        <button type="button" class="btn">
                            <img id="iconUser" src="../images/userIcon.png" alt="user icon">
                        </button>
                        <ul class="menu-user">
                            <?php
                            if (Session::get('login') == false) {
                                echo "
                                    <li>
                                        <a href='../pages/dangKy.php'>
                                            Đăng ký
                                        </a>
                                    </li>
                                    <li>
                                        <a href='../pages/dangNhap.php'>
                                            Đăng nhập
                                        </a>
                                    </li>
                                ";
                            } else {
                                if (isset($_GET['action']) && $_GET['action'] == 'logout') {
                                    session_destroy();
                                    echo "<script>location.href = '../pages/dangNhap.php';</script>";
                                }
                                echo "
                                        <li>
                                            <a href='../pages/hoSo.php'>
                                                Hồ sơ
                                            </a>
                                        </li>
                                        <li>
                                            <a href='?action=logout'>
                                                Đăng xuất
                                            </a>
                                        </li>
                                    ";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="nav-logo-main">
            <a href="../pages/index.php" style="z-pages/index: 1">
                <img src="../images/logo.png" alt="logo">
            </a>
        </div>
    </header>
    <?php
    include("../includes/background/background.php");
    ?>

    <script>
        function handleOnchangeSearch() {
            let elementIn = document.getElementById('searchText')
            if (elementIn.value !== '') {
                document.getElementById('formSearch').action = './ketQuaTimKiem.php'
                document.getElementById('formSearch').method = 'post'
            }
        }
    </script>