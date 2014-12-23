<?php
class DB_materia {

	function __construct() {

	}

	public function get_materia($id) {
		require_once 'DB_Connect.php';

		$sql = "SELECT * FROM web_tp2.materia materia INNER JOIN web_tp2.curso curso ON materia.id_curso_materia = curso.id_curso WHERE materia.id_curso_materia = '" . $id . "';";

		$query = $conn->query($sql);

		if($query == true) {
			$row = $query->fetchAll();

			$retorno = array(
					'sucesso' => 1,
					'id_materia' => $row[0]['id_materia'],
	    			'nome_materia' => $row[0]['nome_materia'],
					'ab_materia' => $row[0]['ab_materia'],
					'periodo_materia' => $row[0]['periodo_materia'],
					'id_curso_materia' => $row[0]['id_curso_materia'],
					'nome_curso' => $row[0]['nome_curso'],
					'ab_curso' => $row[0]['ab_curso'],
			);
			return $retorno;

		} else {
			$retorno = array(
	    		'sucesso' => 0
			);
			return $retorno;
		}
	}

	public function list_all_materia() {
		require_once 'DB_Connect.php';

		$sql = "SELECT * FROM web_tp2.materia materia INNER JOIN web_tp2.curso curso ON materia.id_curso_materia = curso.id_curso;";

		$rows_id_materia = array();
		$rows_nome_materia = array();
		$rows_ab_materia = array();
		$rows_periodo_materia = array();
		$rows_id_curso_materia = array();
		$rows_nome_curso = array();
		$rows_ab_curso = array();

		$query = $conn->query($sql);

		if($query == true) {
			foreach ($conn->query($sql) as $row) {
				array_push($rows_id_materia, $row['id_materia']);
				array_push($rows_nome_materia, $row['nome_materia']);
				array_push($rows_ab_materia, $row['ab_materia']);
				array_push($rows_periodo_materia, $row['periodo_materia']);
				array_push($rows_id_curso_materia, $row['id_curso_materia']);
				array_push($rows_nome_curso, $row['nome_curso']);
				array_push($rows_ab_curso, $row['ab_curso']);
			}

			$retorno = array(
					'sucesso' => 1,
					'id_materia' => $rows_id_materia,
					'nome_materia' => $rows_nome_materia,
	    			'ab_materia' => $rows_ab_materia,
					'periodo_materia' => $rows_periodo_materia,
					'id_curso_materia' => $rows_id_curso_materia,
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