<?php
require_once("../lib/session.php");
require_once("../classes/order.php");
?>

<?php
$classOrder = new Order();
?>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numPage = $_POST["numPage"];
    $user_id = $_POST["user_id"];
    $sumOrderOnPage = $_POST["sumOrderOnPage"];
    
    $getdataOrderByIdUser = $classOrder->get_order_by_user_id($user_id);

    $SumOrderOnPage = $sumOrderOnPage;

    if ($getdataOrderByIdUser != false) {
        $dataOrderByIdUser = $getdataOrderByIdUser->fetch_all(MYSQLI_ASSOC);
        $countOrder = 0;
        for ($i = ((int) $numPage * $SumOrderOnPage) - $SumOrderOnPage; $i < count($dataOrderByIdUser); $i++) {

            echo '<div class="ticket-content my-3 ">
            <div class="img">
                <img src="../uploads/' . $dataOrderByIdUser[$i]['Anh'] . '" alt="">
            </div>
            <div class="content">
                <p class="title">
                    ' . $dataOrderByIdUser[$i]['TenPhim'] . '
                </p>
                <div class="box-text">
                    <span class="label">Ngày đặt vé: </span>
                    <span class="text">
                        ' . date('d-m-Y', strtotime($dataOrderByIdUser[$i]['NgayDatVe'])) . '
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="box-text">
                        <span class="label">Ngày chiếu: </span>
                        <span class="text">
                            ' . date('d-m-Y', strtotime($dataOrderByIdUser[$i]['Ngay'])) . '
                        </span>
                    </div>
                    <div class="box-text">
                        <span class="label">Giờ chiếu: </span>
                        <span class="text">
                            ' . date('H:i', strtotime($dataOrderByIdUser[$i]['GioBD'])) . '
                        </span>
                    </div>
                </div>
                <div class="ticket">';
            $getTicketInOrderById = $classOrder->get_ticket_in_order_by_id($dataOrderByIdUser[$i]['ID']);
            $sumPrice = 0;
            if ($getTicketInOrderById != false) {
                $ticketOrder = $getTicketInOrderById->fetch_all(MYSQLI_ASSOC);
                for ($j = 0; $j < count($ticketOrder); $j++) {

                    echo '<div class="box-ticket">
                                <div class="box-text">
                                    <span class="label">Phòng: </span>
                                    <span class="text">
                                        ' . $ticketOrder[$j]['TenPhong'] . '
                                    </span>
                                </div>
                                <div class="box-text">
                                    <span class="label">Ghế: </span>
                                    <span class="text">
                                        ' . $ticketOrder[$j]['TenGhe'] . $ticketOrder[$j]['Cot'] . '
                                    </span>
                                </div>
                                <div class="box-text">
                                    <span class="label">Giá vé: </span>
                                    <span class="text">
                                        ' . $ticketOrder[$j]['GiaVe'] . '
                                    </span>
                                </div>
                            </div>';

                    $sumPrice += $ticketOrder[$j]['GiaVe'];
                }
            }

            echo '</div>
                <div class="footer">
                    <span class="label">Tổng tiền: </span>
                    <span class="text">
                        ' . $sumPrice . '
                    </span>
                </div>
            </div>
        </div>';

            $countOrder += 1;
            if ($countOrder == $SumOrderOnPage) {
                break;
            }
        }
    }
    else {
        echo '<div><h4 class="text-center my-5" >Bạn chưa đặt vé nào trước đó!</h4></div>';
    }
}
?>