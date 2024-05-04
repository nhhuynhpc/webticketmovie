<?php
// Session::checkLogin();
require_once("../lib/database.php");
require_once("../helpers/format.php");
?>

<?php
class Order
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function insert_order($data, $Phim_ID, $lichChieuId, $chairId, $numTicket)
    {
        $TenKhach = mysqli_real_escape_string($this->db->link, $data["TenKhach"]);
        $Email = mysqli_real_escape_string($this->db->link, $data["Email"]);
        $SDT = mysqli_real_escape_string($this->db->link, $data["SDT"]);
        $Phim_ID = mysqli_real_escape_string($this->db->link, $Phim_ID);
        $numTicket = mysqli_real_escape_string($this->db->link, $numTicket);
        $MaDon = strtoupper(substr(md5(time()), 0, 6));
        $TaiKhoan_ID = Session::get("ID");

        if ($TenKhach == "" || $Email == "" || $SDT == "" || $Phim_ID == "") {
            $alert = "Vui lòng nhập đầy đủ thông tin";
            return array("msg" => $alert, "status" => "error");
        } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $alert = "Email Không đúng định dạng";
            return array("msg" => $alert, "status" => "error");
        } else if (!preg_match('/^[0-9]{10}+$/', $SDT)) {
            $alert = "Số điện thoại Không đúng định dạng";
            return array("msg" => $alert, "status" => "error");
        }

        $lichChieuId = mysqli_real_escape_string($this->db->link, $lichChieuId);

        $queryInsertOrder = "INSERT INTO donve (TenKhach, Email, SDT, Phim_ID, TaiKhoan_ID, SoLuong, MaDon)
            VALUES ('$TenKhach', '$Email', '$SDT', '$Phim_ID', $TaiKhoan_ID, '$numTicket', '$MaDon')";
        $querySelectOrder = "SELECT ID FROM donve ORDER BY ID DESC;";
        $resultInsertOrder = $this->db->insert($queryInsertOrder);
        $resultselectOrder = $this->db->select($querySelectOrder);

        if ($resultselectOrder != false) {
            $data = $resultselectOrder->fetch_assoc();
            $DonVe_ID = $data["ID"];
        } else {
            $alert = "Thêm giữ liệu không thành công";
            return array("msg" => $alert, "status" => "error");
        }

        if ($resultInsertOrder == false) {
            $alert = "Thêm giữ liệu không thành công";
            return array("msg" => $alert, "status" => "error");
        }

        foreach ($chairId as $value) {
            $id = mysqli_real_escape_string($this->db->link, $value);
            $queryInsert = "INSERT INTO ve (LichChieu_ID, Ghe_ID, DonVe_ID)
            VALUES ('$lichChieuId', '$id', '$DonVe_ID')";
            $resultInsert = $this->db->insert($queryInsert);

            if (!$resultInsert) {
                $alert = "Thêm giữ liệu không thành công";
                return array("msg" => $alert, "status" => "error");
            }
        }

        $alert = "Mua vé thành công";
        return array("msg" => $alert, "status" => "success");
    }

    public function get_order_by_user_id($user_id) {
        $querySelectOrder = "SELECT donve.ID, donve.MaDon, donve.TenKhach, donve.Email, donve.SDT, 
        donve.SoLuong, donve.NgayDatVe, 
        phim.TenPhim, phim.Anh,
        lichchieu.Ngay, lichchieu.GioBD
        FROM donve 
        INNER JOIN phim ON donve.Phim_ID = phim.ID
        INNER JOIN ve ON ve.DonVe_ID = donve.ID
        INNER JOIN lichchieu ON ve.LichChieu_ID = lichchieu.ID
        WHERE donve.TaiKhoan_ID = '$user_id'
        GROUP BY donve.ID";

        $resultSelectOrder = $this->db->select($querySelectOrder);

        if ($resultSelectOrder != false) {
            return $resultSelectOrder;
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