<?php

class Functions_usuario {

	function __construct() {

	}

	public function login($email, $senha) {
		require_once 'DB_usuario.php';
		
		$db_usr = new DB_usuario(); 
			
		$query_result = $db_usr -> login($email, $senha);
		if ($query_result['validation'] == 1) {
			$response["success"] = 1;

			$response['usuario']['logged_in']  = 1;
			$response['usuario']['nome_usuario'] = $query_result['nome_usuario'];

			return json_encode($response);
		} else {
			$response['usuario']['logged_in'] = 0;
			$response["error_msg"]            = "Email ou senha inválidos";

			return json_encode($response);
		}
	}

	public function get_dados($email) {
		require_once 'DB_usuario.php';
		
		$db_usr = new DB_usuario();
		
		$query_result = $db_usr->get_dados($email);
		if ($query_result['sucesso'] == 1) {
			$response["success"] = 1;

			$response['usuario']['id_usuario']      	  = $query_result['id_usuario'];
			$response['usuario']['nome_usuario']          = $query_result['nome_usuario'];
			$response['usuario']['data_nasc_usuario']     = $query_result['data_nasc_usuario'];
			$response['usuario']['sexo_usuario']          = $query_result['sexo_usuario'];
			$response['usuario']['email_usuario']         = $query_result['email_usuario'];
			

			return json_encode($response);
		} else {
			$response["error_msg"] = "Usuario nao encontrado";

			return json_encode($response);
		}
	}
	
	public function inserirUsuario($nome, $nasc, $sexo, $email, $senha) {
		require_once 'DB_usuario.php';
		
		$db_usr = new DB_usuario();
		
		$query_result = $db_usr->inserir_usuario($nome, $nasc, $sexo, $email, $senha);
		
        if ($query_result['sucesso'] == 1) {
            $response["success"] = 1;
            
            $response['usuario']['id_usuario'] = $query_result['id_usuario'];
            $response['usuario']['nome_usuario']      = $query_result['nome_usuario'];
            
            return json_encode($response);
        } else {
            $response["error_msg"] = "Erro ao inserir usuario";
            
            return json_encode($response);
        }
	}

}

?>