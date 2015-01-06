<?php 
$app->post('/getMajors', function() use ($app) {
	$r = json_decode($app->request->getBody());

	$response = array();
    $db = new DB_Handler();

    $id = $db->getSession()['uid'];

    $sql = "SELECT * FROM web_tp2.curso cur
            INNER JOIN (SELECT * FROM web_tp2.usuario_in_curso WHERE id_usuario = '" . $id . "') aux1
            ON cur.id_curso = aux1.id_curso;";

    $cursos = $db->get_multipleRows($sql);

    if ($cursos != NULL) {
        $response['status'] = "success";
        foreach ($cursos as $curso) {
            $response['cursos'][] = $curso;
        }
        echoResponse(200, $response);
    } else {
		$response['status'] = "error";
    	$response['message'] = "No majors were found";
        echoResponse(201, $response);
	}

});

?>