<?php
Session::checkSession();
require_once("../lib/database.php");
require_once("../helpers/format.php");
?>

<?php
class manageShowtime
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_showtime($data)
    {
        $Ngay = $this->fm->date_format($data["Ngay"]);
        $GioBD = $this->fm->hour_format($data["GioBD"]);

        $Phim_ID = mysqli_real_escape_string($this->db->link, $data["Phim_ID"]);
        $Phong_ID = mysqli_real_escape_string($this->db->link, $data["Phong_ID"]);
        $Ngay = mysqli_real_escape_string($this->db->link, $data["Ngay"]);
        $GioBD = mysqli_real_escape_string($this->db->link, $data["GioBD"]);
        $GiaVe = mysqli_real_escape_string($this->db->link, $data["GiaVe"]);

        if (
            $Phim_ID == '' ||
            $Phong_ID == '' ||
            $Ngay == '' ||
            $GioBD == ''
        ) {
            $alert = "Không được để trống";
            return array("msg" => $alert, "status" => "error");
        } elseif (!is_numeric($GiaVe)) {
            $alert = "Giá vé phải là số";
            return array("msg" => $alert, "status" => "error");
        } else {
            $queryMovieById = "SELECT ThoiLuong FROM phim WHERE ID = '$Phim_ID'";
            $resultMovieById = $this->db->select($queryMovieById);
            if ($resultMovieById != false) {
                $dataMovieById = $resultMovieById->fetch_assoc();
                $mocGio = new DateTime($GioBD);
                // Thực hiện cộng thêm phút
                $gioKT = clone $mocGio;
                $gioBD = clone $mocGio;
                $gioBD->sub(new DateInterval('PT' . (int)$dataMovieById['ThoiLuong'] . 'M'));
                $gioKT->add(new DateInterval('PT' . (int)$dataMovieById['ThoiLuong'] . 'M'));

                // Lấy thời gian sau khi cộng
                $gioBDFormatted = $gioBD->format('H:i:s');
                $gioKTFormatted = $gioKT->format('H:i:s');
            }
            // cùng phim cùng ngày cùng phòng cùng giờ
            $querySelectHanveCalende = "SELECT * FROM lichchieu WHERE Phim_ID = '$Phim_ID' AND Phong_ID = '$Phong_ID' AND Ngay = '$Ngay' AND GioBD >= '$gioBDFormatted' AND GioBD <= '$gioKTFormatted'";
            $resultSelectHaveCalende = $this->db->select($querySelectHanveCalende);
            if ($resultSelectHaveCalende != false) {
                if ($resultSelectHaveCalende->num_rows > 0) {
                    $alert = "Lịch đã được tạo trước đó";
                    return array("msg" => $alert, "status" => "error");
                }
            }
            // khác phim cùng phòng cùng ngày cùng giờ
            $querySelectHaveRom = "SELECT * FROM lichchieu WHERE Phim_ID != '$Phim_ID' AND Phong_ID = '$Phong_ID' AND Ngay = '$Ngay' AND GioBD >= '$gioBDFormatted' AND GioBD <= '$gioKTFormatted'";
            $resultSelectHaveRom = $this->db->select($querySelectHaveRom);
            if ($resultSelectHaveRom != false) {
                if ($resultSelectHaveRom->num_rows > 0) {
                    $alert = "Phòng đã có phim đặt trong khung giờ";
                    return array("msg" => $alert, "status" => "error");
                }
            }

            $queryInsert = "INSERT INTO lichchieu (Phim_ID, Phong_ID, Ngay, GioBD, GiaVe)
                 VALUES ('$Phim_ID', '$Phong_ID', '$Ngay', '$GioBD', '$GiaVe')";
            $resultInsert = $this->db->insert($queryInsert);
            if ($resultInsert) {
                $alert = "Thêm giữ liệu thành công.";
                return array('msg' => $alert, 'status' => 'success');
            } else {
                $alert = "Thêm giữ liệu không thành công";
                return array("msg" => $alert, "status" => "error");
            }
        }
    }
    // ------
    public function update_showtime($data, $id)
    {
        $Ngay = $this->fm->date_format($data["Ngay"]);
        $GioBD = $this->fm->hour_format($data["GioBD"]);

        $Phim_ID = mysqli_real_escape_string($this->db->link, $data["Phim_ID"]);
        $Phong_ID = mysqli_real_escape_string($this->db->link, $data["Phong_ID"]);
        $Ngay = mysqli_real_escape_string($this->db->link, $data["Ngay"]);
        $GioBD = mysqli_real_escape_string($this->db->link, $data["GioBD"]);
        $GiaVe = mysqli_real_escape_string($this->db->link, $data["GiaVe"]);

        if (
            $Phim_ID == '' ||
            $Phong_ID == '' ||
            $Ngay == '' ||
            $GioBD == '' ||
            $GiaVe == ''
        ) {
            $alert = "Không được để trống";
            return array("msg" => $alert, "status" => "error");
        } else {
            $queryUpdate = "UPDATE lichchieu 
            SET Phim_ID = '$Phim_ID', Phong_ID = '$Phong_ID', Ngay = '$Ngay',
            GioBD = '$GioBD', GiaVe = '$GiaVe' WHERE ID = '$id'";

            $resultUpdate = $this->db->update($queryUpdate);
            if ($resultUpdate) {
                $alert = "Sửa giữ liệu thành công.";
                return array('msg' => $alert, 'status' => 'success');
            } else {
                $alert = "Sửa giữ liệu không thành công";
                return array("msg" => $alert, "status" => "error");
            }
        }
    }

    public function delete_showtime($id)
    {
        $query = "DELETE fROM lichchieu WHERE ID = '$id'";
        $result = $this->db->delete($query);

        if ($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function select_all_showtime()
    {
        $query = "SELECT lichchieu.ID, lichchieu.Ngay, lichchieu.GioBD, phim.TenPhim, phong.TenPhong 
        FROM lichchieu 
        INNER JOIN phim ON lichchieu.Phim_ID = phim.ID 
        INNER JOIN phong ON lichchieu.Phong_ID = phong.ID";
        $result = $this->db->select($query);

        if ($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_showtime_by_id($id)
    {
        $query = "SELECT * FROM lichchieu WHERE ID = '$id' LIMIT 1";
        $result = $this->db->select($query);

        if ($result !== false) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function select_all_showtimeDataByProductId($idMovie)
    {
        $query = "SELECT lichchieu.ID, lichchieu.Phim_ID, lichchieu.Phong_ID, lichchieu.Ngay, lichchieu.GioBD, lichchieu.GiaVe, phim.TenPhim, phong.TenPhong 
        FROM lichchieu 
        INNER JOIN phim ON lichchieu.Phim_ID = phim.ID 
        INNER JOIN phong ON lichchieu.Phong_ID = phong.ID WHERE lichchieu.Phim_ID = '$idMovie'";
        $result = $this->db->select($query);

        if ($result !== false) {
            return $result;
        } else {
            return false;
        }
    }
}

?>