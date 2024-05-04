<?php
include("../includes/header/header.php");
?>

<?php
include("../classes/movie.php");
require_once("../helpers/format.php");
?>

<?php
$fm = new Format();
$classMovie = new Movie();

if (isset($_GET["lichChieuId"])) {
    $lichChieuId = $_GET["lichChieuId"];
}

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
        <div class="showtimes-container d-flex justify-content-between">
            <div class="showtimes-img">
                <img src="../uploads/<?php echo $movieDataById['Anh'] ?>" alt="img product">
            </div>
            <div class="showtimes-content">
                <p class="showtimes-title">
                    <?php echo $movieDataById['TenPhim'] ?>
                </p>
                <div class="select-time">
                    <p class="title">
                        Chọn ngày
                    </p>
                    <div class="select-date-content">
                        <div class="date-selected">
                            <?php
                            $getAllMovie = $classMovie->get_all_movie_by_id_and_day($movieID);
                            if ($getAllMovie != false) {
                                $row = $getAllMovie->fetch_all(MYSQLI_ASSOC);
                                for ($i = 0; $i < count($row); $i++) {
                                    ?>
                                    <a
                                        href="./lichChieu.php?sanPhamId=<?php echo $movieID . '&lichChieuId=' . $row[$i]['LichChieu_ID'] ?>">
                                        <button id="<?php echo $i ?>" class="<?php
                                           if (isset($lichChieuId)) {
                                               if ($row[$i]['LichChieu_ID'] == $lichChieuId) {
                                                   echo 'selected';
                                               }
                                           }
                                           ?>">
                                            <p>
                                                <?php
                                                echo date('\T\h\. m', strtotime($row[$i]['Ngay']));
                                                ?>
                                            <p>
                                                <?php
                                                echo date('d', strtotime($row[$i]['Ngay']));
                                                ?>
                                            <p>
                                                <?php
                                                $dateVN = $fm->translate_date_format($row[$i]['Ngay']);
                                                echo $dateVN;
                                                ?>
                                            </p>
                                        </button>
                                    </a>
                                    <?php
                                    if ($i == 2) {
                                        break;
                                    }
                                }
                                ?>
                            </div>

                            <div class="select-footer">
                                <p>Ngày đã chọn: </p>
                                <?php
                                if (isset($lichChieuId)) {
                                    $getOneMovieBYDay = $classMovie->get_one_movie_by_id_and_day($movieID, $lichChieuId);
                                    $dataOneMovieBYDay = $getOneMovieBYDay->fetch_assoc();
                                    ?>
                                    <input type="date" id="dateSelected" readonly value="<?php echo $dataOneMovieBYDay['Ngay'] ?>">
                                    <?php
                                } else {
                                    ?>
                                    <p id="disSelected">Chưa chọn</p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                        if (isset($lichChieuId)) {
                            ?>
                            <p class="title">
                                Chọn khung giờ
                            </p>
                            <div id="select-time-content" class="d-flex flex-wrap">
                                <?php
                                $getAllMovieByTime = $classMovie->get_all_movie_by_id_and_time($movieID, $dataOneMovieBYDay['Ngay']);
                                if ($getAllMovieByTime != false) {
                                    $row = $getAllMovieByTime->fetch_all(MYSQLI_ASSOC);
                                    for ($i = 0; $i < count($row); $i++) {
                                        ?>
                                        <div style="max-width: 70px;" class="m-2">
                                            <a
                                                href="./lichChieu.php?sanPhamId=<?php echo $movieID . '&lichChieuId=' . $lichChieuId . '&lichChieuByTime=' . $row[$i]['LichChieu_ID'] ?>">
                                                <button class="btn">
                                                    <?php echo date('H:i', strtotime($row[$i]['GioBD'])) ?>
                                                </button>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>

                            <div class="select-footer">
                                <p>Giờ đã chọn: </p>
                                <?php
                                if (isset($_GET['lichChieuByTime'])) {
                                $lichChieuByTime = $_GET['lichChieuByTime'];
                                    $getOneMovieBYTime = $classMovie->get_one_movie_by_id_and_day($movieID, $lichChieuByTime);
                                    $dataOneMovieBYTime = $getOneMovieBYTime->fetch_assoc();
                                    ?>
                                    <input type="time" id="dateSelected" readonly value="<?php echo $dataOneMovieBYTime['GioBD'] ?>">
                                    <?php
                                } else {
                                    ?>
                                    <p id="disSelected">Chưa chọn</p>
                                    <?php
                                }
                                ?>
                            </div>

                            <?php
                        }
                        ?>
                        <form action="./chonGhe.php?sanPhamId=<?php echo $movieID . '&lichChieuId='.$lichChieuByTime ?>" method="post" >
                            <div class="count-tiket d-flex justify-content-between mt-3">
                                <p style="white-space: nowrap;"><b>Số lượng: </b></p>
                                <div class="in-product-count input-group mb-3">
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="handleChangeCountProduct('reduce')">-</button>
                                    <input type="text" id="sp1" value="1" name="numTicket" >
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="handleChangeCountProduct('increas')">+</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around">
                                <a href="chiTietSanPham.php?sanPhamId=<?php echo $movieID?>" class="w-25">
                                    <div class="btn btn-secondary w-100">Quay lại
                                    </div>
                                </a>
                                <a href="#" class="w-25">
                                    <button class="btn btn-primary w-100">Tiếp theo
                                        <img src="../images/nextIcon.svg" alt="">
                                    </button>
                                </a>
                            </div>
                        </form>
                    </div>
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

    // function createTimeContent() {
    //     var timeBySelect = ['09:05', '09:35', '10:10', '10:50', '11:45', '12:15', '12:45', '14:20', '14:50', '15:20', '17:00', '17:30', '18:00', '18:30', '19:10', '19:40', '20:10', '20:40', '21:10', '22:15', '22:45']
    //     const itemSelectTime = document.getElementById('select-time-content');

    //     for (let item of timeBySelect) {
    //         itemSelectTime.innerHTML = itemSelectTime.innerHTML + `
    //                 <div style="max-width: 50px;" class="m-2" >
    //                     <button class="btn" >${item}</button>
    //                 </div>
    //         `
    //     }
    // }



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


    createTimeContent()
</script>

<?php
include("../includes/footer/footer.php");
?>