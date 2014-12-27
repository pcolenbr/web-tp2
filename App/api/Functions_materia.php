<?php

class Functions_materia {

	function __construct() {

	}

	public function get_materia($id) {
		require_once 'DB_materia.php';

		$db_materia = new DB_materia();

		$query_result = $db_materia->get_materia($id);

		if ($query_result['sucesso'] == 1) {
			$response["success"] = 1;

			$response['materia']['id']   = $query_result['id_materia'];
			$response['materia']['nome'] = $query_result['nome_materia'];
			$response['materia']['ab'] = $query_result['ab_materia'];
			$response['materia']['periodo']   = $query_result['periodo_materia'];
			$response['materia']['id_curso'] = $query_result['id_curso_materia'];
			$response['materia']['nome_curso'] = $query_result['nome_curso'];
			$response['materia']['ab_curso'] = $query_result['ab_curso'];
		} else {
			$response["error_msg"] = "Matéria não encontrada";

			return json_encode($response);
		}

	}

	public function list_all_materia() { 
		require_once 'DB_materia.php';

		$db_materia = new DB_materia();

		$query_result = $db_materia->list_all_materia();

		if ($query_result['sucesso'] == 1) {
			$response["success"] = 1;

			$materias = $query_result['id_materia'];
			$i = 0;
			foreach ($materias as $materia) {
				$response['materia'][$i]['id']   = $query_result['id_materia'][$i];
				$response['materia'][$i]['nome'] = $query_result['nome_materia'][$i];
				$response['materia'][$i]['ab'] = $query_result['ab_materia'][$i];
				$response['materia'][$i]['periodo']   = $query_result['periodo_materia'][$i];
				$response['materia'][$i]['id_curso'] = $query_result['id_curso_materia'][$i];
				$response['materia'][$i]['nome_curso'] = $query_result['nome_curso'][$i];
				$response['materia'][$i]['ab_curso'] = $query_result['ab_curso'][$i];
				$i++;
			}
		} else {
			$response["error_msg"] = "Erro ao listar materias";

			return json_encode($response);
		}

	}
}

?>