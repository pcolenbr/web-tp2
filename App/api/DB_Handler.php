<?php
class DB_Handler {
	private $conn;

    function __construct() {
        require_once 'DB_Connect.php';
        
        $db = new DB_Connect();
        $this->conn = $db->connect();
    }

    public function get_singleRow($sql) {
    	$query = $this->conn->query($sql . " LIMIT 1") or die($this->conn->error.__LINE__);

    	return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function get_multipleRows($sql) {
    	$query = $this->conn->query($sql) or die($this->conn->error.__LINE__);

    	return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>