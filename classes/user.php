<?php
// Session::checkLogin();
require_once("../lib/database.php");
require_once("../helpers/format.php");
?>

<?php
class User
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function get_user_by_id()
    {
        $id = Session::get("ID");
        $query = "SELECT * FROM taikhoan WHERE ID = '$id'";
        $result = $this->db->select($query);

        if ($result !== false) {
            return $result;
        } else {
            return false;
        }
    }

    public function update_user_by_id($data)
    {
        $user_id = Session::get("ID");
        $TenTaiKhoan = mysqli_real_escape_string($this->db->link, $data["TenTaiKhoan"]);
        $Email = mysqli_real_escape_string($this->db->link, $data["Email"]);
        $SDT = mysqli_real_escape_string($this->db->link, $data["SDT"]);

        if ($Email == '') {
            $alert = "Email Không được trống";
            return array('msg' => $alert, 'status' => 'error');
        } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $alert = "Email Không đúng định dạng";
            return array('msg' => $alert, 'status' => 'error');
        }

        $queryUpdate = "UPDATE taikhoan 
            SET TenTaiKhoan = '$TenTaiKhoan', Email = '$Email', SDT = '$SDT' WHERE ID = '$user_id'";

        $resultUpdate = $this->db->update($queryUpdate);
        if ($resultUpdate !== false) {
            $alert = "Cập nhật dữ liệu thành công";
            return array('msg' => $alert, 'status' => 'success');
        }
    }

    public function update_password_user_by_id($data)
    {
        $user_id = Session::get("ID");
        $password = mysqli_real_escape_string($this->db->link, $data["password"]);
        $newPassword = mysqli_real_escape_string($this->db->link, $data["newPassword"]);
        $confirmPassword = mysqli_real_escape_string($this->db->link, $data["confirmPassword"]);

        if ($password == '' || $newPassword == '' || $confirmPassword == '') {
            $alert = "Không được trống";
            return array('msg' => $alert, 'status' => 'error');
        } else if (strlen($password) < '8') {
            $alert = "Mật khẩu phải có ít nhất 8 ký tự!";
            return array('msg' => $alert, 'status' => 'error');
        } elseif (!preg_match("#[0-9]+#", $password) || !preg_match("#[0-9]+#", $newPassword) || !preg_match("#[0-9]+#", $confirmPassword)) {
            $alert = "Mật khẩu phải có ít nhất 1 số!";
            return array('msg' => $alert, 'status' => 'error');
        } elseif (!preg_match("#[A-Z]+#", $password) || !preg_match("#[A-Z]+#", $newPassword) || !preg_match("#[A-Z]+#", $confirmPassword)) {
            $alert = "Mật khẩu phải chứa ít nhất 1 chữ in hoa!";
            return array('msg' => $alert, 'status' => 'error');
        } elseif (!preg_match("#[a-z]+#", $password) || !preg_match("#[a-z]+#", $newPassword) || !preg_match("#[a-z]+#", $confirmPassword)) {
            $alert = "Mật khẩu phải chứa ít nhất 1 chữ thường!";
            return array('msg' => $alert, 'status' => 'error');
        } elseif ($password == $newPassword) {
            $alert = 'Mật khẩu mới phải khác mật khẩu cũ';
            return array('msg' => $alert, 'status' => 'error');
        } elseif ($newPassword != $confirmPassword) {
            $alert = 'Mật khẩu nhập lại không trùng khớp';
            return array('msg' => $alert, 'status' => 'error');
        } else {
            $password = md5($password);

            $query = "SELECT * FROM taikhoan WHERE ID = '$user_id' AND MatKhau = '$password' LIMIT 1";
            $result = $this->db->select($query);

            if ($result != false) {
                $newPassword = md5($newPassword);
                $queryUpdate = "UPDATE taikhoan 
                    SET MatKhau = '$newPassword' WHERE ID = '$user_id'";

                $resultUpdate = $this->db->update($queryUpdate);
                if ($resultUpdate !== false) {
                    $alert = "Đổi mật khẩu thành công";
                    return array('msg' => $alert, 'status' => 'success');
                }
            } else {
                $alert = 'Mật khẩu cũ không chính xác';
                return array('msg' => $alert, 'status' => 'error');
            }
        }
    }
}

?>