<?php
include("../includes/header/header.php");
?>

<?php
require_once("../classes/movie.php");
?>

<?php
$classMovie = new Movie();
$movieIsShowing = $classMovie->movie_is_showing();
$upcomingMovie = $classMovie->upcoming_movie();
$preSaleTickets = $classMovie->pre_sale_tickets();
?>

<main>
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
        </div>
        <div class="carousel-event">
            <button>SUẤT CHIẾU ĐẶC BIỆT</button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="img-slider">
                    <img src="../images/slider1.png" class="d-block" alt="...">
                </div>
            </div>
            <div class="carousel-item">
                <div class="img-slider">
                    <img src="../images/slider2.png" class="d-block" alt="...">
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="categories-home d-flex justify-content-around mt-5 px-5">
        <a href="./danhMuc.php?movieType=showing">
            <div class="card">
                <img src="../images/category1.png" alt="img cate" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-center">PHIM ĐANG CHIẾU</h5>
                </div>
            </div>
        </a>
        <a href="./danhMuc.php?movieType=upcoming">
            <div class="card">
                <img src="../images/category2.png" alt="img cate" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-center">PHIM SẮP CHIẾU</h5>
                </div>
            </div>
        </a>
        <a href="./danhMuc.php?movieType=pre_sale">
            <div class="card">
                <img src="../images/category3.png" alt="img cate" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-center">VÉ BÁN TRƯỚC</h5>
                </div>
            </div>
        </a>
        <!-- <a href="">
            <div class="card">
                <img src="../images/category4.png" alt="img cate" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-center">COMBO POPCORN</h5>
                </div>
            </div>
        </a> -->
    </div>
    <div class="suggested-movie d-flex justify-content-around">
        <img src="../images/moreinfo.jpg" alt="img movie">
        <div class="infor-movie">
            <h2 class="suggested-movie_name">
                VỆ BINH DẢI NGÂN HÀ 3
            </h2>
            <p><b>Đạo diễn: </b>James Gunn</p>
            <p><b>Diễn viên: </b>Bradley Cooper, Vin Diesel, Chris Pratt, Karen Gillan, Zoe Saldana, Dave Bautista..
            </p>
            <p><b>Nhà sản xuất: </b>Marvel Studios</p>
            <p><b>Thể loại phim: </b>Hành động, phiêu lưu, hài hước, viễn tưởng.</p>
            <p><b>Thời lượng: </b>135 phút</p>
            <p><b>Ngày khởi chiếu: </b>xx/xx/2023</p>
            <p><b>Quốc gia: </b>Hoa Kỳ</p>
        </div>
    </div>
    <div class="movie-showing">
        <h2 class="text-center">PHIM ĐANG CHIẾU</h2>
        <div class="movie-showing_container d-flex justify-content-center flex-wrap">
            <?php
            if ($movieIsShowing != false) {
                $row = $movieIsShowing->fetch_all(MYSQLI_ASSOC);
                for ($i = 0; $i < count($row); $i++) {
                    ?>
                    <div class="card card-select mx-3">
                        <div class="card-img">
                            <a href="./chiTietSanPham.php?sanPhamId=<?php echo $row[$i]['ID'] ?>">
                                <img src="../uploads/<?php echo $row[$i]['Anh'] ?>" alt="" class="card-img-top">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body_text">
                                <h5 class="card-title text-center">
                                    <?php echo $row[$i]['TenPhim'] ?>
                                </h5>
                                <p><b>
                                        <?php echo number_format($row[$i]['GiaVe']) ?> <u>VND</u> 
                                    </b></p>
                            </div>
                            <div class="btn-buy d-flex justify-content-center align-items-center">
                                <a href="./chiTietSanPham.php?sanPhamId=<?php echo $row[$i]['ID'] ?>">
                                    <button>XEM THÊM</button>
                                </a>
                                <button class="img-buy">
                                    <img src="../images/bag.svg" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($i == 3) {
                        break;
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="upcoming-movie">
        <h2 class="text-center">PHIM SẮP CHIẾU</h2>
        <div class="movie-showing_container d-flex justify-content-center flex-wrap">
            <?php
            if ($upcomingMovie != false) {
                $row = $upcomingMovie->fetch_all(MYSQLI_ASSOC);
                for ($i = 0; $i < count($row); $i++) {
                    ?>
                    <div class="card card-select mx-3">
                        <div class="card-img">
                            <a href="./chiTietSanPham.php?sanPhamId=<?php echo $row[$i]['ID'] ?>">
                                <img src="../uploads/<?php echo $row[$i]['Anh'] ?>" alt="" class="card-img-top">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body_text">
                                <h5 class="card-title text-center">
                                    <?php echo $row[$i]['TenPhim'] ?>
                                </h5>
                                <p><b>
                                        <?php echo number_format($row[$i]['GiaVe']) ?> <u>VND</u>
                                    </b></p>
                            </div>
                            <div class="btn-buy d-flex justify-content-center align-items-center">
                                <a href="./chiTietSanPham.php?sanPhamId=<?php echo $row[$i]['ID'] ?>">
                                    <button>XEM THÊM</button>
                                </a>
                                <button class="img-buy">
                                    <img src="../images/bag.svg" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($i == 4) {
                        break;
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="pre-ticket">
        <h2 class="text-center">VÉ BÁN TRƯỚC</h2>
        <div class="movie-showing_container d-flex justify-content-center flex-wrap">
            <?php
            if ($preSaleTickets != false) {
                $row = $preSaleTickets->fetch_all(MYSQLI_ASSOC);
                for ($i = 0; $i < count($row); $i++) {
                    ?>
                    <div class="card card-select mx-3">
                        <div class="card-img">
                            <a href="./chiTietSanPham.php?sanPhamId=<?php echo $row[$i]['ID'] ?>">
                                <img src="../uploads/<?php echo $row[$i]['Anh'] ?>" alt="" class="card-img-top">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body_text">
                                <h5 class="card-title text-center">
                                    <?php echo $row[$i]['TenPhim'] ?>
                                </h5>
                                <p><b>
                                        <?php echo number_format($row[$i]['GiaVe']) ?> <u>VND</u>
                                    </b></p>
                            </div>
                            <div class="btn-buy d-flex justify-content-center align-items-center">
                                <a href="./chiTietSanPham.php?sanPhamId=<?php echo $row[$i]['ID'] ?>">
                                    <button>XEM THÊM</button>
                                </a>
                                <button class="img-buy">
                                    <img src="../images/bag.svg" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($i == 4) {
                        break;
                    }
                }
            }
            ?>
        </div>
    </div>
    <!-- <div class="combo-porcon">
        <h2 class="text-center">COMBO POPCORN</h2>
        <div class="movie-showing_container d-flex justify-content-around flex-wrap">
            <div class="card card-select">
                <div class="card-img">
                    <img src="../images/nuoc1.jpg" alt="" class="card-img-top">
                </div>
                <div class="card-body">
                    <div class="card-body_text">
                        <h5 class="card-title text-center">Nước</h5>
                        <p><b>38,000 <u>đ</u></b></p>
                    </div>
                    <div class="btn-buy d-flex justify-content-center align-items-center">
                        <button>XEM THÊM</button>
                        <button class="img-buy">
                            <img src="../images/bag.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>
            <div class="card card-select">
                <div class="card-img">
                    <img src="../images/bap.jpg" alt="" class="card-img-top">
                </div>
                <div class="card-body">
                    <div class="card-body_text">
                        <h5 class="card-title text-center">Bắp</h5>
                        <p><b>68,000 <u>đ</u></b></p>
                    </div>
                    <div class="btn-buy d-flex justify-content-center align-items-center">
                        <button>XEM THÊM</button>
                        <button class="img-buy">
                            <img src="../images/bag.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>
            <div class="card card-select">
                <div class="card-img">
                    <img src="../images/bapnuoc.jpg" alt="" class="card-img-top">
                </div>
                <div class="card-body">
                    <div class="card-body_text">
                        <h5 class="card-title text-center">Combo 1 bắp 1 nước</h5>
                        <p><b>99,000 <u>đ</u></b></p>
                    </div>
                    <div class="btn-buy d-flex justify-content-center align-items-center">
                        <button>XEM THÊM</button>
                        <button class="img-buy">
                            <img src="../images/bag.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>
            <div class="card card-select">
                <div class="card-img">
                    <img src="../images/2bap2nuoc.jpg" alt="" class="card-img-top">
                </div>
                <div class="card-body">
                    <div class="card-body_text">
                        <h5 class="card-title text-center">Combo 2 bắp 2 nước</h5>
                        <p><b>189,000 <u>đ</u></b></p>
                    </div>
                    <div class="btn-buy d-flex justify-content-center align-items-center">
                        <button>XEM THÊM</button>
                        <button class="img-buy">
                            <img src="../images/bag.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="images mt-5">
        <h2 class="text-center">HÌNH ẢNH</h2>
        <div class="d-flex justify-content-center align-items-center flex-wrap">
            <div class="images-item mx-4">
                <img src="../images/img1.png" alt="">
            </div>
            <div class="images-item mx-4">
                <img src="../images/img2.png" alt="">
            </div>
            <div class="images-item mx-4">
                <img src="../images/img3.png" alt="">
            </div>
            <div class="images-item mx-4">
                <img src="../images/img4.jpg" alt="">
            </div>
        </div>
    </div>
    <div class="promotion">
        <h2 class="text-center">TIN TỨC KHUYẾN MÃI</h2>
        <div class="d-flex justify-content-center align-items-center flex-wrap">
            <div class="card mx-3">
                <a href="">
                    <img src="../images/promotion.png" alt="" class="card-img-top">
                </a>
                <div class="card-body">
                    <div class="promotion-date">
                        <p>06-10-2023</p>
                    </div>
                    <a href="">
                        <h6 class="card-title text-center">STARLIVE VÉ RẺ, QUẸT MOMO LIỀN</h6>
                    </a>
                    <p class="card-text">Cinema đẹp thôi chưa đủ, mà giá
                        lại còn “vừa túi tiền”. Từ nay, các mọt phim tha
                        hồ thưởng thức những thước phim điện ảnh đỉnh cao
                        tại StarLive Cinema với giá cực ưu đãi khi đặt vé
                        trên MoMo.
                    </p>
                </div>
            </div>
            <div class="card mx-3">
                <a href="">
                    <img src="../images/promotion.png" alt="" class="card-img-top">
                </a>
                <div class="card-body">
                    <div class="promotion-date">
                        <p>30-10-2023</p>
                    </div>
                    <a href="">
                        <h6 class="card-title text-center">Về chúng tôi</h6>
                    </a>
                    <p class="card-text">
                        Công ty Cổ phần StarLive Cinema thành lập ngày 10 tháng
                        04 năm 2023, trụ sở chính đặt tại Tầng 3-4 , số 198, đường
                        Hồ Tùng Mậu, Phường Mai Dịch, Quận Cầu Giấy, Thành phố Hà Nội.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

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