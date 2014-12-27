<?php 
$app->post('/teste', function() use ($app) {
	$r = json_decode($app->request->getBody());

    verifyRequiredParams(array('email'),$r->customer);

	$response = array();
    $db = new DB_Handler();

    $id = $r->customer->email;

    $sql = "SELECT * FROM web_tp2.instituicao WHERE id_instituicao = '" . $id . "';";
    $instituicao = $db->get_singleRow($sql);

    if ($instituicao != NULL) {
    	$response['status'] = "success";
    	$response['id'] = $instituicao['id_instituicao'];
        $response['nome'] = $instituicao['nome_instituicao'];
    } else {
		$response['status'] = "error";
    	$response['message'] = "Nenhuma instituição encontrada";
	}

	echoResponse(200, $response);
});
?>