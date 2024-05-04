<?php 
    // Session::checkLogin();
    require_once("../lib/database.php");
    require_once("../helpers/format.php");
?>

<?php 
class Chair
{

    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function get_num_row_on_chair() {
        $query = "SELECT * FROM ghe ORDER BY Hang DESC LIMIT 1";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }
     
    public function get_chair_by_num_row($numRow) {
        $query = "SELECT * FROM ghe WHERE Hang = '$numRow'";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_chair_by_id ($id) {
        $query = "SELECT * FROM ghe WHERE ID = '$id'";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_chair_is_selected($licChieuID) {
        $query = "SELECT ghe.ID AS Ghe_ID, ghe.TenGhe, ghe.Cot, ghe.Hang, 
        lichchieu.ID, lichchieu.Phim_ID 
        FROM lichchieu 
        INNER JOIN ve 
        ON lichchieu.ID = ve.LichChieu_ID 
        INNER JOIN ghe 
        ON ve.Ghe_ID = ghe.ID 
        WHERE lichchieu.ID = '$licChieuID'";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }
}

?>