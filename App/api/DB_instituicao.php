<?php
class DB_instituicao {

	function __construct() {

	}

	public function get_instituicao($id) {
		require_once 'DB_Connect.php';

		$sql = "SELECT * FROM web_tp2.instituicao WHERE id_instituicao = '" . $id . "';";

		$query = $conn->query($sql);

		if($query == true) {
			$row = $query->fetchAll();

			$retorno = array(
					'sucesso' => 1,
					'id_instituicao' => $row[0]['id_instituicao'],
	    			'nome_instituicao' => $row[0]['nome_instituicao'],
					'pais_instituicao' => $row[0]['pais_instituicao'],
					'ab_instituicao' => $row[0]['ab_instituicao']
			);
			return $retorno;

		} else {
			$retorno = array(
	    		'sucesso' => 0
			);
			return $retorno;
		}
	}

	public function list_all_instituicao() {
		require_once 'DB_Connect.php';

		$sql = "SELECT * FROM web_tp2.instituicao;";

		$rows_id_instituicao = array();
		$rows_nome_instituicao = array();
		$rows_pais_instituicao = array();
		$rows_ab_instituicao = array();

		$query = $conn->query($sql);

		if($query == true) {
			foreach ($conn->query($sql) as $row) {
				array_push($rows_id_instituicao, $row['id_instituicao']);
				array_push($rows_nome_instituicao, $row['nome_instituicao']);
				array_push($rows_pais_instituicao, $row['pais_instituicao']);
				array_push($rows_ab_instituicao, $row['ab_instituicao']);
			}

			$retorno = array(
					'sucesso' => 1,
					'id_instituicao' => $rows_id_instituicao,
	    			'nome_instituicao' => $rows_nome_instituicao,
					'pais_instituicao' => $rows_pais_instituicao,
					'ab_instituicao' => $rows_ab_instituicao
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