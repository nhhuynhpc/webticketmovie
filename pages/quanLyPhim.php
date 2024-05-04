<?php
include("../includes/header/adminHeader.php");
?>

<?php
require_once("../classes/manageMovie.php");
?>

<?php
$classMovie = new manageMovie();
$MovieData = $classMovie->select_all_movie();
if (!isset($_GET['page'])) {
    $numPage = '1';
} else {
    $numPage = $_GET['page'];
}
$SumMovieOnPage = 3;

if (isset($_GET["movieid"])) {
    $id = $_GET["movieid"];
    $delMovie = $classMovie->delete_movie($id);
    echo "<script>location.href = '../pages/quanLyPhim.php?page=" . $numPage . "';</script>";
}
?>

<div class="movie-management">
    <div class="header">
        <img src="../images/managementIcon.png" alt="">
        <span>Quản lý phim</span>
    </div>

    <div class="content">
        <a href="./themPhim.php">
            <button class="btn-add-movie">Thêm phim</button>
        </a>
        <table class="table table-striped table-info table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên Phim</th>
                    <th scope="col">Thời lượng</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Chi tiết</th>
                    <th scope="col">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($MovieData != false) {
                    $row = $MovieData->fetch_all(MYSQLI_ASSOC);
                    $checkHaveMovie = 0;
                    for ($i = (((int) $numPage * $SumMovieOnPage) - $SumMovieOnPage); $i < count($row); $i++) {
                        ?>

                        <tr>
                            <?php
                            echo '<th scope="row">' . $row[$i]["ID"] . '</th>';
                            echo '<td>' . $row[$i]['TenPhim'] . '</td>';
                            echo '<td>' . $row[$i]['ThoiLuong'] . ' Phút</td>';
                            ?>
                            <?php
                            echo
                                '<td>
                            <img src="../uploads/' . $row[$i]['Anh'] . '" alt="">
                            </td>';
                            ?>
                            <td>
                                <a
                                    href="./quanLyLichChieu.php?movieid=<?php echo $row[$i]['ID']; ?>&phimPage=<?php echo $numPage; ?>">
                                    <button class="btn-detail ">
                                        Xem chi tiết
                                    </button>
                                </a>
                            </td>
                            <td>
                                <div class="group-button d-flex justify-content-around">
                                    <a href="./suaPhim.php?movieid=<?php echo $row[$i]['ID']; ?>">
                                        <button class="btn-edit">
                                            <img src="../images/editIcon.svg" alt="">
                                        </button>
                                    </a>
                                    <button class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteProduct"
                                        onclick="handleDelete('<?php echo $row[$i]['ID']; ?>', '<?php echo $numPage; ?>')">
                                        <img src="../images/deleteIconWhite.svg" alt="">
                                    </button>
                                    <a href="./themLichChieu.php?movieid=<?php echo $row[$i]['ID']; ?>">
                                        <button class="btn-date">
                                            <img src="../images/calendarIcon.svg" alt="">
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        if ($i - (((int) $numPage * $SumMovieOnPage) - $SumMovieOnPage) == $SumMovieOnPage - 1) {
                            break;
                        }
                        $checkHaveMovie += 1;
                    }
                    if ($checkHaveMovie == 0) {
                        if ($numPage != 1) {
                            echo "<script>location.href = '../pages/quanLyPhim.php?page=" . ($numPage - 1) . "';</script>";
                        }
                    }
                }
                ?>
            </tbody>
        </table>
        <nav class="d-flex justify-content-center" aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                $sumPage = ceil($MovieData->num_rows / $SumMovieOnPage);
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
                            if ($i == (int) $numPage - 1) {
                                echo '<li class="page-item active"><a class="page-link" href="./quanLyPhim.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="./quanLyPhim.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                            }
                            if ($i + 1 > 2) {
                                break;
                            }
                        }
                    } else {
                        echo '
                    <li class="page-item">
                        <a class="page-link" href="./quanLyPhim.php?page=' . ((int) $numPage - 1) . '" aria-label="Previous">
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
                        $countPage = 1;
                        for ($i; $i < $sumPage; $i++) {
                            if ($i == (int) $numPage - 1) {
                                echo '<li class="page-item active"><a class="page-link" href="./quanLyPhim.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                            } else {
                            echo '<li class="page-item"><a class="page-link" href="./quanLyPhim.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                            }
                            if ($countPage == 3) {
                                break;
                            }
                            $countPage++;
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
                                <a class="page-link" href="./quanLyPhim.php?page=' . ((int) $numPage + 1) . '" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        ';
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
    function handleDelete(id, numPage) {
        let link = document.getElementById('linkId');
        if (id) {
            link.href = `./quanLyPhim.php?page=${numPage}&movieid=${id}`
        }
    }
</script>

<?php
include("../includes/footer/adminFooter.php");
?>