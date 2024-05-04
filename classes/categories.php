<?php 
    // Session::checkLogin();
    require_once("../lib/database.php");
    require_once("../helpers/format.php");
?>

<?php 
class categories
{

    private $db;

    public function __construct(){
        $this->db = new Database();
    }
     
    public function get_cate() {
        $query = "SELECT * FROM loaiphim";
        $result = $this->db->select($query);

        if($result !== false) {
            return $result;
        } else {
            return false;
        }
    }
}

?>