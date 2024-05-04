<?php
    include("../lib/session.php");
    Session::init();
    Session::checkSession();
    if (Session::get("PhanQuyen") != "admin") {
        header("Location:./index.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Star Line Cinema</title>
    <link href="../vender/Boostrap/css/bootstrap.css" rel="stylesheet">
    <script src="../vender/Boostrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../font/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../font/fontawesome-free-6.4.2-web/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <header>
        <div class="nav-header">
            <a href="./quanLyPhim.php" style="z-index: 1">
                <img src="../images/logo.png" alt="logo">
                <p>Starlive <br> Cinema Admin</p>
            </a>
        </div>
        <ul class="nav-content">
            <li>
                <a href="./quanLyPhim.php">Quản lý phim</a>
            </li>
            <li>
                <a href="./quanLyDonVe.php">Quản lý đơn vé</a>
            </li>
            <li>
                <a href="./quanLyUser.php">Quản lý user</a>
            </li>
        </ul>
        <?php 
            if (isset($_GET['action']) && $_GET['action'] == 'logout') {
                Session::destroy();
            }
        ?>
        <ul class="nav-footer">
            <li>
                <a href="?action=logout">Đăng xuất</a>
            </li>
        </ul>
    </header>
    <main>