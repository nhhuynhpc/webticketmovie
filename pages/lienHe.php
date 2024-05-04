<?php
include("../includes/header/header.php");
?>

<main>
    <div class="space-header"></div>
    <div class="lien-he-container">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="lien-he-infor d-flex flex-column align-items-center">
                <div class="lien-he-infor_item w-100 my-3">
                    <div class="d-flex align-items-start">
                        <span class="lien-he-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <div>
                            <p class="lien-he-infor_item_header">Địa chỉ</p>
                            <p class="lien-he-infor_item_text">Đường Hồ Tùng Mậu, Quận Cầu Giấy, Hà Nội</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="d-flex align-items-start me-2">
                            <span class="lien-he-icon">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <div>
                                <a href="tel:09xxxxxxxx">
                                    <p class="lien-he-infor_item_header">Điện thoại</p>
                                    <p class="lien-he-infor_item_text">09xxxxxxxx</p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-start ms-2">
                            <span class="lien-he-icon">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <div>
                                <p class="lien-he-infor_item_header">Email</p>
                                <p class="lien-he-infor_item_text">xxxxxxxxxx@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lien-he-infor_item w-100 my-3">
                    <p class="lien-he-infor_item_title" >Gửi thắc mắc cho chúng tôi</p>
                    <p class="lien-he-infor_item_label" >Nếu bạn có thắc mắc gì, có thể gửi yêu cầu cho chúng tôi, và chúng tôi sẽ liên lạc lại với bạn
                        sớm nhất có thể.</p>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tên của bạn</label>
                        <input type="text" class="form-control"
                            placeholder="Nhập tên của bạn...">
                    </div>
                    <div class="d-flex justify-content-between w-100">
                    <div class="mb-3 w-50 me-2">
                        <label for="exampleFormControlInput1" class="form-label">Email của bạn</label>
                        <input type="text" class="form-control"
                            placeholder="Nhập email của bạn...">
                    </div>
                    <div class="mb-3 w-50 ms-2">
                        <label for="exampleFormControlInput1" class="form-label">Số điện thoại của bạn</label>
                        <input type="text" class="form-control"
                            placeholder="Nhập số điện thoại của bạn...">
                    </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Nhập nội dung..."></textarea>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary px-5">GỬI CHO CHÚNG TÔI</button>
                    </div>
                </div>
            </div>
            <div class="lien-he-map">
                <iframe class="map"
                    src="https://maps.google.it/maps?q=Đường Hồ Tùng Mậu, Quận Cầu Giấy, Hà Nội&output=embed"
                    frameborder="0" scrolling="no" width="100%" height="100%"></iframe>
            </div>
        </div>
    </div>
</main>

<?php
include("../includes/footer/footer.php");
?>