<?php
class DB_usuario {

	function __construct() {

	}

	public function inserir_usuario($nome, $nasc, $sexo, $email, $senha) {
		require_once 'DB_Connect.php';

		$uniq_id = uniqid('', false);
		$hash = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 10]);

		$sql = "INSERT INTO `web_tp2`.`usuario`(`id_usuario`,`nome_usuario`,`data_nasc_usuario`,`sexo_usuario`,`email_usuario`,`senha_usuario`,`admin_usuario`)
				VALUES
				('" . $uniq_id . "','" . $nome .  "','" . $nasc . "','" . "','" . $sexo . "','" . $email .  "','" . $hash .  "',' 0 ');";
				
		$query = $conn->query($sql);
		
		if($query == true) {
			$row = $query->fetchAll();
			
			$retorno = array(
					'sucesso' => 1,
	    			'id_usuario' => $uniq_id,
					'nome_usuario' => $nome
			);
			return $retorno;

		} else {
			$retorno = array(
	    		'sucesso' => 0
			);
			return $retorno;
		}
	}

	public function get_dados($email) {
		require_once 'DB_Connect.php';

		$sql = "SELECT * FROM usuario WHERE email_usuario = '" . $email . "';";
		$query = $conn->query($sql);

		if($query == true) {
			$row = $query->fetchAll();

			$retorno = array(
					'sucesso' => 1,
	    			'id_usuario' => $row[0]['id_usuario'],
					'nome_usuario' => $row[0]['nome_usuario'],
					'data_nasc_usuario' => $row[0]['data_nasc_usuario'],
					'sexo_usuario' => $row[0]['sexo_usuario'],
					'email_usuario' => $row[0]['email_usuario']					
			);
			return $retorno;

		} else {
			$retorno = array(
	    		'sucesso' => 0
			);
			return $retorno;
		}
	}

	public function login($email, $senha) {
		require_once 'DB_Connect.php';

		$sql = "SELECT * FROM usuario WHERE email_usuario = '" . $email . "';";

		$query = $conn->query($sql);

		if($query == true) {
			$row = $query->fetchAll();

			$hash = $row[0]['senha_usuario'];

			if (password_verify($senha, $hash)) {
				$retorno = array(
					'validation' => 1,
	    			'nome_usuario' => $row[0]['nome_usuario']
				);
				return $retorno;
			}
		}

		$retorno = array(
	    	'validation' => 0
		);
		return $retorno;
	}

}

?>