<?php
include("../includes/header/adminHeader.php");
?>

<?php
require_once("../classes/manageMovie.php");
require_once("../classes/rom.php");
require_once("../classes/manageShowtimes.php");
?>

<?php
$classMovie = new manageMovie();
$classShowtime = new manageShowtime();

if (isset($_GET["movieid"])) {
    $movieID = $_GET["movieid"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $insertShowtime = $classShowtime->insert_showtime($_POST);
}
?>

<?php
if (isset($insertShowtime)) {
    if ($insertShowtime['status'] == 'success') {
        $alertIcon = '<img src="../images/successIcon.svg" alt="">';
    } else {
        $alertIcon = '<img src="../images/warning.svg" alt="">';
    }
    echo '
    <div class="onclose-alert" id="onCloseAlert" onclick="handleCloseAlert(`' . $insertShowtime['status'] . '`)">
    </div>
    <div class="info-alert alert alert-danger" id="alert" role="alert">
    <div class="d-flex flex-row justify-content-center align-items-center">
    ' . $alertIcon . '
    <p>' . $insertShowtime['msg'] . '</p>
    </div>
        <div class="d-flex justify-content-center mt-3">
    <button type="button" class="btn btn-info" onclick="handleAlert(`' . $insertShowtime['status'] . '`)" style="width: 230px;">Xác nhận</button>
    </div>
    </div>';
}
?>


<div class="movie-management">
    <div class="header">
        <img src="../images/managementIcon.png" alt="">
        <span>Quản lý phim</span>
    </div>

    <div class="content content-add">
        <div class="title">
            <h1>Thêm lịch chiếu</h1>
        </div>
        <form action="themLichChieu.php?movieid=<?php echo $movieID; ?>" method="post" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelect" name="Phim_ID">
                    <?php
                    $dataMovie = $classMovie->get_movie_by_id($movieID);

                    if ($dataMovie !== false) {
                        echo '<option value="' . $dataMovie['ID'] . '" >' . $dataMovie['TenPhim'] . '</option>';
                    }
                    ?>
                </select>
                <label for="floatingSelect">Tên phim</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelect" name="Phong_ID">
                    <option value="" selected>Chọn phòng</option>
                    <?php
                    $classRom = new rom();
                    $cateData = $classRom->get_rom();
                    if ($cateData != false) {
                        while ($row = mysqli_fetch_assoc($cateData)) {
                            echo '<option value="' . $row['ID'] . '">' . $row['TenPhong'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="floatingSelect">Phòng</label>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="floatingInput" placeholder="" name="Ngay">
                <label for="floatingInput">Ngày chiếu</label>
            </div>
            <div class="form-floating mb-3">
                <input type="time" class="form-control" id="floatingInput" placeholder="" name="GioBD">
                <label for="floatingInput">Giờ bắt đầu</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="GiaVe" placeholder="">
                <label for="floatingInput">Giá vé <span style="font-size: 12px;">(VND)</span></label>
            </div>
            <div class="footer d-flex justify-content-around">
                <a href="./quanLyPhim.php" class="btn btn-secondary">Hủy</a>
                <button type="submit" name="submit" class="btn btn-primary">Lưu lại</button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleCloseAlert(data, linkId) {
        let element = document.getElementById("onCloseAlert");
        let elementAlert = document.getElementById("alert");
        element.remove()
        elementAlert.remove()
        if (data === "success") {
            location.href = '../pages/quanLyPhim.php';
        }
    }
    function handleAlert(data, linkId) {
        handleCloseAlert();
        if (data === "success") {
            location.href = '../pages/quanLyPhim.php';
        }
    }
</script>

<?php
include("../includes/footer/adminFooter.php");
?>