<?php 
$app->post('/getClasses', function() use ($app) {
	$r = json_decode($app->request->getBody());
	$response = array();

    verifyRequiredParams(array('id_curso'), $r);

    $db = new DB_Handler();

    $id_curso = $r->id_curso;
    $id = $db->getSession()['uid'];

    $sql = "SELECT * FROM web_tp2.materia mat
            INNER JOIN (SELECT * FROM web_tp2.materia_has_usuario WHERE id_usuario = '" . $id . "') aux1
            ON mat.id_materia = aux1.id_materia
            WHERE id_curso_materia = '" . $id_curso . "';";

    $materias = $db->get_multipleRows($sql);

    if ($materias != NULL) {
        $response['status'] = "success";
        foreach ($materias as $materia) {
            $response['materias'][] = $materia;
        }
        echoResponse(200, $response);
    } else {
		$response['status'] = "error";
    	$response['message'] = "No classes were found";
        echoResponse(201, $response);
	}

});

?>