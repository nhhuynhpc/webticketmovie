<?php
include("../includes/header/header.php");
?>

<?php
include("../classes/login.php");
?>

<?php
$class = new login();
if (isset($_GET["sanPhamId"])) {
    $movieID = $_GET["sanPhamId"];
} else {
    $movieID = "";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = $_POST['Email'] ?? '';
    $MatKhau = $_POST['MatKhau'] ?? '';

    $login_check = $class->handle_login($Email, $MatKhau, $movieID); 
} 
?>

<!-- login -->
<div class="body">
    <div class="login-box">
        <h2>Đăng nhập</h2>

        <?php
        if (isset($login_check)) {
            echo '<div class="alert alert-danger" role="alert">' . $login_check . '</div>';
        }
        ?>

        <form action="
        <?php 
        if ($movieID !== '') {
            echo './dangNhap.php?sanPhamId='.$movieID;
        } else {
            echo './dangNhap.php';
        }
        ?>
        " method="post">
            <div class="user-box">
                <input type="text" name="Email" required='' >
                <label>Email</label>
            </div>
            <div class="user-box">
                <input type="password" name="MatKhau" required='' >
                <label>Mật khẩu</label>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Đăng nhập
                </button>
            </div>
            <p class="mt-5 text-end text-light">Chưa có tài khoản? <a class="form-change" href="
            <?php
            if ($movieID !== '') {
                echo './dangKy.php?sanPhamId='.$movieID;
            } else {
                echo './dangKy.php';
            }
            ?>
            ">Đăng ký
                    ngay.</a></p>
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