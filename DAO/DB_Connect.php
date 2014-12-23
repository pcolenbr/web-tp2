<?php
require_once 'config.php';
 
static $conn = null;

if (is_null($conn)) {
	
	try {
		$conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}	
}
 
?>