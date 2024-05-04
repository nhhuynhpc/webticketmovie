<?php
include("../includes/header/adminHeader.php");
?>

<?php
include("../classes/manageMovie.php");
include("../classes/categories.php");
?>

<?php
$class = new manageMovie();

if (!isset($_GET["movieid"]) || $_GET["movieid"] == null) {
    echo "<script>location.href = '../pages/quanLyPhim.php';</script>";
} else {
    $id = $_GET["movieid"];
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $updateMovie = $class->update_movie($_POST, $_FILES, $id);
    }
}

?>

<?php
if (isset($updateMovie)) {
    if ($updateMovie['status'] == 'success') {
        $alertIcon = '<img src="../images/successIcon.svg" alt="">';
    } else {
        $alertIcon = '<img src="../images/warning.svg" alt="">';
    }
    echo '
    <div class="onclose-alert" id="onCloseAlert" onclick="handleCloseAlert(`' . $updateMovie['status'] . '`)">
    </div>
    <div class="info-alert alert alert-danger" id="alert" role="alert">
    <div class="d-flex flex-row justify-content-center align-items-center">
    ' . $alertIcon . '
    <p>' . $updateMovie['msg'] . '</p>
    </div>
        <div class="d-flex justify-content-center mt-3">
    <button type="button" class="btn btn-info" onclick="handleAlert(`' . $updateMovie['status'] . '`)" style="width: 230px;">Xác nhận</button>
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
            <h1>Sửa phim</h1>
        </div>

        <?php 
        $get_movie_by_id = $class->get_movie_by_id($_GET['movieid']);
        if ($get_movie_by_id) {
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="TenPhim" placeholder="" value="<?php echo $get_movie_by_id['TenPhim']; ?>" >
                <label for="floatingInput">Tên phim</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelectGrid" name="LoaiPhim_ID" >
                    <option value="" >Chọn loại phim</option>
                    <?php
                    $classCate = new categories();
                    $cateData = $classCate->get_cate();
                    if ($cateData != false) {
                        while ($row = mysqli_fetch_assoc($cateData)) {
                            if ($row['ID'] == $get_movie_by_id['LoaiPhim_ID']) {
                                echo '<option value="' . $row['ID'] . '" selected >' . $row['TenLoai'] . '</option>';
                            } else {
                                echo '<option value="' . $row['ID'] . '">' . $row['TenLoai'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <label for="floatingSelectGrid">Thể loại</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="QuocGia" placeholder="" value="<?php echo $get_movie_by_id['QuocGia']; ?>">
                <label for="floatingInput">Quốc gia</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="ThoiLuong" placeholder=""  value="<?php echo $get_movie_by_id['ThoiLuong']; ?>" >
                <label for="floatingInput">Thời lượng <span style="font-size: 12px;">(phút)</span></label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="DienVien" placeholder="" value="<?php echo $get_movie_by_id['DienVien']; ?>">
                <label for="floatingInput">Diễn viên</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="DaoDien" placeholder="" value="<?php echo $get_movie_by_id['DaoDien']; ?>">
                <label for="floatingInput">Đạo diễn</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelectGrid" name="DatTruoc">
                    <option value="" selected>Chọn một lựa chọn</option>
                    <?php 
                    if ($get_movie_by_id['DatTruoc'] == '0') {
                    ?>
                    <option value="0" selected>Cho phép</option>
                    <option value="1">Không cho phép</option>
                    <?php 
                    }else {
                    ?>
                    <option value="0">Cho phép</option>
                    <option value="1" selected >Không cho phép</option>
                    <?php 
                    }
                    ?>
                </select>
                <label for="floatingSelectGrid">Đặt trước vé</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelectGrid" name="TrangThai">
                    <option value="" selected>Chọn trạng thái</option>
                    <?php 
                    if ($get_movie_by_id['TrangThai'] == '0') {
                    ?>
                    <option value="0" selected>Sắp chiếu</option>
                    <option value="1">Đang chiếu</option>
                    <option value="2">Đã chiếu</option>
                    <?php 
                    }elseif ($get_movie_by_id['TrangThai'] == '1') {
                    ?>
                    <option value="0">Sắp chiếu</option>
                    <option value="1" selected>Đang chiếu</option>
                    <option value="2">Đã chiếu</option>
                    <?php 
                    } else {
                    ?>
                    <option value="0">Sắp chiếu</option>
                    <option value="1">Đang chiếu</option>
                    <option value="2" selected>Đã chiếu</option>
                    <?php 
                    }
                    ?>
                </select>
                <label for="floatingSelectGrid">Trạng thái</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" name="MoTa" placeholder="Leave a comment here" id="floatingTextarea2"
                    style="height: 100px"> <?php echo $get_movie_by_id['MoTa']; ?></textarea>
                <label for="floatingTextarea2" class="ps-2">Mô tả</label>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Chọn ảnh</label><br>
                <img class="my-3" id="imgSelected" src="../uploads/<?php echo $get_movie_by_id['Anh']; ?>" alt="" width="120px" height="120px" >
                <input class="form-control" type="file" id="formFile" name="image" >
            </div>
            <div class="footer d-flex justify-content-around">
                <a href="./quanLyPhim.php" class="btn btn-secondary">Hủy</a>
                <button type="submit" name="submit" class="btn btn-primary">Lưu lại</button>
            </div>
        </form>
        <?php 
        }
        ?>
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
            img.src = url;
        }
    });
</script>

<?php
include("../includes/footer/adminFooter.php");
?>