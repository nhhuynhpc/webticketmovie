<?php
include("../includes/header/header.php");
?>

<?php
require_once("../classes/movie.php");
require_once("../classes/chair.php");
require_once("../classes/order.php");
?>

<?php
$classMovie = new Movie();
$classChair = new Chair();
$classOrder = new Order();

if (isset($_GET["lichChieuId"])) {
    $lichChieuId = $_GET["lichChieuId"];
    $numTicket = $_GET["numTicket"];
    $chairId = explode(',', $_GET["chairId"]);
    $getMovieByShotimeId = $classMovie->get_movie_by_showtime_id($lichChieuId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $dataMovieByShotimeId = $getMovieByShotimeId->fetch_assoc();
        $insertOrder = $classOrder->insert_order($_POST, $dataMovieByShotimeId['Phim_ID'], $lichChieuId, $chairId, $numTicket);
    }
}

?>

<?php
if (isset($insertOrder)) {
    if ($insertOrder['status'] == 'success') {
        $alertIcon = '<img src="../images/successIcon.svg" alt="">';
    } else {
        $alertIcon = '<img src="../images/warning.svg" alt="">';
    }
    echo '
    <div class="onclose-alert" id="onCloseAlert" onclick="handleCloseAlert(`' . $insertOrder['status'] . '`)">
    </div>
    <div class="info-alert alert alert-danger" id="alert" role="alert">
    <div class="d-flex flex-row justify-content-center align-items-center">
    ' . $alertIcon . '
    <p>' . $insertOrder['msg'] . '</p>
    </div>
        <div class="d-flex justify-content-center mt-3">
    <button type="button" class="btn btn-info" onclick="handleAlert(`' . $insertOrder['status'] . '`)" style="width: 230px;">Xác nhận</button>
    </div>
    </div>';
}
?>

<main>
    <div class="space-header"></div>
    <div class="order-container">
        <div class="order-header">
            <p style="margin: 0;font-size: 20px;font-style: italic;text-align: center;">
                Cảm ơn quý khách đã đến với Cinestar !
            </p>
            <p style="margin: 0;font-size: 20px;font-style: italic;text-align: center;">
                Xin quý khách vui lòng kiểm tra lại thông tin đặt vé
            </p>
            <?php
            if ($getMovieByShotimeId != false) {
                if (!isset($dataMovieByShotimeId)) {
                    $dataMovieByShotimeId = $getMovieByShotimeId->fetch_assoc();
                }
                ?>
                <div class="order-header-content">
                    <div class="order-img-product">
                        <img src="../uploads/<?php echo $dataMovieByShotimeId['Anh']; ?>" alt="">
                    </div>
                    <div class="content_info">
                        <p class="content_info-header">
                            <?php echo $dataMovieByShotimeId['TenPhim']; ?>
                        </p>
                        <p><span style="color: #AAAAAA;font-size: 16px;font-weight: 550;">Ngày chiếu:
                            </span><b>
                                <?php echo date('d/m/Y', strtotime($dataMovieByShotimeId['Ngay'])) ?>
                            </b></p>
                        <p><span style="color: #AAAAAA;font-size: 16px;font-weight: 550;">Xuất chiếu: </span><b>
                                <?php echo date('H:i', strtotime($dataMovieByShotimeId['GioBD'])) ?>
                            </b>
                        </p>
                        <p><span style="color: #AAAAAA;font-size: 16px;font-weight: 550;">Số lượng: </span><b>
                                <?php echo $numTicket; ?>
                            </b></p>
                        <?php
                        for ($i = 0; $i < (int) $numTicket; $i++) {
                            $getChairById = $classChair->get_chair_by_id($chairId[$i]);
                            if ($getChairById != false) {
                                $dataChairById = $getChairById->fetch_assoc();
                                ?>
                                <div class="content_info-price d-flex justify-content-between my-2">
                                    <div class="title">
                                        <p style="color: #aaaaaa;font-size: 16px;font-weight: 550;">
                                            Ghế
                                        </p>
                                    </div>

                                    <div class="w-75 d-flex justify-content-between" style=" background-color: #F7F3EE;">
                                        <p style="color: #AAAAAA;font-size: 16px;font-weight: 550;">
                                            <?php echo $dataChairById['TenGhe'] . $dataChairById['Cot'] ?>
                                        </p>
                                        <p><b style="font-size: 18px;">
                                                <?php echo $dataMovieByShotimeId['GiaVe']; ?>VND
                                            </b></p>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div class="content_info-footer d-flex justify-content-between">
                            <p>SỐ TIỀN CẦN THANH TOÁN</p>
                            <span>
                                <?php
                                echo number_format(((int) $numTicket * (int) $dataMovieByShotimeId['GiaVe']));
                                ?> VND
                            </span>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="order-content">
            <p class="title">
                ĐIỀU KHOẢN CHUNG
            </p>
            <div class="order-rules">
                <span>Việc bạn sử dụng website này đồng nghĩa với việc bạn đồng ý với những thỏa thuận dưới đây.</span>
                <span>Nếu bạn không đồng ý, xin vui lòng không sử dụng website.</span>
                <ol>
                    <li>Trách nhiệm của người sử dụng:</li>
                    <span>Khi truy cập vào trang web này, bạn đồng ý chấp nhận mọi rủi ro. Cinestar và các bên đối tác
                        khác không chịu trách nhiệm về bất kỳ tổn thất nào do những hậu quả trực tiếp, tình cờ hay gián
                        tiếp; những thất thoát, chi phí (bao gồm chi phí pháp lý, chi phí tư vấn hoặc các khoản chi tiêu
                        khác) có thể phát sinh trực tiếp hoặc gián tiếp do việc truy cập trang web hoặc khi tải dữ liệu
                        về máy; những tổn hại gặp phải do virus, hành động phá hoại trực tiếp hay gián tiếp của hệ thống
                        máy tính khác, đường dây điện thoại, phần cứng, phần mềm, lỗi chương trình, hoặc bất kì các lỗi
                        nào khác; đường truyền dẫn của máy tính hoặc nối kết mạng bị chậm…</span>
                    <li>Về nội dung trên trang web:</li>
                    <span>Tất cả những thông tin ở đây được cung cấp cho bạn một cách trung thực như bản thân sự việc.
                        Cinestar và các bên liên quan không bảo đảm, hay có bất kỳ tuyên bố nào liên quan đến tính chính
                        xác, tin cậy của việc sử dụng hay kết quả của việc sử dụng nội dung trên trang web này. Nột dung
                        trên website được cung cấp vì lợi ích của cộng đồng và có tính phi thương mại. Các cá nhân và tổ
                        chức không được phếp sử dụng nội dung trên website này với mục đích thương mại mà không có sự
                        ưng thuận của Cinestar bằng văn bản. Mặc dù Cinestar luôn cố gắng cập nhật thường xuyên các nội
                        dung tại trang web, nhưng chúng tôi không bảo đảm rằng các thông tin đó là mới nhất, chính xác
                        hay đầy đủ. Tất cả các nội dung website có thể được thay đổi bất kỳ lúc nào.</span>
                    <li>Về bản quyền:</li>
                    <span>Cinestar là chủ bản quyền của trang web này. Việc chỉnh sửa trang, nội dung, và sắp xếp thuộc
                        về thẩm quyền của Cinestar. Sự chỉnh sửa, thay đổi, phân phối hoặc tái sử dụng những nội dung
                        trong trang này vì bất kì mục đích nào khác được xem như vi phạm quyền lợi hợp pháp của
                        Cinestar.</span>
                    <li>Về việc sử dụng thông tin:</li>
                    <span>Chúng tôi sẽ không sử dụng thông tin cá nhân của bạn trên website này nếu không được phép. Nếu
                        bạn đồng ý cung cấp thông tin cá nhân, bạn sẽ được bảo vệ. Thông tin của bạn sẽ được sử dụng với
                        mục đích, liên lạc với bạn để thông báo các thông tin cập nhật của Cinestar như lịch chiếu phim,
                        khuyến mại qua email hoặc bưu điện. Thông tin cá nhân của bạn sẽ không được gửi cho bất kỳ ai sử
                        dụng ngoài trang web Cinestar, ngoại trừ những mở rộng cần thiết để bạn có thể tham gia vào
                        trang web (những nhà cung cấp dịch vụ, đối tác, các công ty quảng cáo) và yêu cầu cung cấp bởi
                        luật pháp. Nếu chúng tôi chia sẻ thông tin cá nhân của bạn cho các nhà cung cấp dịch vụ, công ty
                        quảng cáo, các công ty đối tác liên quan, thì chúng tôi cũng yêu cầu họ bảo vệ thông tin cá nhân
                        của bạn như cách chúng tôi thực hiện.</span>
                    <li>Vể việc tải dữ liệu:</li>
                    <span>Nếu bạn tải về máy những phần mềm từ trang này, thì phần mềm và các dữ liệu tải sẽ thuộc bản
                        quyền của Cinestar và cho phép bạn sử dụng. Bạn không được sở hữu những phầm mềm đã tải và
                        Cinestar không nhượng quyền cho bạn. Bạn cũng không được phép bán, phân phối lại, hay bẻ khóa
                        phần mềm…</span>
                    <li>Thay đổi nội dung:</li>
                    <span>Cinestar giữ quyền thay đổi, chỉnh sửa và loại bỏ những thông tin hợp pháp vào bất kỳ thời
                        điểm nào vì bất kỳ lý do nào.</span>
                    <li>Liên kết với các trang khác:</li>
                    <span>Mặc dù trang web này có thể được liên kết với những trang khác, Cinestar không trực tiếp hoặc
                        gián tiếp tán thành, tổ chức, tài trợ, đứng sau hoặc sát nhập với những trang đó, trừ phi điều
                        này được nêu ra rõ ràng. Khi truy cập vào trang web bạn phải hiểu và chấp nhận rằng Cinestar
                        không thể kiểm soát tất cả những trang liên kết với trang Cinestar và cũng không chịu trách
                        nhiệm cho nội dung của những trang liên kết.</span>
                    <li>Đưa thông tin lên trang web:</li>
                    <span>Bạn không được đưa lên, hoặc chuyển tải lên trang web tất cả những hình ảnh, từ ngữ khiêu dâm,
                        thô tục, xúc phạm, phỉ báng, bôi nhọ, đe dọa, những thông tin không hợp pháp hoặc những thông
                        tin có thể đưa đến việc vi phạm pháp luật, trách nhiệm pháp lý. Cinestar và tất cả các bên có
                        liên quan đến việc xây dựng và quản lý trang web không chịu trách nhiệm hoặc có nghĩa vụ pháp lý
                        đối với những phát sinh từ nội dung do bạn tải lên trang web.</span>
                    <li>Luật áp dụng:</li>
                    <span>Mọi hoạt động phát sinh từ trang web có thể sẽ được phân tích và đánh giá theo luật pháp Việt
                        Nam và toà án Tp. Hồ Chí Minh. Và bạn phải đồng ý tuân theo các điều khoản riêng của các toà án
                        này.</span>
                </ol>
            </div>
            <form action="" method="post">
                <div class="form-info">
                    <p class="title">Vui lòng nhập tên, điện thoại và email</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Tên</span>
                        <input type="text" name="TenKhach" value="<?php echo Session::get('TenTaiKhoan')?>" class="form-control" placeholder="Nhập họ tên..."
                            aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Email</span>
                        <input type="email" name="Email" value="<?php echo Session::get('Email')?>" class="form-control" placeholder="Nhập email..."
                            aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Điện thoại</span>
                        <input type="text" name="SDT" class="form-control" placeholder="Nhập số điện thoại"
                            aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="order-content-footer">
                    <a
                        href="./chonGhe.php?sanPhamId=<?php echo $dataMovieByShotimeId['Phim_ID']; ?>&lichChieuId=<?php echo $lichChieuId ?>&numTicket=<?php echo $numTicket ?>">
                        <button type="button" class="btn btn-secondary">
                            Quay lại
                        </button>
                    </a>
                    <button type="submit" name="submit" class="btn btn-primary">Thanh toán</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    function handleCloseAlert(data) {
        let element = document.getElementById("onCloseAlert");
        let elementAlert = document.getElementById("alert");
        element.remove()
        elementAlert.remove()
        if (data === "success") {
            location.href = '../pages/hoSo.php?typeSelect=order';
        }
    }
    function handleAlert(data) {
        handleCloseAlert();
        if (data === "success") {
            location.href = '../pages/hoSo.php?typeSelect=order';
        }
    }
</script>

<?php
include("../includes/footer/footer.php");
?>