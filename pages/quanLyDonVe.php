<?php
include("../includes/header/adminHeader.php");
?>

<?php
require_once("../classes/manageOrder.php");
?>

<?php
$classOrder = new manageOrder();
$getOrderData = $classOrder->get_all_order();
?>

<div class="movie-management">
    <div class="header">
        <img src="../images/managementIcon.png" alt="">
        <span>Quản lý đơn vé</span>
    </div>

    <div class="content">
        <table class="table table-striped table-info table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Mã đơn</th>
                    <th scope="col">Tên Phim</th>
                    <th scope="col">Số vé</th>
                    <th scope="col">Khách hàng</th>
                    <th scope="col">Tài khoản</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($getOrderData != false) {
                    $OrderData = $getOrderData->fetch_all(MYSQLI_ASSOC);
                    for ($i = 0; $i < count($OrderData); $i++) {
                        ?>
                        <tr>
                            <th scope="row">
                                <?php echo $OrderData[$i]['ID'] ?>
                            </th>
                            <td>
                                <?php echo $OrderData[$i]['MaDon'] ?> 
                            </td>
                            <td>
                                <?php echo $OrderData[$i]['TenPhim'] ?>
                            </td>
                            <td>
                                <?php echo $OrderData[$i]['SoLuong'] ?>
                            </td>
                            <td>
                                <?php echo $OrderData[$i]['TenKhach'] ?>
                            </td>
                            <td>
                                <?php echo $OrderData[$i]['Email'] ?>
                            </td>
                            <td>
                                <?php echo $OrderData[$i]['SDT'] ?>
                            </td>
                            <td>
                                <a href="#">
                                    <button 
                                        class="btn-detail" 
                                        data-bs-toggle="offcanvas" 
                                        data-bs-target="#offcanvasRight"
                                        aria-controls="offcanvasRight"
                                        onclick="handleDataOrderDetail(<?php echo $OrderData[$i]['ID']?>)"
                                    >
                                        Xem chi tiết
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="offcanvas offcanvas-order-detail offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Chi tiết đơn vé</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body offcanvas-order" id="resultOrderDetail" >
        
    </div>
</div>

<script>
    function handleDataOrderDetail(id) {
        let element =document.getElementById('resultOrderDetail')
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "../process/orderDetail.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                element.innerHTML = xhr.responseText;
            }
        }; 

        var data = "idOrder=" + id;
 
        xhr.send(data);
    }
</script>

<?php
include("../includes/footer/adminFooter.php");
?>