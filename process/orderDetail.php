<?php
require_once("../classes/manageOrder.php");
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idOrder = $_POST["idOrder"];
    $classOrder = new manageOrder();
    $getOrderById = $classOrder->get_order_by_id($idOrder);
    $getTicketInOrder = $classOrder->get_ticket_in_order_by_id($idOrder);

    if ($getOrderById != false) {
        $dataOrderById = $getOrderById->fetch_assoc();
    }

    if ( isset($getTicketInOrder) && $getTicketInOrder != false) {
        $dataTicketInOrder = $getTicketInOrder->fetch_all(MYSQLI_ASSOC);
    }
}

$sumPrice = 0;

if (isset($dataTicketInOrder)) {
    for ($i = 0; $i < count($dataTicketInOrder); $i++) {
        $sumPrice += $dataTicketInOrder[$i]["GiaVe"];
    }
}

if (isset($dataOrderById)) {
    echo '<div class="info-content">
            <p class="title">Thông tin chi tiết</p>
            <div class="box-text">
                <span class="label">Tên phim: </span>
                <span class="text">' . $dataOrderById['TenPhim'] . '</span>
            </div>
            <div class="box-text">
                <span class="label">Mã đơn: </span>
                <span class="text">' . $dataOrderById['MaDon'] . '</span>
            </div>
            <div class="box-text">
                <span class="label">Số vé: </span>
                <span class="text">' . $dataOrderById['SoLuong'] . '</span>
            </div>
            <div class="box-text">
                <span class="label">Tổng tiền: </span>
                <span class="text">' . number_format($sumPrice) . '<b> VND</b></span>
            </div>
            <hr>
            <p class="title">Thông tin Khách hàng</p>
            <div class="box-text">
                <span class="label">Tên: </span>
                <span class="text">' . $dataOrderById['TenKhach'] . '</span>
            </div>
            <div class="box-text">
                <span class="label">Email: </span>
                <span class="text">' . $dataOrderById['Email'] . '</span>
            </div>
            <div class="box-text">
                <span class="label">SDT: </span>
                <span class="text">' . $dataOrderById['SDT'] . '</span>
            </div>
        </div>';
}
if (isset($dataTicketInOrder)) {
    echo '<div class="ticket-content">';
    echo '<p class="title">Thông tin vé</p>';
    for ($i = 0; $i < count($dataTicketInOrder); $i++) {
        echo '<div class="ticket-box">
        <div class="ticket-col">
                <p class="label">Phòng</p>
                <p class="text">' . $dataTicketInOrder[$i]['TenPhong'] . '</p>
            </div> 
            <div class="ticket-col">
                <p class="label">Ghế</p>
                <p class="text">' . $dataTicketInOrder[$i]['TenGhe'] . $dataTicketInOrder[$i]['Cot'] . '</p>
            </div>
            <div class="ticket-col">
                <p class="label">Ngày chiếu</p>
                <p class="text">' . date('d-m-Y', strtotime($dataTicketInOrder[$i]['Ngay'])) . '</p>
            </div>
            <div class="ticket-col">
                <p class="label">Giờ bắt đầu</p>
                <p class="text">' . date('H:i', strtotime($dataTicketInOrder[$i]['GioBD'])) . '</p>
            </div>
            <div class="ticket-col">
                <p class="label">Giá vé</p>
                <p class="text">' . number_format($dataTicketInOrder[$i]['GiaVe']) . '<b> VND</b></p>
            </div>
            </div>';
    }
    ;
    echo '</div>';
}
?>