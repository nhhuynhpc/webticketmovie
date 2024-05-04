<?php
include("../includes/header/adminHeader.php");
?>

<?php
include("../classes/manageMovie.php");
include("../classes/categories.php");
?>

<?php
$class = new manageMovie();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $insertMovie = $class->insert_movie($_POST, $_FILES);
}
?>

<?php
if (isset($insertMovie)) {
    if ($insertMovie['status'] == 'success') {
        $alertIcon = '<img src="../images/successIcon.svg" alt="">';
    } else {
        $alertIcon = '<img src="../images/warning.svg" alt="">';
    }
    echo '
    <div class="onclose-alert" id="onCloseAlert" onclick="handleCloseAlert(`'.$insertMovie['status'].'`)">
    </div>
    <div class="info-alert alert alert-danger" id="alert" role="alert">
    <div class="d-flex flex-row justify-content-center align-items-center">
    '.$alertIcon.'
    <p>' . $insertMovie['msg'] . '</p>
    </div>
        <div class="d-flex justify-content-center mt-3">
    <button type="button" class="btn btn-info" onclick="handleAlert(`'.$insertMovie['status'].'`)" style="width: 230px;">Xác nhận</button>
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
            <h1>Thêm phim</h1>
        </div>
        <form action="themPhim.php" method="post" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="TenPhim" placeholder="">
                <label for="floatingInput">Tên phim</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelectGrid" name="LoaiPhim_ID">
                    <option value="" selected>Chọn loại phim</option>
                    <?php
                    $classCate = new categories();
                    $cateData = $classCate->get_cate();
                    if ($cateData != false) {
                        while ($row = mysqli_fetch_assoc($cateData)) {
                            echo '<option value="' . $row['ID'] . '">' . $row['TenLoai'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="floatingSelectGrid">Thể loại</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="QuocGia" placeholder="">
                <label for="floatingInput">Quốc gia</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="ThoiLuong" placeholder="">
                <label for="floatingInput">Thời lượng <span style="font-size: 12px;" >(phút)</span></label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="DienVien" placeholder="">
                <label for="floatingInput">Diễn viên</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="DaoDien" placeholder="">
                <label for="floatingInput">Đạo diễn</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelectGrid" name="DatTruoc">
                    <option selected value="" >Chọn một lựa chọn</option>
                    <option value="0">Cho phép</option>
                    <option value="1">Không cho phép</option>
                </select>
                <label for="floatingSelectGrid">Đặt trước vé</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelectGrid" name="TrangThai">
                    <option selected value="" >Chọn trạng thái</option>
                    <option value="0">Sắp chiếu</option>
                    <option value="1">Đang chiếu</option>
                    <option value="2">Đã chiếu</option>
                </select>
                <label for="floatingSelectGrid">Trạng thái</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" name="MoTa" placeholder="Leave a comment here" id="floatingTextarea2"
                    style="height: 100px"></textarea>
                <label for="floatingTextarea2" class="ps-2">Mô tả</label>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Chọn ảnh</label><br>
                <img class="my-3" src="" id="imgSelected" alt="" width="120px" height="120px" style="display: none;" >
                <input class="form-control" type="file" id="formFile" name="image">
            </div>
            <div class="footer d-flex justify-content-around">
                    <a href="./quanLyPhim.php" class="btn btn-secondary">Hủy</a>
                <button type="submit" name="submit" class="btn btn-primary">Lưu lại</button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleCloseAlert(data) {
        let element = document.getElementById("onCloseAlert");
        let elementAlert = document.getElementById("alert");
        element.remove()
        elementAlert.remove()
        if (data === "success") {
            location.href = '../pages/quanLyPhim.php';
        }
    }
    function handleAlert(data) {
        handleCloseAlert();
        if (data === "success") {
            location.href = '../pages/quanLyPhim.php';
        }
    }
    document.getElementById('formFile').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var url = URL.createObjectURL(file);
        let img = document.getElementById('imgSelected');

        if (url) {
            img.style.display = 'block';
            img.src = url;
        }
    });
</script>

<?php
include("../includes/footer/adminFooter.php");
?>