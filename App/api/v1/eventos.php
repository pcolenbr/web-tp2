<?php 
$app->post('/getEvents', function() use ($app) {
	$r = json_decode($app->request->getBody());

	$response = array();
    $db = new DB_Handler();

    $id = $db->getSession()['uid'];

    $sql = "SELECT * FROM web_tp2.evento ev
            INNER JOIN (SELECT * FROM web_tp2.materia_has_usuario WHERE id_usuario = '" . $id . "') aux1
            ON ev.id_materia_evento = aux1.id_materia;";

    $eventos = $db->get_multipleRows($sql);

    if ($eventos != NULL) {
        $response['status'] = "success";
        foreach ($eventos as $evento) {
            $response['eventos'][] = $evento;
        }
        echoResponse(200, $response);
    } else {
		$response['status'] = "error";
    	$response['message'] = "No events were found";
        echoResponse(201, $response);
	}

});

$app->post('/createEvent', function() use ($app) {
    $r = json_decode($app->request->getBody());
    $response = array();
    
    verifyRequiredParams(array('nm'), $r->currentEvent);

    $db = new DB_Handler();

    $name = $r->currentEvent->nm;

    $table_name = "evento";
    $column_names = array('nome_evento', 'data_inicio_evento', 'id_materia_evento');
    $values = array($name, '2015-01-05', '1');
    $result = $db->create_register($table_name, $column_names, $values);

    if ($result != NULL) {
        $response["status"] = "success";
        $response["message"] = "Event created successfully";
        echoResponse(200, $response);
    } else {
        $response['status'] = "error";
        $response['message'] = "Event could not be created. Plese try again";
        echoResponse(201, $response);
    }

});

?>