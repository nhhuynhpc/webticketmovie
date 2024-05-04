<?php
Session::checkSession();
require_once("../lib/database.php");
require_once("../helpers/format.php");
?>

<?php
class manageMovie
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_movie($data, $files)
    {
        $TenPhim = mysqli_real_escape_string($this->db->link, $data["TenPhim"]);
        $LoaiPhim_ID = mysqli_real_escape_string($this->db->link, $data["LoaiPhim_ID"]);
        $QuocGia = mysqli_real_escape_string($this->db->link, $data["QuocGia"]);
        $ThoiLuong = mysqli_real_escape_string($this->db->link, $data["ThoiLuong"]);
        $DienVien = mysqli_real_escape_string($this->db->link, $data["DienVien"]);
        $DaoDien = mysqli_real_escape_string($this->db->link, $data["DaoDien"]);
        $MoTa = mysqli_real_escape_string($this->db->link, $data["MoTa"]);
        $DatTruoc = mysqli_real_escape_string($this->db->link, $data["DatTruoc"]);
        $TrangThai = mysqli_real_escape_string($this->db->link, $data["TrangThai"]);
        // Kiểm tra hình ảnh và lấy hình ảnh cho vào forder uploads
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "../uploads/" . $unique_image;

        if (
            empty($TenPhim) ||
            $LoaiPhim_ID == '' ||
            $QuocGia == '' ||
            $ThoiLuong == '' ||
            $DienVien == '' ||
            $DaoDien == '' ||
            $MoTa == '' ||
            $DatTruoc == '' ||
            $TrangThai == '' ||
            $file_name == ''
        ) {
            $alert = "Không được để trống";
            return array("msg" => $alert, "status" => "error");
        } elseif (!is_numeric($ThoiLuong)) {
            $alert = "Thời lượng của phim phải là số";
            return array("msg" => $alert, "status" => "error");
        } else {
            if ($file_size > 2 * 1024 * 1024) {
                $alert = "file phải nhỏ hơn 2MB";
                return array("msg" => $alert, "status" => "error");
            } elseif (in_array($file_ext, $permited) === false) {
                $alert = 'Bạn chỉ có thể upload những file: ' . implode(', ', $permited);
                return array('msg' => $alert, 'status' => 'error');
            }
            move_uploaded_file($file_temp, $uploaded_image);
            $queryInsert = "INSERT INTO phim (TenPhim, LoaiPhim_ID, QuocGia, ThoiLuong, DienVien, DaoDien, MoTa, Anh, TrangThai, DatTruoc )
                 VALUES ('$TenPhim', '$LoaiPhim_ID', '$QuocGia', '$ThoiLuong', '$DienVien', '$DaoDien', '$MoTa', '$unique_image', '$TrangThai', '$DatTruoc')";
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

    public function update_movie($data, $files, $id)
    {
        $TenPhim = mysqli_real_escape_string($this->db->link, $data["TenPhim"]);
        $LoaiPhim_ID = mysqli_real_escape_string($this->db->link, $data["LoaiPhim_ID"]);
        $QuocGia = mysqli_real_escape_string($this->db->link, $data["QuocGia"]);
        $ThoiLuong = mysqli_real_escape_string($this->db->link, $data["ThoiLuong"]);
        $DienVien = mysqli_real_escape_string($this->db->link, $data["DienVien"]);
        $DaoDien = mysqli_real_escape_string($this->db->link, $data["DaoDien"]);
        $MoTa = mysqli_real_escape_string($this->db->link, $data["MoTa"]);
        $DatTruoc = mysqli_real_escape_string($this->db->link, $data["DatTruoc"]);
        $TrangThai = mysqli_real_escape_string($this->db->link, $data["TrangThai"]);
        // Kiểm tra hình ảnh và lấy hình ảnh cho vào forder uploads
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "../uploads/" . $unique_image;

        if (
            empty($TenPhim) ||
            $LoaiPhim_ID == '' ||
            $QuocGia == '' ||
            $ThoiLuong == '' ||
            $DienVien == '' ||
            $DaoDien == '' ||
            $MoTa == '' ||
            $TrangThai == '' ||
            $DatTruoc == ''
        ) {
            $alert = "Không được để trống";
            return array("msg" => $alert, "status" => "error");
        } elseif (!is_numeric($ThoiLuong)) {
            $alert = "Thời lượng của phim phải là số";
            return array("msg" => $alert, "status" => "error");
        } else {
            if ($file_name != "") {
                if ($file_size > 2 * 1024 * 1024) {
                    $alert = "file phải nhỏ hơn 2MB";
                    return array("msg" => $alert, "status" => "error");
                } elseif (in_array($file_ext, $permited) === false) {
                    $alert = 'Bạn chỉ có thể upload những file: ' . implode(', ', $permited);
                    return array('msg' => $alert, 'status' => 'error');
                }
                move_uploaded_file($file_temp, $uploaded_image);
                $queryUpdate = "UPDATE phim 
                    SET TenPhim = '$TenPhim', LoaiPhim_ID = '$LoaiPhim_ID', QuocGia = '$QuocGia',
                    ThoiLuong = '$ThoiLuong', DienVien = '$DienVien', DaoDien = '$DaoDien',
                     MoTa = '$MoTa', Anh = '$unique_image', DatTruoc='$DatTruoc', TrangThai='$TrangThai' WHERE ID = '$id'";
            } else {
                $queryUpdate = "UPDATE phim 
                    SET TenPhim = '$TenPhim', LoaiPhim_ID = '$LoaiPhim_ID', QuocGia = '$QuocGia',
                    ThoiLuong = '$ThoiLuong', DienVien = '$DienVien', DaoDien = '$DaoDien',
                     MoTa = '$MoTa', DatTruoc='$DatTruoc', TrangThai='$TrangThai' WHERE ID = '$id'";
            }

            $resultInsert = $this->db->update($queryUpdate);
            if ($resultInsert) {
                $alert = "Sửa giữ liệu thành công.";
                return array('msg' => $alert, 'status' => 'success');
            } else {
                $alert = "Sửa giữ liệu không thành công";
                return array("msg" => $alert, "status" => "error");
            }
        }
    }

    public function delete_movie($id)
    {
        $query = "DELETE fROM phim WHERE ID = '$id'";
        $result = $this->db->delete($query);

        if ($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function select_all_movie()
    {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
            phim.Anh, phim.ThoiLuong, phim.QuocGia, phim.TrangThai, phim.DatTruoc, loaiphim.TenLoai 
            FROM phim 
            INNER JOIN loaiphim 
            ON phim.LoaiPhim_ID = loaiphim.ID
            ORDER BY phim.ID ASC";
        $result = $this->db->select($query);

        if ($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_movie_by_id($id)
    {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
        phim.Anh, phim.ThoiLuong, phim.QuocGia, phim.TrangThai, phim.DatTruoc, phim.MoTa, loaiphim.TenLoai 
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID WHERE phim.ID = '$id' LIMIT 1";
        $result = $this->db->select($query);

        if ($result !== false) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
}

?>