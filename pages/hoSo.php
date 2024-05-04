<?php
include("../includes/header/header.php");
?>
<?php
require_once("../classes/user.php");
require_once("../classes/order.php");
?>

<?php
$classUser = new User();
$classOrder = new Order();
$user_id = Session::get("ID");
$getDataUserById = $classUser->get_user_by_id();
$getdataOrderByIdUser = $classOrder->get_order_by_user_id($user_id);
$sumOrderOnPage = 2;
$sumTapOnPage = 3;
if ($getdataOrderByIdUser != false) {
$dataOrderByIdUser = $getdataOrderByIdUser->fetch_all(MYSQLI_ASSOC);
$sumPage = ceil(count($dataOrderByIdUser) / $sumOrderOnPage);
} else {
    $sumPage = 1;
}

if ($getDataUserById != false) {
    $dataUserById = $getDataUserById->fetch_assoc();
} else {
    $dataUserById = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (isset($_GET['typepost']) && $_GET['typepost'] == 'info') {
        $updateUser = $classUser->update_user_by_id($_POST);
    } else {
        $updateUser = $classUser->update_password_user_by_id($_POST);
    }
}
?>

<?php
if (isset($updateUser)) {
    if ($updateUser['status'] == 'success') {
        $alertIcon = '<img src="../images/successIcon.svg" alt="">';
    } else {
        $alertIcon = '<img src="../images/warning.svg" alt="">';
    }
    echo '
    <div class="onclose-alert" id="onCloseAlert" onclick="handleCloseAlert(`' . $updateUser['status'] . '`)">
    </div>
    <div class="info-alert alert alert-danger" id="alert" role="alert">
    <div class="d-flex flex-row justify-content-center align-items-center">
    ' . $alertIcon . '
    <p>' . $updateUser['msg'] . '</p>
    </div>
        <div class="d-flex justify-content-center mt-3">
    <button type="button" class="btn btn-info" onclick="handleAlert(`' . $updateUser['status'] . '`)" style="width: 230px;">Xác nhận</button>
    </div>
    </div>';
}
?>

<main>
    <div class="space-header"></div>
    <div class="profile-container">
        <div class=" d-flex align-items-start justify-content-around">
            <div class="nav nav-profile flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                    aria-selected="false">Hồ sơ</button>
                <button class="nav-link" id="v-pills-order-tab" data-bs-toggle="pill" data-bs-target="#v-pills-order"
                    type="button" role="tab" aria-controls="v-pills-order" aria-selected="true"
                    onclick="handleDataOrder(1)">Lịch sử đặt
                    vé</button>
                <button class="nav-link" id="v-pills-password-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password"
                    aria-selected="false">Bảo mật</button>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                    aria-labelledby="v-pills-profile-tab" tabindex="0">
                    <div class="profile-header">
                        <img src="../images/imgUser.jpg" alt="">
                    </div>
                    <form action="./hoSo.php?typepost=info&typeSelect=profile" method="post">
                        <div class="profile-content">
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Tên hiển thị</label>
                                <input type="text" name="TenTaiKhoan"
                                    value="<?php echo $dataUserById['TenTaiKhoan'] ?? '' ?>" class="form-control"
                                    placeholder="Nhập tên...">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Email</label>
                                <input type="text" name="Email" value="<?php echo $dataUserById['Email'] ?? '' ?>"
                                    class="form-control" placeholder="Nhập email...">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Số điện thoại</label>
                                <input type="text" name="SDT" value="<?php echo $dataUserById['SDT'] ?? '' ?>"
                                    class="form-control" placeholder="Nhập số điện thoại...">
                            </div>
                        </div>
                        <div class="profile-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab"
                    tabindex="0">
                    <div class="profile-header">
                        <p class="title">Lịch sử đơn vé</p>
                    </div>
                    <div class="profile-content profile-content-ticket">
                        <div id="profileContent"></div>
                        <nav class="d-flex justify-content-center" aria-label="Page navigation example">
                            <ul class="pagination" id='pagination' >
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab"
                    tabindex="0">
                    <div class="profile-header">
                        <p class="title">Thay đổi mật khẩu</p>
                    </div>
                    <form action="./hoSo.php?typepost=pass&typeSelect=password" method="post">
                        <div class="profile-content">
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Mật khẩu cũ</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Nhập mật khẩu cũ...">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" name="newPassword"
                                     placeholder="Nhập mật khẩu mới...">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" name="confirmPassword"
                                 placeholder="Nhập lại mật khẩu mới...">
                            </div>
                        </div>
                        <div class="profile-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>


<script>
    var sumPage = '<?php echo $sumPage?>'
    var sumOrderOnPage = '<?php echo $sumOrderOnPage?>'
    var sumTapOnPage = '<?php echo $sumTapOnPage?>'
    var userId = '<?php echo $user_id?>'

    function handleCloseAlert(data) {
        let element = document.getElementById("onCloseAlert");
        let elementAlert = document.getElementById("alert");
        element.remove()
        elementAlert.remove()
        if (data === "success") {
            location.href = '../pages/hoSo.php';
        }
    }
    function handleAlert(data) {
        handleCloseAlert();
        if (data === "success") {
            location.href = '../pages/hoSo.php';
        }
    }

    function handleSelete(type) {
        document.getElementById('v-pills-profile-tab').classList.remove('active')
        document.getElementById('v-pills-profile').classList.remove('active')
        document.getElementById('v-pills-profile').classList.remove('show')

        document.getElementById('v-pills-password-tab').classList.remove('active')
        document.getElementById('v-pills-password').classList.remove('active')
        document.getElementById('v-pills-password').classList.remove('show')

        document.getElementById('v-pills-order-tab').classList.remove('active')
        document.getElementById('v-pills-order').classList.remove('active')
        document.getElementById('v-pills-order').classList.remove('show')


        document.getElementById(`v-pills-${type}-tab`).classList.add('active')
        document.getElementById(`v-pills-${type}`).classList.add('show')
        document.getElementById(`v-pills-${type}`).classList.add('active')

        if (type === 'order') {
            handleDataOrder(1)
        }
    }

    function handlePagination (numPage) {
        element =document.getElementById('pagination')
        dataElement ='';
        if (parseInt(numPage) === 1) {
            dataElement += `<li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>`
        }else{
            dataElement += `<li class="page-item" onclick="handleDataOrder('${parseInt(numPage) - 1}')" >
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>`
        }

        let count = 1;
        if (parseInt(numPage) > 1) {
            if (parseInt(sumPage) > 2 && parseInt(numPage) === parseInt(sumPage) ) {
                for (let i = parseInt(numPage) - 2; i <= parseInt(sumPage); i++) {
                    if (count === parseInt(sumTapOnPage)) {
                        dataElement += `<li class="page-item active" onclick="handleDataOrder('${parseInt(i)}')"><a class="page-link" href="#">${i}</a></li>`
                    }else {
                        dataElement += `<li class="page-item" onclick="handleDataOrder('${parseInt(i)}')"><a class="page-link" href="#">${i}</a></li>`
                    }
                    if (count === parseInt(sumTapOnPage)) {
                        break
                    }
                    count++;
                }
            }else {
                for (let i = parseInt(numPage) - 1; i <= parseInt(sumPage); i++) {
                    if (count === 2) {
                        dataElement += `<li class="page-item active" onclick="handleDataOrder('${parseInt(i)}')"><a class="page-link" href="#">${i}</a></li>`
                    }else {
                        dataElement += `<li class="page-item" onclick="handleDataOrder('${parseInt(i)}')"><a class="page-link" href="#">${i}</a></li>`
                    }

                    if (count === parseInt(sumTapOnPage)) {
                        break
                    }
                    count++;
                }
            }
        }else {
            for (let i = 1; i <= parseInt(sumPage); i++) {
                if (count === 1) {
                    dataElement += `<li class="page-item active" onclick="handleDataOrder('${parseInt(i)}')"><a class="page-link" href="#">${i}</a></li>`
                }else {
                    dataElement += `<li class="page-item" onclick="handleDataOrder('${parseInt(i)}')"><a class="page-link" href="#">${i}</a></li>`
                }
                if (count === parseInt(sumTapOnPage)) {
                    break
                }
                count++;
            }
        }
        
        
        if (parseInt(numPage) === parseInt(sumPage)) {
            dataElement+= `<li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>`
        }else {
            dataElement+= `<li class="page-item" onclick="handleDataOrder('${parseInt(numPage) + 1}')" >
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>`
        }

        element.innerHTML =dataElement;
    }

    function handleDataOrder(numPage) {
        let element = document.getElementById('profileContent')

        var xhr = new XMLHttpRequest();

        xhr.open("POST", "../process/historyTicketOrder.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                element.innerHTML = xhr.responseText;
            }
        };

        var data = "numPage=" + numPage + "&" + "user_id=" + userId + '&' + "sumOrderOnPage=" + sumOrderOnPage;

        xhr.send(data);

        handlePagination(numPage)
    }

    <?php
    if (isset($_GET['typeSelect'])) {
        echo 'handleSelete("' . $_GET['typeSelect'] . '")';
    }
    ?>
</script>

<?php
include("../includes/footer/footer.php");
?>