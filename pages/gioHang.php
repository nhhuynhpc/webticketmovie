<?php
include("../includes/header/header.php");
?>

<main>
    <div class="space-header"></div>
    <div class="cart-container">
        <div class="cart-product">
            <div class="cart-header d-flex justify-content-between align-items-center">
                <p style="font-size: 22px; font-weight: 700;">Giỏ hàng của bạn</p>
                <p style="font-size: 15px; font-weight: 600; color: #5f5d5d;">Bạn đang có 2 sản phẩm trong giỏ hàng</p>
            </div>
            <div class="card-product">
                <div class="card-product-img">
                    <img src="../images/38526fc6e83cf994a08f51568383cff2.png" alt="..." width="100%" height="100%">
                </div>
                <div class="card-product-body">
                    <div class=" d-flex justify-content-between" >
                        <div class="card-product-conent">
                            <p class="card-product-title">ĐẤT RỪNG PHƯƠNG NAM</p>
                            <p class="card-product-price">95,000 ₫</p>
                            <div class="in-product-count input-group mb-3">
                                <button class="btn btn-outline-secondary" type="button" onclick="handleChangeCountProduct('reduce')" >-</button>
                                <input type="text" id="sp1" value="1">
                                <button class="btn btn-outline-secondary" type="button" onclick="handleChangeCountProduct('increas')">+</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center card-product-delete">
                            <button type="button" class="btn">
                                <img id="iconCart" src="../images/deleteIcon.svg" alt="delete icon">
                            </button>
                        </div>
                    </div>
                    <div class="card-product-footer">
                        <p><b>Tổng: </b> <span>95,000 ₫</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-order"> 
            <div class="cart-order-content">
                <div class="cart-order-header d-flex justify-content-between align-items-center">
                    <span style="font-size: 16px;font-weight: 550;color: #676767;" ><b>Tổng tiền:</b></span>
                    <span style="font-size: 18px;font-weight: 650;color: #E34B79;">95,000 ₫</span>
                </div>
                <ul>
                    <li>Chứng thực độ tuổi theo yêu cầu của phim</li>
                    <li>Bạn cũng có thể nhập mã giảm giá ở trang thanh toán.</li>
                </ul>
                <div class="d-flex justify-content-center mt-3">
                    <button type="button" class="btn">THANH TOÁN</button>
                </div>
            </div>
            <div class="cart-order-sumary-policy">
                <p><b>Chính sách mua hàng:</b></p>
                <p>Vé đã mua không thể đổi hay trả lại</p>
            </div>
        </div>
    </div>
</main>
<script >
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