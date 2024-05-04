<?php
Session::checkLogin();
include("../lib/database.php");
include("../helpers/format.php");
?>

<?php
class login
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function handle_login($Email, $MatKhau, $movieID)
    {
        $Email = $this->fm->validation($Email);
        $MatKhau = $this->fm->validation($MatKhau);

        $Email = mysqli_real_escape_string($this->db->link, $Email);
        $MatKhau = mysqli_real_escape_string($this->db->link, $MatKhau);

        if (empty($Email) || empty($MatKhau)) {
            $alert = "Không được để trống";
            return $alert;
        } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $alert = "Email Không đúng định dạng";
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
            $MatKhau = md5($MatKhau);

            $query = "SELECT * FROM taikhoan WHERE Email = '$Email' AND MatKhau = '$MatKhau' LIMIT 1";
            $result = $this->db->select($query);

            if ($result != false) {
                $value = $result->fetch_assoc();
                Session::set("login", true);
                Session::set('ID', $value['ID']);
                Session::set('TenTaiKhoan', $value['TenTaiKhoan']);
                Session::set('Email', $value['Email']);
                Session::set('MatKhau', $value['MatKhau']);
                Session::set('PhanQuyen', $value['Quyen']);
                Session::get('login');
                if ($value['Quyen'] == 'user') {
                    if ($value['TrangThai'] == '0') {
                        if ($movieID != '') {
                            echo "<script>location.href = '../pages/chiTietSanPham.php?sanPhamId=" . $movieID . "';</script>";
                        } else {
                            echo "<script>location.href = '../pages/index.php';</script>";
                        }
                    } else {
                        $alert = "Tài khoản của bạn đã bị khóa";
                        return $alert;
                    }
                } else {
                    echo "<script>location.href = '../pages/quanLyPhim.php';</script>";
                }
            } else {
                $alert = 'Tài khoản hoặc mật khẩu không chính xác';
                return $alert;
            }
        }
    }
}

?>