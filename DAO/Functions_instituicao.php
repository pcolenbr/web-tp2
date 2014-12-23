<?php

class Functions_boulder {

	function __construct() {

	}

	public function get_instituicao($id) {
		require_once 'DB_instituicao.php';

		$db_instituicao = new DB_instituicao();

		$query_result = $db_instituicao->get_instituicao($id);

		if ($query_result['sucesso'] == 1) {
			$response["success"] = 1;

			$response['instituicao']['id']   = $query_result['id_instituicao'];
			$response['instituicao']['nome'] = $query_result['nome_instituicao'];
			$response['instituicao']['pais']   = $query_result['pais_instituicao'];
			$response['instituicao']['ab'] = $query_result['ab_instituicao'];
		} else {
			$response["error_msg"] = "Instituição não encontrada";

			return json_encode($response);
		}

	}

	public function list_all_instituicao() { 
		require_once 'DB_instituicao.php';

		$db_instituicao = new DB_instituicao();

		$query_result = $db_instituicao->list_all_instituicao();

		if ($query_result['sucesso'] == 1) {
			$response["success"] = 1;

			$instituicoes = $query_result['id_instituicao'];
			$i = 0;
			foreach ($instituicoes as $instituicao) {
				$response['id_instituicao'][$i]['id']   = $query_result['id_instituicao'][$i];
				$response['nome_instituicao'][$i]['nome'] = $query_result['nome_instituicao'][$i];
				$response['pais_instituicao'][$i]['pais']   = $query_result['pais_instituicao'][$i];
				$response['ab_instituicao'][$i]['ab'] = $query_result['ab_instituicao'][$i];
				$i++;
			}
		} else {
			$response["error_msg"] = "Erro ao listar insticuições";

			return json_encode($response);
		}

	}
}

?>