<?php
Session::checkSession();
require_once("../lib/database.php");
require_once("../helpers/format.php");
?>

<?php
class manageUser
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function update_user($data, $id)
    {
        $TrangThai = mysqli_real_escape_string($this->db->link, $data["TrangThai"]);

        $queryUpdate = "UPDATE taikhoan 
             SET TrangThai = '$TrangThai' WHERE ID = '$id'";

        $resultUpdate = $this->db->update($queryUpdate);
        if ($resultUpdate) {
            $alert = "Thay đổi trạng thái thành công.";
            echo "<script>location.href = '../pages/quanLyUser.php'</script>";
            return array('msg' => $alert, 'status' => 'success');
        } else {
            $alert = "Thay đổi trạng thái không thành công";
            return array("msg" => $alert, "status" => "error");
        }
    }

    public function select_all_user()
    {
        $query = "SELECT * FROM taikhoan";
        $result = $this->db->select($query);

        if ($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_user_by_id($id)
    {
        $query = "SELECT * FROM taikhoan WHERE ID = '$id' LIMIT 1";
        $result = $this->db->select($query);

        if ($result !== false) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
}

?>