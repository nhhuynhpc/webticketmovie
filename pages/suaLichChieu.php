<?php
include("../includes/header/adminHeader.php");
?>

<?php
include("../classes/manageMovie.php");
require_once("../classes/rom.php");
require_once("../classes/manageShowtimes.php");
?>

<?php
$classMovie = new manageMovie();
$classShowtime = new manageShowtime();

if (!isset($_GET['phimPage'])) {
    $numPhimPage = '1'; 
} else {
    $numPhimPage = $_GET['phimPage'];
}

if (!isset($_GET["showtimeid"]) || $_GET["showtimeid"] == null) {
    echo "<script>location.href = '../pages/quanLyLichChieu.php';</script>";
} else {
    $id = $_GET["showtimeid"];
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $updateShowtime = $classShowtime->update_showtime($_POST, $id);
    }
}

if (isset($_GET['movieid'])) {
    $movieID = $_GET['movieid'];
}
?>

<?php
if (isset($updateShowtime)) {
    if ($updateShowtime['status'] == 'success') {
        $alertIcon = '<img src="../images/successIcon.svg" alt="">';
    } else {
        $alertIcon = '<img src="../images/warning.svg" alt="">';
    }
    echo '
    <div class="onclose-alert" id="onCloseAlert" onclick="handleCloseAlert(`' . $updateShowtime['status'] . '`,`'.$movieID.'`,`'.$numPhimPage.'`)">
    </div>
    <div class="info-alert alert alert-danger" id="alert" role="alert">
    <div class="d-flex flex-row justify-content-center align-items-center">
    ' . $alertIcon . '
    <p>' . $updateShowtime['msg'] . '</p>
    </div>
        <div class="d-flex justify-content-center mt-3">
    <button type="button" class="btn btn-info" onclick="handleAlert(`' . $updateShowtime['status'] . '`,`'.$movieID.'`,`'.$numPhimPage.'`)" style="width: 230px;">Xác nhận</button>
    </div>
    </div>';
}
?>


<div class="movie-management">
    <div class="header">
        <img src="../images/managementIcon.png" alt="">
        <span>Quản lý lịch chiếu phim</span>
    </div>

    <div class="content content-add">
        <div class="title">
            <h1>Sửa lịch chiếu</h1>
        </div>
        <?php 
        $get_showtime_by_id = $classShowtime->get_showtime_by_id($_GET['showtimeid']);
        if ($get_showtime_by_id) {
        ?>
        <form action="./suaLichChieu.php?showtimeid=<?php echo $_GET['showtimeid']; ?>&movieid=<?php echo $movieID ?>&phimPage=<?php echo $numPhimPage; ?>" method="post" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelect" name="Phim_ID" >
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
                <select class="form-select" id="floatingSelect" name="Phong_ID" >
                    <option value="" selected>Chọn phòng</option>
                    <?php
                    $classRom = new rom();
                    $romData = $classRom->get_rom();
                    if ($romData != false) {
                        while ($row = mysqli_fetch_assoc($romData)) {
                            if ($row['ID'] == $get_showtime_by_id['Phong_ID']) {
                                echo '<option value="' . $row['ID'] . '" selected >' . $row['TenPhong'] . '</option>';
                            } else {
                                echo '<option value="' . $row['ID'] . '">' . $row['TenPhong'] . '</option>';
                            }
                        }
                    } 
                    ?>
                </select>
                <label for="floatingSelect">Phòng</label>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="floatingInput" placeholder="" name="Ngay" value="<?php echo $get_showtime_by_id['Ngay'] ?>" >
                <label for="floatingInput">Ngày chiếu</label>
            </div>
            <div class="form-floating mb-3">
                <input type="time" class="form-control" id="floatingInput" placeholder="" name="GioBD" value="<?php echo $get_showtime_by_id['GioBD'] ?>" >
                <label for="floatingInput">Giờ bắt đầu</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="" name="GiaVe" value="<?php echo $get_showtime_by_id['GiaVe'] ?>">
                <label for="floatingInput">Giá vé <span style="font-size: 12px;">(VND)</span></label>
            </div>
            <div class="footer d-flex justify-content-around">
                <a href="./quanLyLichChieu.php?movieid=<?php echo $movieID ?>&phimPage=<?php echo $numPhimPage; ?>" class="btn btn-secondary">Hủy</a>
                <button type="submit" name="submit" class="btn btn-primary">Lưu lại</button>
            </div>
        </form>
        <?php 
        }
        ?>
    </div>
</div>

<script>
    function handleCloseAlert(data, link, numPhimPage) {
        let element = document.getElementById("onCloseAlert");
        let elementAlert = document.getElementById("alert");
        element.remove()
        elementAlert.remove()
        if (data === "success") {
            location.href = '../pages/quanLyLichChieu.php?movieid=' + link + '&phimPage=' + numPhimPage;
        }
    }
    function handleAlert(data, link, numPhimPage) {
        handleCloseAlert();
        if (data === "success") {
            location.href = '../pages/quanLyLichChieu.php?movieid=' + link + '&phimPage=' + numPhimPage;
        }
    }
</script>

<?php
include("../includes/footer/adminFooter.php");
?>