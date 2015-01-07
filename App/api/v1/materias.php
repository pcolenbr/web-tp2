<?php 
$app->post('/getClassesNames', function() use ($app) {
    $r = json_decode($app->request->getBody());
    $response = array();

    verifyRequiredParams(array('id_curso', 'enroll'), $r);

    $db = new DB_Handler();

    $id_curso = $r->id_curso;
    $enroll = $r->enroll;

    if($enroll) {
        $sql = "SELECT DISTINCT nome_materia FROM web_tp2.materia WHERE id_curso_materia = '" . $id_curso . "';";
    } else {
        $id = $db->getSession()['uid'];
        $sql = "SELECT DISTINCT nome_materia FROM web_tp2.materia mat
            INNER JOIN (SELECT * FROM web_tp2.materia_has_usuario WHERE id_usuario = '" . $id . "') aux1
            ON mat.id_materia = aux1.id_materia
            WHERE id_curso_materia = '" . $id_curso . "';";
    }

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

$app->post('/listYearsSemester', function() use ($app) {
    $r = json_decode($app->request->getBody());
    $response = array();

    verifyRequiredParams(array('nome_materia', 'enroll'), $r);

    $db = new DB_Handler();

    $nome_materia = $r->nome_materia->name;
    $enroll = $r->enroll;

    if($enroll) {
        $sql = "SELECT id_materia, ano_materia, semestre_materia FROM web_tp2.materia WHERE nome_materia = '" . $nome_materia . "';";
    } else {
        $id = $db->getSession()['uid'];
        $sql = "SELECT id_materia, ano_materia, semestre_materia FROM web_tp2.materia mat
        INNER JOIN (SELECT id_materia AS id_mat, id_usuario FROM web_tp2.materia_has_usuario WHERE id_usuario = '" . $id . "') aux1
        ON mat.id_materia = aux1.id_mat
        WHERE nome_materia = '" . $nome_materia . "';";
    }

    $anos = $db->get_multipleRows($sql);

    if ($anos != NULL) {
        $response['status'] = "success";
        foreach ($anos as $ano) {
            $response['anos'][] = $ano;
        }
        echoResponse(200, $response);
    } else {
        $response['status'] = "error";
        $response['message'] = "No classes were found";
        echoResponse(201, $response);
    }

});

$app->post('/enroll', function() use ($app) {
    $r = json_decode($app->request->getBody());
    $response = array();

    verifyRequiredParams(array('major', 'subjectId'), $r->enrollment);

    $db = new DB_Handler();

    $id_major = $r->enrollment->major;
    $id_class = $r->enrollment->subjectId;
    $id_user = $db->getSession()['uid'];

    $alreadyOnMajor = $db->get_singleRow("SELECT * FROM web_tp2.usuario_in_curso WHERE id_usuario = '" . $id_user . "' AND id_curso = '" . $id_major . "';");

    if($alreadyOnMajor == NULL) {
        $table_name = "usuario_in_curso";
        $column_names = array('id_usuario', 'id_curso');
        $values = array($id_user, $id_major);
        $result = $db->create_register($table_name, $column_names, $values);
        if ($result == NULL) {
            $response['status'] = "error";
            $response['message'] = "We couldn't enroll you now. Please try again!";
            echoResponse(201, $response);
        }
    }

    $table_name = "materia_has_usuario";
    $column_names = array('id_materia', 'id_usuario');
    $values = array($id_class, $id_user);
    $result = $db->create_register($table_name, $column_names, $values);
    
    if ($result != NULL) {
        $response['status'] = "success";
        $response['message'] = "You were enrolled in the class!";
        echoResponse(201, $response);
    } else {
        $response['status'] = "error";
        $response['message'] = "We couldn't enroll you now. Please try again!";
        echoResponse(201, $response);
    }

});

?>