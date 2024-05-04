<?php
require_once("../classes/movie.php");
// require_once("../helpers/format");
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $typeMoie = $_POST["typeMoie"];
    $classMovie = new Movie();
    $fm = new Format();

    if ($typeMoie == "main") {
        $getMovie = $classMovie->getMovie();
    } else if ($typeMoie == "upcoming") {
        $getMovie = $classMovie->upcoming_movie();
    } else if ($typeMoie == "showing") {
        $getMovie = $classMovie->movie_is_showing();
    } else if ($typeMoie == "pre_sale") {
        $getMovie = $classMovie->pre_sale_tickets();
    }

    if ($getMovie != false) {
        $dataMovieAll = $getMovie->fetch_all(MYSQLI_ASSOC);

        for ($i = 0; $i < count($dataMovieAll); $i++) {
            echo '<div class="card mx-3 my-3" style="width: 18rem;">
            <a href="./chiTietSanPham.php?sanPhamId='.$dataMovieAll[$i]['ID'].'">
                <div class="card-img">
                    <img src="../uploads/'.$dataMovieAll[$i]['Anh'].'"
                    class="card-img-top" alt="...">
                </div>
            </a>
            <div class="card-body">
                <a href="./chiTietSanPham.php?sanPhamId='.$dataMovieAll[$i]['ID'].'">
                    <h5 class="card-title text-center">'.$dataMovieAll[$i]['TenPhim'].'</h5>
                </a>
                <p class="text-center card-price"><b>Giá: </b><span style="color: #b19d55;font-weight: 550;" > '.number_format($dataMovieAll[$i]['GiaVe']).' VNĐ</span></p>
                <p class="card-text">'.$fm->text_shorten($dataMovieAll[$i]['MoTa']).'</p>
            </div>
            </div>';
        }
    } else {
        echo "err";
    }
}

?>