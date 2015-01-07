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

    public function create_register($table_name, $column_names, $value) {
        $insert_columns = '';
        $insert_values = '';

        for($i = 0; $i < count($column_names); $i++) {
            $insert_columns = $insert_columns."`" . $column_names[$i]."`, ";
            $insert_values = $insert_values."'".$value[$i]."', ";
        }

        $sql = "INSERT INTO `web_tp2`.`" . $table_name . "` (" . rtrim($insert_columns, ' ,') . ") VALUES (" . rtrim($insert_values, ' ,') . ");";
        
        $query = $this->conn->query($sql) or die($this->conn->error.__LINE__);
        if ($query) {
            $new_row_id = $this->conn->lastInsertId();
            return $new_row_id;
        } else {
            return NULL;
        }
    }

    public function update_register($table_name, $column_names, $values, $id_column, $id_value) {
        $update_statement = '';

        for($i = 0; $i < count($column_names); $i++) {
            $update_statement = $update_statement . "`" . $column_names[$i] . "` = '" . $values[$i] . "', ";
        }

        $sql = "UPDATE `web_tp2`.`" . $table_name . "` SET " . rtrim($update_statement, ' ,') . " WHERE `" . $id_column . "` = '" . $id_value . "';";

        $query = $this->conn->query($sql) or die($this->conn->error.__LINE__);
        if ($query) {
            return $id_value;
        } else {
            return NULL;
        }

    }

    public function getSession(){
        if (!isset($_SESSION)) {
            session_start();
        }
        $sess = array();
        if(isset($_SESSION['uid'])) {
            $sess["uid"] = $_SESSION['uid'];
            $sess["name"] = $_SESSION['name'];
            $sess["email"] = $_SESSION['email'];
        } else {
            $sess["uid"] = '';
            $sess["name"] = 'Guest';
            $sess["email"] = '';
        }
        return $sess;
    }

    public function destroySession(){
        if (!isset($_SESSION)) {
        session_start();
        }
        if(isSet($_SESSION['uid']))
        {
            unset($_SESSION['uid']);
            unset($_SESSION['name']);
            unset($_SESSION['email']);
            $info = 'info';
            if(isSet($_COOKIE[$info]))
            {
                setcookie ($info, '', time() - $cookie_time);
            }
            $msg="Logged Out Successfully...";
        }
        else
        {
            $msg = "Not logged in...";
        }
        return $msg;
    }
    
}
?>