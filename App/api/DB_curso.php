<?php
class DB_curso {

	function __construct() {

	}

	public function get_curso($id) {
		require_once 'DB_Connect.php';

		$sql = "SELECT * FROM web_tp2.curso WHERE id_curso = '" . $id . "';";

		$query = $conn->query($sql);

		if($query == true) {
			$row = $query->fetchAll();

			$retorno = array(
					'sucesso' => 1,
					'id_curso' => $row[0]['id_curso'],
	    			'nome_curso' => $row[0]['nome_curso'],
					'ab_curso' => $row[0]['ab_curso']
			);
			return $retorno;

		} else {
			$retorno = array(
	    		'sucesso' => 0
			);
			return $retorno;
		}
	}

	public function list_all_curso() {
		require_once 'DB_Connect.php';

		$sql = "SELECT * FROM web_tp2.curso;";

		$rows_id_curso = array();
		$rows_nome_curso = array();
		$rows_ab_curso = array();

		$query = $conn->query($sql);

		if($query == true) {
			foreach ($conn->query($sql) as $row) {
				array_push($rows_id_curso, $row['id_curso']);
				array_push($rows_nome_curso, $row['nome_curso']);
				array_push($rows_ab_curso, $row['ab_curso']);
			}

			$retorno = array(
					'sucesso' => 1,
					'id_curso' => $rows_id_curso,
	    			'nome_curso' => $rows_nome_curso,
					'ab_curso' => $rows_ab_curso
			);

			return $retorno;
		}

		$retorno = array(
	    	'sucesso' => 0
		);
		return $retorno;
	}

}

?>