<?php
Session::checkLogin();
include("../lib/database.php");
include("../helpers/format.php");
?>

<?php
class register
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function handle_register($TenTaiKhoan, $Email, $MatKhau, $CheckMatKhau, $movieID)
    {
        $Email = $this->fm->validation($Email);
        $MatKhau = $this->fm->validation($MatKhau);
        $CheckMatKhau = $this->fm->validation($CheckMatKhau);

        $Email = mysqli_real_escape_string($this->db->link, $Email);
        $MatKhau = mysqli_real_escape_string($this->db->link, $MatKhau);
        $CheckMatKhau = mysqli_real_escape_string($this->db->link, $CheckMatKhau);

        if (empty($TenTaiKhoan) || empty($Email) || empty($MatKhau) || empty($CheckMatKhau)) {
            $alert = "Không được để trống";
            return $alert;
        } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $alert = "Email Không đúng định dạng";
            return $alert;
        } else if ($MatKhau !== $CheckMatKhau) {
            $alert = "Mật khẩu nhập lại không chín xác";
            return $alert;
        } else if (strlen($MatKhau) < '8') {
            $alert = "Mật khẩu phải có ít nhất 8 ký tự!";
            return $alert;
        } elseif (!preg_match("#[0-9]+#", $MatKhau)) {
            $alert = "Mật khẩu phải có ít nhất 1 số!";
            return $alert;
        } elseif (!preg_match("#[A-Z]+#", $MatKhau)) {
            $alert = "Mật khẩu phải chứa ít nhất 1 chữ in hoa!";
            return $alert;
        } elseif (!preg_match("#[a-z]+#", $MatKhau)) {
            $alert = "Mật khẩu phải chứa ít nhất 1 chữ thường!";
            return $alert;
        } else {
            $querySelect = "SELECT * FROM taikhoan WHERE Email = '$Email' LIMIT 1";
            $resultSelect = $this->db->select($querySelect);

            $MatKhau = md5($MatKhau);

            if ($resultSelect == false) {
                $queryInsert = "INSERT INTO taikhoan (TenTaiKhoan, Email, MatKhau, Quyen, TrangThai) VALUES ('$TenTaiKhoan', '$Email', '$MatKhau', 'user', '0')";
                $resultInsert = $this->db->insert($queryInsert);
                if ($resultInsert != false) {
                    $resultSelect = $this->db->select($querySelect);
                    $value = $resultSelect->fetch_assoc();
                    Session::set("login", true);
                    Session::set('ID', $value['ID']);
                    Session::set('TenTaiKhoan', $value['TenTaiKhoan']);
                    Session::set('Email', $value['Email']);
                    Session::set('MatKhau', $value['MatKhau']);
                    Session::set('PhanQuyen', $value['Quyen']);
                    Session::get('login');
                    if ($movieID != '') {
                        echo "<script>location.href = '../pages/chiTietSanPham.php?sanPhamId=" . $movieID . "';</script>";
                    } else {
                        echo "<script>location.href = '../pages/index.php';</script>";
                    }
                }
            } else {
                $alert = 'Tài khoản đã tồn tại!!!';
                return $alert;
            }
        }
    }
}
?>