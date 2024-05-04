<?php
include("../includes/header/header.php");
?>

<?php
include("../classes/movie.php");
include("../classes/chair.php");
?>

<?php
$classMovie = new Movie();
$classChair = new Chair();

if (isset($_GET["lichChieuId"])) {
    $lichChieuId = $_GET["lichChieuId"];
    $movieID = $_GET["sanPhamId"];
    $getMovieByShotimeId = $classMovie->get_movie_by_showtime_id($lichChieuId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numTicket = $_POST['numTicket'];
    }
}

if (isset($_GET["numTicket"])) {
    $numTicket = $_GET["numTicket"];
}

?>

<main>
    <div class="space-header"></div>
    <?php
    if ($getMovieByShotimeId != false) {
        $dataMovieByShotimeId = $getMovieByShotimeId->fetch_assoc();
        ?>
        <div class="select-chair-container">
            <div class="info-movie">
                <div class="title">
                    <b>TÊN PHIM: </b>
                    <span class="name-movie">
                        <?php
                        echo $dataMovieByShotimeId['TenPhim'];
                        ?>
                    </span>
                </div>
                <div class="row info-movie-cart">
                    <div class="item col d-flex flex-column align-items-center">
                        <p class="title">Thời gian</p>
                        <p>
                            <?php echo date('H:i', strtotime($dataMovieByShotimeId['GioBD'])) ?>
                        </p>
                    </div>
                    <div class="item col d-flex flex-column align-items-center">
                        <p class="title">Ngày</p>
                        <p>
                            <?php echo date('d-m-Y', strtotime($dataMovieByShotimeId['Ngay'])) ?>
                        </p>
                    </div>
                    <div class="item col d-flex flex-column align-items-center">
                        <p class="title">Số lượng</p>
                        <p>
                            <?php echo $numTicket ?> vé
                        </p>
                    </div>
                    <div class="item col d-flex flex-column align-items-center">
                        <p class="title">Tổng số tiền</p>
                        <p>
                            <?php
                            echo number_format(((int) $numTicket * (int) $dataMovieByShotimeId['GiaVe']));
                            ?><b> VND</b>
                        </p>
                    </div>
                </div>
            </div>
            <div class="box-screen">
                <p>MÀN HÌNH</p>
            </div>
            <div class="select-chair-content">
                <div class="space">
                    <?php
                    $getNumRow = $classChair->get_num_row_on_chair();
                    $getChairSelected = $classChair->get_chair_is_selected($lichChieuId);
                    if ($getChairSelected != false) {
                        $rowChairSelected = $getChairSelected->fetch_all(MYSQLI_ASSOC);
                    } else {
                        $rowChairSelected = false;
                    }

                    if ($getNumRow != false) {
                        $NumRow = $getNumRow->fetch_assoc();
                        for ($i = 1; $i <= (int) $NumRow['Hang']; $i++) {
                            ?>
                            <div class="seat">
                                <?php
                                $getChairByNumRow = $classChair->get_chair_by_num_row($i);
                                if ($getChairByNumRow != false) {
                                    $row = $getChairByNumRow->fetch_all(MYSQLI_ASSOC);

                                    for ($j = 0; $j < count($row); $j++) {
                                        ?>
                                        <?php
                                        $checkHaveChairSelected = false;
                                        if ($rowChairSelected != false) {
                                            for ($k = 0; $k < count($rowChairSelected); $k++) {
                                                if ($rowChairSelected[$k]['Ghe_ID'] == $row[$j]['ID']) {
                                                    $checkHaveChairSelected = true;
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                        <?php
                                        if ($checkHaveChairSelected == true) {
                                            ?>
                                            <div id="<?php echo $row[$j]['ID'] ?>" class="seat-item seat-selected"
                                                onclick="handleSelectChair(`<?php echo $row[$j]['ID'] ?>`, `<?php echo (int) $numTicket ?>`, true)">
                                                <p class="seat-text">
                                                    <?php echo $row[$j]['TenGhe'] . $row[$j]['Cot'] ?>
                                                </p>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div id="<?php echo $row[$j]['ID'] ?>" class="seat-item"
                                                onclick="handleSelectChair(`<?php echo $row[$j]['ID'] ?>`, `<?php echo (int) $numTicket ?>`, false)">
                                                <p class="seat-text">
                                                    <?php echo $row[$j]['TenGhe'] . $row[$j]['Cot'] ?>
                                                </p>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="seat-description">
                    <div class="seat-description-item">
                        <div class="seat-desc-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </div>
                        <div class="seat-desc-text">Đã đặt</div>
                    </div>
                    <div class="seat-description-item">
                        <div class="seat-desc-icon seat-pick"></div>
                        <div class="seat-desc-text">Ghế bạn chọn</div>
                    </div>
                    <!-- <div class="seat-description-item">
                        <div class="seat-desc-icon seat-center"></div>
                        <div class="seat-desc-text">Ghế trung tâm</div>
                    </div>
                    <div class="seat-description-item">
                        <div class="seat-desc-icon seat-normal"></div>
                        <div class="seat-desc-text">Ghế thường</div>
                    </div> -->

                </div>
            </div>
            <div class="d-flex justify-content-around">
                <a href="./lichChieu.php?sanPhamId=<?php echo $movieID ?>" class="w-25">
                    <button class="btn btn-secondary w-100">Quay lại
                    </button>
                </a>
                <a id="linkNext" href="#" class="w-25">
                    <button class="btn btn-primary w-100"
                        onclick="handleBookTicket(`<?php echo (int) $numTicket ?>`, `<?php echo (int) $lichChieuId ?>`)">Đặt
                        vé
                        <img src="../images/nextIcon.svg" alt="">
                    </button>
                </a>
            </div>
        </div>
        <?php
    }
    ?>
    <div id="alert" class="alert alert-hiden">
        <svg xmlns="http://www.w3.org/2000/svg" height="40px" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"
            viewBox="0 0 16 16" role="img" aria-label="Warning:" fill="#FFF500">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div id="msgAlert">

        </div>
        <button type="button" class="btn-close" onclick="handleCloseAlert()"></button>
    </div>
</main>

<script>
    var dataChair = []
    let alert = document.getElementById('alert')
    let msgAlert = document.getElementById('msgAlert')
    let linkNext = document.getElementById('linkNext')

    function handleCloseAlert() {
        alert.classList.remove('alert-chair')
    }

    function handleSelectChair(idChair, limit, selected) {
        let divChair = document.getElementById(`${idChair}`);
        let checkIsSelected = false
        if (selected) {
            msgAlert.innerHTML = 'Ghế đã có người chọn'
            alert.classList.add('alert-chair')
            setTimeout(function () {
                handleCloseAlert()
            }, 3000);
            return
        }
        for (let i = 0; i < dataChair.length; i++) {
            if (dataChair[i] === idChair) {
                dataChair.splice(i, 1)
                checkIsSelected = true
                break;
            }
        }
        if (dataChair.length === parseInt(limit)) {
            msgAlert.innerHTML = 'Bạn đã chọn đủ ghế'
            alert.classList.add('alert-chair')
            setTimeout(function () {
                handleCloseAlert()
            }, 3000);
            return
        }
        if (checkIsSelected) {
            divChair.classList.remove('user-selected-chair')
            return
        }

        dataChair.push(idChair)
        divChair.classList.add('user-selected-chair')
    }

    function handleBookTicket(limit, lichChieuId) {
        if (dataChair.length < parseInt(limit)) {
            msgAlert.innerHTML = `Bạn phải chọn đủ ${limit} ghế cho ${limit} vé`
            alert.classList.add('alert-chair')
            return
        }

        let inputData = dataChair.join(',')
        location.href = `./thuTucThanhToan.php?lichChieuId=${lichChieuId}&chairId=${inputData}&numTicket=${limit}`;
    }
</script>

<?php
include("../includes/footer/footer.php");
?>