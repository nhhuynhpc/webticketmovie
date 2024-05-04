<?php
// Session::checkSession();
require_once("../lib/database.php");
require_once("../helpers/format.php");
?>

<?php
class manageOrder
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function get_all_order() {
        $query = "SELECT donve.ID, donve.MaDon, donve.TenKhach, donve.Email, donve.SDT, 
        donve.SoLuong, donve.NgayDatVe, phim.TenPhim, taikhoan.TenTaiKhoan 
        FROM donve 
        INNER JOIN phim ON donve.Phim_ID = phim.ID 
        INNER JOIN taikhoan ON donve.TaiKhoan_ID = taikhoan.ID";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_order_by_id($id) {
        $query = "SELECT donve.ID, donve.MaDon, donve.TenKhach, donve.Email, donve.SDT, 
        donve.SoLuong, donve.NgayDatVe, phim.TenPhim, taikhoan.TenTaiKhoan 
        FROM donve 
        INNER JOIN phim ON donve.Phim_ID = phim.ID 
        INNER JOIN taikhoan ON donve.TaiKhoan_ID = taikhoan.ID
        WHERE donve.ID = '$id'";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_ticket_in_order_by_id($id) {
        $query = "SELECT ve.ID AS Ve_ID, 
        lichchieu.Ngay, lichchieu.GioBD, lichchieu.GiaVe,
        ghe.TenGhe, ghe.Cot,
        phong.TenPhong
        FROM ve
        INNER JOIN lichchieu ON ve.LichChieu_ID = lichchieu.ID
        INNER JOIN ghe ON ve.Ghe_ID = ghe.ID
        INNER JOIN phong ON lichchieu.Phong_ID = phong.ID
        WHERE ve.DonVe_ID = '$id'
        ";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }
}

?>