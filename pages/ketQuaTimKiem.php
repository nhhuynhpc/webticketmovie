<?php
include("../includes/header/header.php");
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchText = $_POST["searchText"];
}
?>

<main>
    <div class="space-header"></div>
    <div class="categories-container container mb-5 d-flex justify-content-between">
        <div class="categories-content m-auto">
            <p class="categories-content-title" id="titleResult">
                
            </p>
            <div class="categories-content-main" id="contentMovie">
            </div>
        </div>
    </div>
</main>

<script>
    function handleDataSearch(searchText) {
        let element = document.getElementById('contentMovie')
        let titleResult = document.getElementById('titleResult')

        titleResult.innerHTML = `Kết quả tìm kiếm cho từ khóa "<b>${searchText}</b>":`

        var xhr = new XMLHttpRequest();

        xhr.open("POST", "../process/search.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText == '\r\n \r\n\r\n') {
                    titleResult.innerHTML = `Không có Kết quả tìm kiếm cho từ khóa "<b>${searchText}</b>":`
                    element.style.margin = '120px auto' 
                }else {
                    element.innerHTML = xhr.responseText;
                }
            }
        };

        var data = "searchText=" + searchText;

        xhr.send(data);
    }
    <?php
    if (isset($searchText)) {
        echo 'handleDataSearch("' . $searchText . '")';
    } else {
        echo "location.href = '../pages/index.php';";
    }
    ?>
</script>

<?php
include("../includes/footer/footer.php");
?>