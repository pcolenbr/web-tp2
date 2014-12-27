<?php

class Functions_curso {

	function __construct() {

	}

	public function get_curso($id) {
		require_once 'DB_curso.php';

		$db_curso = new DB_curso();

		$query_result = $db_curso->get_curso($id);

		if ($query_result['sucesso'] == 1) {
			$response["success"] = 1;

			$response['curso']['id']   = $query_result['id_curso'];
			$response['curso']['nome'] = $query_result['nome_curso'];
			$response['curso']['ab'] = $query_result['ab_curso'];
		} else {
			$response["error_msg"] = "Curso não encontrado";

			return json_encode($response);
		}

	}

	public function list_all_curso() { 
		require_once 'DB_curso.php';

		$db_curso = new DB_curso();

		$query_result = $db_curso->list_all_curso();

		if ($query_result['sucesso'] == 1) {
			$response["success"] = 1;

			$cursos = $query_result['id_curso'];
			$i = 0;
			foreach ($cursos as $curso) {
				$response['id_curso'][$i]['id']   = $query_result['id_curso'][$i];
				$response['nome_curso'][$i]['nome'] = $query_result['nome_curso'][$i];
				$response['ab_curso'][$i]['ab'] = $query_result['ab_curso'][$i];
				$i++;
			}
		} else {
			$response["error_msg"] = "Erro ao listar cursos";

			return json_encode($response);
		}

	}
}

?>