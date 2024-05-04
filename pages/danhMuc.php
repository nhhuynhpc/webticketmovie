<?php
include("../includes/header/header.php");
?>



<main>
    <div class="space-header"></div>
    <div class="categories-container container mb-5 d-flex justify-content-between">
        <div class="categories-menu">
            <p class="categories-menu-title">DANH MỤC</p>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item" id="main" onclick="handleDataOrderDetail(`main`)">
                    <a class="nav-link w-100 h-100" href="#">DANH MỤC CHÍNH</a>
                </li>
                <li class="nav-item" id="showing" onclick="handleDataOrderDetail(`showing`)">
                    <a class="nav-link w-100 h-100" href="#">PHIM ĐANG CHIẾU</a>
                </li>
                <li class="nav-item" id="upcoming" onclick="handleDataOrderDetail(`upcoming`)">
                    <a class="nav-link w-100 h-100" href="#">PHIM SẮP CHIẾU</a>
                </li>
                <li class="nav-item" id="pre_sale" onclick="handleDataOrderDetail(`pre_sale`)">
                    <a class="nav-link w-100 h-100" href="#">VÉ BÁN TRƯỚC</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">COMBO ĐỒ UỐNG VÀ ĂN</a>
                </li> -->
            </ul>
        </div>
        <div class="categories-content">
            <p class="categories-content-title" id="titleResult">
                Kết quả
            </p>
            <div class="categories-content-main" id="contentMovie">
            </div>
        </div>
    </div>
</main>


<script>

    function handleDataOrderDetail(type) {
        let element = document.getElementById('contentMovie')
        let titleResult = document.getElementById('titleResult')
        let elementCateItem =document.getElementById(`${type}`)
        let listElementCateItem = ['main', 'upcoming', 'showing', 'pre_sale']

        for (let item of listElementCateItem) {
            document.getElementById(`${item}`).classList.remove('cate-active')
        }
        
        elementCateItem.classList.add('cate-active')
        if (type === "main") {
            titleResult.innerHTML = 'DANH MỤC CHÍNH'
        } else if (type === "upcoming") {
            titleResult.innerHTML = 'PHIM SẮP CHIẾU'
        } else if (type === "showing") {
            titleResult.innerHTML = 'PHIM ĐANG CHIẾU'
        } else {
            titleResult.innerHTML = 'VÉ BÁN TRƯỚC'
        }
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "../process/categories.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                element.innerHTML = xhr.responseText;
            }
        };

        var data = "typeMoie=" + type;

        xhr.send(data);
    }
    <?php
    if (isset($_GET['movieType'])) {
        echo 'handleDataOrderDetail("' . $_GET['movieType'] . '")';
    } else {
        echo 'handleDataOrderDetail("main")';
    }
    ?>
</script>

<?php
include("../includes/footer/footer.php");
?>