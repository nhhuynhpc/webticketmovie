<?php
include("../includes/header/header.php");
?>
<?php
include("../classes/movie.php");
?>

<?php
$classMovie = new Movie();
if (isset($_GET["sanPhamId"])) {
    $movieID = $_GET["sanPhamId"];
    $getMovieById = $classMovie->get_movie_by_id($movieID);
} else {
    $getMovieById = false;
}
?>

<main>
    <div class="space-header"></div>
    <?php
    if ($getMovieById != false) {
        $movieDataById = $getMovieById->fetch_assoc();
        ?>
        <div class="product-details-container d-flex justify-content-between">
            <div class="product-details-img">
                <img src="../uploads/<?php echo $movieDataById['Anh'] ?>" alt="img product">
            </div>
            <div class="product-details-content">
                <p class="product-detail-title">
                    <?php echo $movieDataById['TenPhim'] ?>
                </p>
                <p><b class="title">Khởi chiếu: </b>
                    <?php echo date('d-m-Y', strtotime($movieDataById['Ngay'])) ?>
                </p>
                <p><b class="title">Thể loại: </b>
                    <?php echo $movieDataById['TenLoai'] ?>
                </p>
                <p><b class="title">Diễn viên: </b>
                    <?php echo $movieDataById['DienVien'] ?>
                </p>
                <p><b class="title">Đạo diễn: </b>
                    <?php echo $movieDataById['DaoDien'] ?>
                </p>
                <p style="font-weight: 550; font-size: 15px">
                    <?php echo $movieDataById['MoTa'] ?>
                </p>
                <?php
                if (Session::get("login") == false) {
                ?>
                <a
                    href="./dangNhap.php?sanPhamId=<?php echo $movieDataById['ID']?>">
                    <div class="d-flex justify-content-center mt-5">
                        <button type="button" class="btn btn-info w-50 text-light" >Mua vé</button>
                    </div>
                </a>
                <?php 
                } else {
                ?>
                <a
                    href="./lichChieu.php?sanPhamId=<?php echo $movieDataById['ID']?>">
                    <div class="d-flex justify-content-center mt-5">
                        <button type="button" class="btn btn-info w-50 text-light" >Mua vé</button>
                    </div>
                </a>
                <?php 
                }
                ?>
            </div>
        </div>
    <?php
    }
    ?>
</main>

<script>
    function handleChangeCountProduct(type) {
        let setCount = document.getElementById('sp1').value;
        if ((type === 'increas')) {
            setCount = parseInt(setCount) + 1;
        } else {
            if (parseInt(setCount) === 1) {
                return
            }
            setCount = parseInt(setCount) - 1;
        }
        document.getElementById('sp1').value = setCount
    }
</script>

<?php
include("../includes/footer/footer.php");
?>