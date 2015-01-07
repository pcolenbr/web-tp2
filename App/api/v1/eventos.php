<?php 
$app->post('/getEvents', function() use ($app) {
	$r = json_decode($app->request->getBody());

	$response = array();
    $db = new DB_Handler();

    $id = $db->getSession()['uid'];

    $sql = "SELECT * FROM (SELECT * FROM (SELECT * FROM web_tp2.evento ev
            INNER JOIN (SELECT id_usuario, id_materia AS id_mat FROM web_tp2.materia_has_usuario WHERE id_usuario = '" . $id . "') aux1
            ON ev.id_materia_evento = aux1.id_mat) aux3
            INNER JOIN web_tp2.materia mat
            ON mat.id_materia = aux3.id_mat) aux4
            INNER JOIN web_tp2.curso cur
            ON cur.id_curso = aux4.id_curso_materia;";

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
    
    verifyRequiredParams(array('nm', 'description', 'major', 'subjectId', 'start', 'end'), $r->currentEvent);

    $db = new DB_Handler();

    $name = $r->currentEvent->nm;
    $description = $r->currentEvent->description;
    $start = date("Y-m-d", strtotime($r->currentEvent->start));
    $end = date("Y-m-d", strtotime($r->currentEvent->end));
    $subject = $r->currentEvent->subjectId;

    $table_name = "evento";
    $column_names = array('nome_evento', 'descricao_evento', 'data_inicio_evento', 'data_fim_evento', 'id_materia_evento');
    $values = array($name, $description, $start, $end, $subject);
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

$app->post('/editEvent', function() use ($app) {
    $r = json_decode($app->request->getBody());
    $response = array();
    
    verifyRequiredParams(array('id', 'nm', 'description', 'major', 'subjectId', 'start', 'end'), $r->currentEvent);

    $db = new DB_Handler();

    $id = $r->currentEvent->id;
    $name = $r->currentEvent->nm;
    $description = $r->currentEvent->description;
    $start = date("Y-m-d", strtotime($r->currentEvent->start));
    $end = date("Y-m-d", strtotime($r->currentEvent->end));
    $subject = $r->currentEvent->subjectId;

    $table_name = "evento";
    $column_id = "id_evento";
    $column_names = array('nome_evento', 'descricao_evento', 'data_inicio_evento', 'data_fim_evento', 'id_materia_evento');
    $values = array($name, $description, $start, $end, $subject);
    $result = $db->update_register($table_name, $column_names, $values, $column_id, $id);

    if ($result != NULL) {
        $response["status"] = "success";
        $response["message"] = "Event updated successfully";
        echoResponse(200, $response);
    } else {
        $response['status'] = "error";
        $response['message'] = "Event could not be updated. Plese try again";
        echoResponse(201, $response);
    }

});

?>