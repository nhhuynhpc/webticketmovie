<?php
include("../includes/header/adminHeader.php");
?>

<?php
require_once("../classes/manageUser.php");
?>

<?php
$classUser = new manageUser();
$UserData = $classUser->select_all_user();
if (!isset($_GET['page'])) {
    $numPage = '1';
} else {
    $numPage = $_GET['page'];
}
$SumUserOnPage = 8;
if (isset($_GET['userid']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id = $_GET["userid"];
    $updateUser = $classUser->update_user($_POST, $id);
}
?>

<div class="movie-management">
    <div class="header">
        <img src="../images/managementIcon.png" alt="">
        <span>Quản lý User</span>
    </div>

    <div class="content">
        <table class="table table-striped table-info table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên tài khoản</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Quyền</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($UserData != false) {
                    $row = $UserData->fetch_all(MYSQLI_ASSOC);
                    for ($i = (((int) $numPage * $SumUserOnPage) - $SumUserOnPage); $i < count($row); $i++) {
                        ?>
                        <tr>
                            <?php
                            echo '<th scope="row">' . $row[$i]["ID"] . '</th>';
                            echo '<td>' . $row[$i]['TenTaiKhoan'] . '</td>';
                            echo '<td>' . $row[$i]['Email'] . '</td>';
                            echo '<td>' . $row[$i]['SDT'] . '</td>';
                            echo '<td>' . $row[$i]['Quyen'] . '</td>';
                            if ($row[$i]['TrangThai'] == '0') {
                                echo '<td class="status"><span class="icon-status icon-status-success" ></span> Hoạt động</td>';
                            } else {
                                echo '<td class="status"><span class="icon-status icon-status-error" ></span> Khóa</td>';
                            }
                            ?>
                            <td>
                                <div class="group-button d-flex justify-content-around">
                                    <a
                                        href="./quanLyUser.php?page=<?php echo $numPage; ?>&userid=<?php echo $row[$i]['ID']; ?>">
                                        <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal">
                                            <img src="../images/editIcon.svg" alt="">
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        if ($i - (((int) $numPage * $SumUserOnPage) - $SumUserOnPage) == $SumUserOnPage - 1) {
                            break;
                        }
                    }
                }
                ?>
            </tbody>
        </table>
        <nav class="d-flex justify-content-center" aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                $sumPage = ceil($UserData->num_rows / $SumUserOnPage);
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
                            echo '<li class="page-item"><a class="page-link" href="./quanLyUser.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                            if ($i + 1 > 2) {
                                break;
                            }
                        }
                    } else {
                        echo '
                    <li class="page-item">
                        <a class="page-link" href="./quanLyUser.php?page=' . ((int) $numPage - 1) . '" aria-label="Previous">
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
                        for ($i; $i < $sumPage; $i++) {
                            echo '<li class="page-item"><a class="page-link" href="./quanLyUser.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                            if ($i - ((int) $sumPage - 2) == 3) {
                                break;
                            }
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
                                <a class="page-link" href="./quanLyUser.php?page=' . ((int) $numPage + 1) . '" aria-label="Next">
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

<!-- edit -->
<?php
if (isset($_GET["userid"])) {
    $dataUserById = $classUser->get_user_by_id($_GET["userid"]);
    if ($dataUserById != false) {
        ?>
        <div class="onclose-modal" id="closeModal" onclick="handleCloseModal(`?page=<?php echo $numPage; ?>`)"></div>
        <div class="modal-user" id="modalUser">
            <button type="button" class="btn-close" onclick="handleCloseModal(`?page=<?php echo $numPage; ?>`)"></button>
            <form action="./quanLyUser.php?page=<?php echo $numPage; ?>&userid=<?php echo $dataUserById['ID']; ?>"
                method="post">
                <div class="modal-info">
                    <div class="info">
                        <p class="fs-4 fw-bolder text-center">Thông tin</p>
                        <hr>
                        <p class="title"><b>Tên tài khoản: </b><span id="Ten">
                                <?php echo $dataUserById['TenTaiKhoan']; ?>
                            </span></p>
                        <p class="title"><b>Email: </b><span>
                                <?php echo $dataUserById['Email']; ?>
                            </span></p>
                        <p class="title"><b>Số điện thoại: </b><span>
                                <?php echo $dataUserById['SDT']; ?>
                            </span></p>
                        <p class="title"><b>Quyền: </b><span>
                                <?php echo $dataUserById['Quyen']; ?>
                            </span></p>
                    </div>
                    <div class="update">
                        <p class="fs-4 fw-bolder text-center">Cập nhật</p>
                        <hr>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelectGrid" name="TrangThai" 
                            <?php 
                                if ($dataUserById['Quyen'] === 'admin') {
                                    echo 'disabled';
                                } 
                            ?> 
                            >
                                <?php
                                if ($dataUserById['TrangThai'] == '1') {
                                    ?>
                                    <option value="0">Hoạt động</option>
                                    <option value="1" selected>Khóa</option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="0" selected>Hoạt động</option>
                                    <option value="1">Khóa</option>
                                    <?php
                                }
                                ?>
                            </select>
                            <label for="floatingSelectGrid">Trạng thái</label>
                        </div>
                    </div>
                </div>
                <div class="modal-end">
                    <button type="button" class="btn btn-secondary mx-2"
                        onclick="handleCloseModal(`?page=<?php echo $numPage; ?>`)">Hủy</button>
                    <button type="submit" name="submit" class="btn btn-primary mx-2">Cập nhật</button>
                </div>
            </form>
        </div>
        <?php
    } else {
        echo 'err';
    }
}
?>

<script>
    function handleCloseModal(href) {
        let element = document.getElementById('closeModal');
        let elementModal = document.getElementById('modalUser');

        element.remove();
        elementModal.remove();
        location.href = '../pages/quanLyUser.php' + href;
    }
</script>

<?php
include("../includes/footer/adminFooter.php");
?>