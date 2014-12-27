<?php

class Functions_instituicao {

	function __construct() {
		require_once 'DB_Handler.php';
	}

	public function get_instituicao($id) {
		$db = new Db_Handler();

		$sql = "SELECT * FROM web_tp2.instituicao WHERE id_instituicao = '" . $id . "';";

		$query_result = $db->get_singleRow($sql);
		
		var_dump($query_result);
	}

	public function list_all() { 
		$db = new Db_Handler();

		$sql = "SELECT * FROM web_tp2.instituicao;";

		$query_result = $db->get_multipleRows($sql);

		var_dump($query_result);
	}
}

?>