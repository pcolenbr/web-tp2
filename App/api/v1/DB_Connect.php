<?php
class DB_Connect {
	private $conn;

    function __construct() {        
    }

    function connect() {
	   	require_once '../config.php';
 
		try {
			$conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
			return $conn;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}

    }
} 
?>