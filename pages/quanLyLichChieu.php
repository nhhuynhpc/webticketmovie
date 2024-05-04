<?php
include("../includes/header/adminHeader.php");
?>

<?php
require_once("../classes/manageShowtimes.php");
require_once("../classes/manageMovie.php");
?>

<?php
$classShowtime = new manageShowtime();
$classMovie = new manageMovie();
if (!isset($_GET['page'])) {
    $numPage = '1';
} else {
    $numPage = $_GET['page'];
}
$SumShowtimeOnPage = 3;
if (!isset($_GET['phimPage'])) {
    $numPhimPage = '1';
} else {
    $numPhimPage = $_GET['phimPage'];
}

if (isset($_GET['movieid'])) {
    $movieID = $_GET['movieid'];
    $ShowtimeDataByProductId = $classShowtime->select_all_showtimeDataByProductId($movieID);
    $movieDataById = $classMovie->get_movie_by_id($movieID);
}

if (isset($_GET["showtimeid"])) {
    $id = $_GET["showtimeid"];
    $delShowtime = $classShowtime->delete_showtime($id);
    echo "<script>location.href = '../pages/quanLyLichChieu.php?page=" . $numPage . "&movieid=" . $movieID . "&phimPage=" . $numPhimPage . "';</script>";
}
?>

<div class="movie-management">
    <div class="header">
        <img src="../images/managementIcon.png" alt="">
        <span>Thông tin phim chi tiết</span>
    </div>

    <div class="content">
        <a href="./quanLyPhim.php?page=<?php echo $numPhimPage; ?>">
            <button class="btn-return-movie">
                <img src="../images/circleLeftIcon.svg" alt="">
                Quay lại
            </button>
        </a>
        <?php
        if ($movieDataById != false) {
            ?>
            <div class="info-movie">
                <p class="info-header">Thông tin phim</p>
                <div class="info-content">
                    <div class="img">
                        <img src="../uploads/<?php echo $movieDataById['Anh'] ?>" alt="">
                    </div>
                    <div class="info">
                        <div class="group-text">
                            <p class="title">Tên phim: </p>
                            <span class="name-movie">
                                <?php echo $movieDataById['TenPhim'] ?>
                            </span>
                        </div>
                        <div class="group-text">
                            <p class="title">Loại phim: </p>
                            <span>
                                <?php echo $movieDataById['TenLoai'] ?>
                            </span>
                        </div>
                        <div class="group-text">
                            <p class="title">Thời lượng: </p>
                            <span>
                                <?php echo $movieDataById['ThoiLuong'] ?> Phút
                            </span>
                        </div>
                        <div class="group-text">
                            <p class="title">Quốc gia: </p>
                            <span>
                                <?php echo $movieDataById['QuocGia'] ?>
                            </span>
                        </div>
                        <div class="group-text">
                            <p class="title">Đạo diễn: </p>
                            <span>
                                <?php echo $movieDataById['DaoDien'] ?>
                            </span>
                        </div>
                        <div class="group-text">
                            <p class="title">Diễn viên: </p>
                            <span>
                                <?php echo $movieDataById['DienVien'] ?>
                            </span>
                        </div>
                        <div class="group-text">
                            <p class="title">Trạng thái: </p>
                            <span>
                                <?php
                                if ($movieDataById['TrangThai'] == '0') {
                                    echo 'Sắp chiếu';
                                } elseif ($movieDataById['TrangThai'] == '1') {
                                    echo 'Đang chiếu';
                                } else {
                                    echo 'Đã chiễu';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="group-text">
                            <p class="title">Đặt trước vé: </p>
                            <span>
                                <?php
                                if ($movieDataById['DatTruoc'] == '0') {
                                    echo 'Cho phép';
                                } else {
                                    echo 'Không cho phép';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="group-text">
                            <p class="title">Mô tả: </p>
                            <span>
                                <?php echo $movieDataById['MoTa'] ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="title-manage-showtime">
            <p>Lịch chiếu</p>
        </div>
        <table class="table table-striped table-info table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên Phim</th>
                    <th scope="col">Phòng</th>
                    <th scope="col">Ngày chiếu</th>
                    <th scope="col">Giờ bắt đầu</th>
                    <th scope="col">Giá vé</th>
                    <th scope="col">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($ShowtimeDataByProductId != false) {
                    $row = $ShowtimeDataByProductId->fetch_all(MYSQLI_ASSOC);
                    $checkHanveShowtime = 0;
                    for ($i = (((int) $numPage * $SumShowtimeOnPage) - $SumShowtimeOnPage); $i < count($row); $i++) {
                        ?>
                        <tr>
                            <?php
                            echo '<th scope="row">' . $row[$i]["ID"] . '</th>';
                            echo '<td>' . $row[$i]['TenPhim'] . '</td>';
                            echo '<td>' . $row[$i]['TenPhong'] . '</td>';
                            echo '<td>' . date('d-m-Y', strtotime($row[$i]['Ngay'])) . '</td>';
                            echo '<td>' . date('H:i', strtotime($row[$i]['GioBD'])) . '</td>';
                            echo '<td>' . number_format($row[$i]['GiaVe']) . ' <b>VND</b></td>';
                            ?>

                            <td>
                                <div class="group-button d-flex justify-content-around">
                                    <a
                                        href="./suaLichChieu.php?showtimeid=<?php echo $row[$i]['ID']; ?>&movieid=<?php echo $movieID ?>&phimPage=<?php echo $numPhimPage; ?>">
                                        <button class="btn-edit">
                                            <img src="../images/editIcon.svg" alt="">
                                        </button>
                                    </a>
                                    <button class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteProduct"
                                        onclick="handleDelete('<?php echo $row[$i]['ID']; ?>', '<?php echo $numPage; ?>', '<?php echo $movieID ?>', '<?php echo $numPhimPage ?>')">
                                        <img src="../images/deleteIconWhite.svg" alt="">
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php
                        if ($i - (((int) $numPage * $SumShowtimeOnPage) - $SumShowtimeOnPage) == $SumShowtimeOnPage - 1) {
                            break;
                        }
                        $checkHanveShowtime += 1;
                    }
                    if ($checkHanveShowtime == 0) {
                        if ($numPage != 1) {
                            echo "<script>location.href = '../pages/quanLyLichChieu.php?page=" . ($numPage - 1) . "&movieid=" . $movieID . "';</script>";
                        }
                    }

                }
                ?>
            </tbody>
        </table>
        <nav class="d-flex justify-content-center" aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                if ($ShowtimeDataByProductId != false) {
                    $sumPage = ceil($ShowtimeDataByProductId->num_rows / $SumShowtimeOnPage);
                    if ($sumPage > 1) {
                        if ($numPage == '1') {
                            echo '
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    ';
                            for ($i = (int) $numPage - 1; $i < $sumPage; $i++) {
                                echo '<li class="page-item"><a class="page-link" href="./quanLyLichChieu.php?page=' . ($i + 1) . '&movieid=' . $movieID . '">' . ($i + 1) . '</a></li>';
                                if ($i + 1 > 2) {
                                    break;
                                }
                            }
                        } else {
                            echo '
                    <li class="page-item">
                        <a class="page-link" href="./quanLyLichChieu.php?page=' . ((int) $numPage - 1) . '&movieid=' . $movieID . '" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    ';
                            if ((int) $numPage == $sumPage) {
                                if ($sumPage == 2) {
                                    $i = (int) $numPage - 2;
                                } else {
                                    $i = (int) $numPage - 3;
                                }
                            } else {
                                $i = (int) $numPage - 2;
                            }
                            for ($i; $i < $sumPage; $i++) {
                                echo '<li class="page-item"><a class="page-link" href="./quanLyLichChieu.php?page=' . ($i + 1) . '&movieid=' . $movieID . '">' . ($i + 1) . '</a></li>';
                                if ($i - ((int) $sumPage - 2) == 3) {
                                    break;
                                }
                            }
                        }

                        if ($numPage == $sumPage) {
                            echo '
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        ';
                        } else {
                            echo '
                            <li class="page-item">
                                <a class="page-link" href="./quanLyLichChieu.php?page=' . ((int) $numPage + 1) . '&movieid=' . $movieID . '" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        ';
                        }
                    }
                }
                ?>
            </ul>
        </nav>
    </div>
</div>

<!-- delete -->

<div class="modal fade" id="deleteProduct" tabindex="-1" aria-labelledby="deleteProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="d-flex justify-content-end pt-3 pe-3">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="text-center">
                    Bạn chắc chắn muốn xóa
                </h4>
            </div>
            <div class="d-flex justify-content-center me-3 mb-3">
                <button type="button" class="btn btn-secondary mx-3" data-bs-dismiss="modal">Hủy</button>
                <a id='linkId' href="">
                    <button type="button" class="btn btn-primary mx-3">Đồng ý</button>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function handleDelete(id, numPage, movieid, numPhimPage) {
        let link = document.getElementById('linkId');
        if (id) {
            link.href = `./quanLyLichChieu.php?page=${numPage}&showtimeid=${id}&movieid=${movieid}&phimPage=${numPhimPage}`
        }
    }
</script>

<?php
include("../includes/footer/adminFooter.php");
?>