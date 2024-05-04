<?php 
    // Session::checkLogin();
    require_once("../lib/database.php");
    require_once("../helpers/format.php");
?>

<?php 
class rom
{

    private $db;

    public function __construct(){
        $this->db = new Database();
    }
     
    public function get_rom() {
        $query = "SELECT * FROM phong";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }
}

?>