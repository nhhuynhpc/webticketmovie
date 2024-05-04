<?php
// Session::checkSession();
require_once("../lib/database.php");
require_once("../helpers/format.php");
?>

<?php
class Movie
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function getResultSearchMovie($textSearch) {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
        phim.Anh, phim.ThoiLuong, phim.QuocGia, 
        phim.TrangThai, phim.DatTruoc, phim.MoTa, loaiphim.TenLoai,
        lichchieu.ID as LichChieu_ID, lichchieu.Ngay, lichchieu.GiaVe
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        WHERE LOWER(phim.TenPhim) LIKE '%$textSearch%'
        GROUP BY phim.TenPhim
        ORDER BY phim.ID DESC";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function getMovie() {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
        phim.Anh, phim.ThoiLuong, phim.QuocGia, 
        phim.TrangThai, phim.DatTruoc, phim.MoTa, loaiphim.TenLoai,
        lichchieu.ID as LichChieu_ID, lichchieu.Ngay, lichchieu.GiaVe
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        GROUP BY phim.TenPhim
        ORDER BY phim.ID DESC";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    // Trạng thái phim: 
    // 0-> sắp chiếu
    // 1-> đang chiếu
    // 2-> đã chiếu
    // ----
    // Trạng thái đặt trước
    // 0-> cho phép
    // 1-> không cho phép
    
    public function upcoming_movie() {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
        phim.Anh, phim.ThoiLuong, phim.QuocGia, 
        phim.TrangThai, phim.DatTruoc, phim.MoTa, loaiphim.TenLoai,
        lichchieu.ID as LichChieu_ID, lichchieu.Ngay, lichchieu.GiaVe
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        WHERE TrangThai = '0' 
        GROUP BY phim.TenPhim
        ORDER BY phim.ID DESC";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function movie_is_showing() {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
        phim.Anh, phim.ThoiLuong, phim.QuocGia, 
        phim.TrangThai, phim.DatTruoc, phim.MoTa, loaiphim.TenLoai,
        lichchieu.ID as LichChieu_ID, lichchieu.Ngay, lichchieu.GiaVe
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        WHERE TrangThai = '1' 
        GROUP BY phim.TenPhim
        ORDER BY phim.ID DESC";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function pre_sale_tickets() {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
        phim.Anh, phim.ThoiLuong, phim.QuocGia, 
        phim.TrangThai, phim.DatTruoc, phim.MoTa, loaiphim.TenLoai,
        lichchieu.ID as LichChieu_ID, lichchieu.Ngay, lichchieu.GiaVe
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        WHERE TrangThai = '0' and DatTruoc = '0' 
        GROUP BY phim.TenPhim
        ORDER BY phim.ID DESC";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_movie_by_id($id) {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
        phim.Anh, phim.ThoiLuong, phim.QuocGia, 
        phim.TrangThai, phim.DatTruoc, phim.MoTa, loaiphim.TenLoai,
        lichchieu.ID as LichChieu_ID, lichchieu.Ngay, lichchieu.GiaVe
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        WHERE phim.ID = '$id' LIMIT 1";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_all_movie_by_id_and_day($id) {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
        phim.Anh, phim.ThoiLuong, phim.QuocGia, 
        phim.TrangThai, phim.DatTruoc, phim.MoTa, loaiphim.TenLoai,
        lichchieu.ID as LichChieu_ID, lichchieu.Ngay, lichchieu.GiaVe
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        WHERE phim.ID = '$id'
        GROUP BY lichchieu.Ngay
        ";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_one_movie_by_id_and_day ($id, $idLichChieu) {
        $query = "SELECT phim.ID, phim.TenPhim, phim.DienVien, phim.DaoDien,
        phim.Anh, phim.ThoiLuong, phim.QuocGia, 
        phim.TrangThai, phim.DatTruoc, phim.MoTa, loaiphim.TenLoai,
        lichchieu.ID as LichChieu_ID, lichchieu.Ngay, lichchieu.GiaVe, lichchieu.GioBD
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        WHERE phim.ID = '$id' AND lichchieu.ID = '$idLichChieu'
        ";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_all_movie_by_id_and_time ($id, $dataDate) {
        $query = "SELECT phim.ID, phim.TenPhim,
        lichchieu.ID as LichChieu_ID, lichchieu.Ngay, lichchieu.GioBD, lichchieu.GiaVe
        FROM phim 
        INNER JOIN loaiphim 
        ON phim.LoaiPhim_ID = loaiphim.ID
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        WHERE phim.ID = '$id' AND lichchieu.Ngay = '$dataDate'
        ";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_movie_by_showtime_id ($showtimeId) {
        $query = "SELECT phim.TenPhim, phim.Anh,
        lichchieu.ID as LichChieu_ID, lichchieu.Phim_ID, lichchieu.Phong_ID, lichchieu.Ngay, lichchieu.GiaVe, lichchieu.GioBD
        FROM phim 
        INNER JOIN lichchieu
        ON phim.ID = lichchieu.Phim_ID
        WHERE lichchieu.ID = '$showtimeId'
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