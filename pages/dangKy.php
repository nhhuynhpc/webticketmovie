<?php
include("../includes/header/header.php");
?>

<?php
include("../classes/register.php");
?>

<?php
$class = new register();
if (isset($_GET["sanPhamId"])) {
    $movieID = $_GET["sanPhamId"];
} else {
    $movieID = "";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TenTaiKhoan = $_POST['TenTaiKhoan'] ??'';
    $Email = $_POST['Email'] ?? '';
    $MatKhau = $_POST['MatKhau'] ?? '';
    $CheckMatKhau = $_POST['CheckMatKhau'] ??'';

    $register_check = $class->handle_register($TenTaiKhoan, $Email, $MatKhau, $CheckMatKhau, $movieID);
}
?>

<!-- login -->
<div class="body">
    <div class="login-box my-5">
        <h2>Đăng ký</h2>

        <?php
        if (isset($register_check)) {
            echo '<div class="alert alert-danger" role="alert">' . $register_check . '</div>';
        }
        ?>

        <form action="
        <?php 
        if ($movieID !== '') {
            echo './dangKy.php?sanPhamId='.$movieID;
        } else {
            echo './dangKy.php';
        }
        ?>
        " method="post">
            <div class="user-box">
                <input type="text" name="TenTaiKhoan" required="">
                <label>Tên tài khoản</label>
            </div>
            <div class="user-box">
                <input type="text" name="Email" required="">
                <label>Email</label>
            </div>
            <div class="user-box">
                <input type="password" name="MatKhau" required="">
                <label>Mật khẩu</label>
            </div>
            <div class="user-box">
                <input type="password" name="CheckMatKhau" required="">
                <label>Nhập lại mật khẩu</label>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Đăng ký
                </button>
            </div>
            <p class="mt-5 text-end text-light">Đã có tài khoản? <a class="form-change" href="
            <?php
            if ($movieID !== '') {
                echo './dangNhap.php?sanPhamId='.$movieID;
            } else {
                echo './dangNhap.php';
            }
            ?>
            ">Đăng nhập ngay.</a></p>
        </form>
    </div>
</div>

<script>
    var header = document.getElementById('header');
    var iconPhone = document.getElementById('iconPhone');
    var iconSearch = document.getElementById('iconSearch');
    var iconUser = document.getElementById('iconUser');
    var textPhone = document.getElementById('phone')
    if (window.scrollY > 250) {
        header.classList.remove('header-home');
        iconPhone.src = "../images/phone-call-icon.svg";
        iconSearch.src = "../images/searchIcon.svg"
        
        iconUser.src = "../images/userIcon.png"
        textPhone.style.color = "black"
    } else {
        iconPhone.src = "../images/phone-call-icon-white.svg";
        iconSearch.src = "../images/searchIconWhite.svg"
        
        iconUser.src = "../images/userIconwhite.png"
        header.classList.add('header-home');
        textPhone.style.color = "white"
    }
    window.addEventListener('scroll', function () {
        if (window.scrollY > 250) {
            header.classList.remove('header-home');
            iconPhone.src = "../images/phone-call-icon.svg";
            iconSearch.src = "../images/searchIcon.svg"
            
            iconUser.src = "../images/userIcon.png"
            textPhone.style.color = "black"
        } else {
            iconPhone.src = "../images/phone-call-icon-white.svg";
            iconSearch.src = "../images/searchIconWhite.svg"
            
            iconUser.src = "../images/userIconwhite.png"
            header.classList.add('header-home');
            textPhone.style.color = "white"
        }
    });
</script>

<?php
include("../includes/footer/footer.php");
?>