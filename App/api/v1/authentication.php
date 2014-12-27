<?php
$app->get('/session', function() {
    $db = new DB_Handler();
    $session = $db->getSession();
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["name"] = $session['name'];    
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwdHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'passwd'),$r->customer);
    $response = array();
    $db = new DB_Handler();
    $passwd = $r->customer->passwd;
    $email = $r->customer->email;
    $user = $db->get_singleRow("SELECT * FROM web_tp2.usuario WHERE email_usuario = '" . $email . "' AND passwd_usuario = '" . $passwd ."';");
    if ($user != NULL) {
        if(passwdHash::check_password($user['passwd_usuario'],$passwd)) {
            $response['status'] = "success";
            $response['message'] = "Bem vindo " . $user['nome_usuario'] . ".";
            $response['uid'] = $user['id_usuario'];
            $response['nome'] = $user['nome_usuario'];
            $response['email'] = $user['email_usuario'];
            $response['dataNascimento'] = $user['data_nasc_usuario'];
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $user['id_usuario'];
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user['nome_usuario'];
        } else {
            $response['status'] = "error";
            $response['message'] = "Error! Credenciais inválidas.";
        }
    } else {
            $response['status'] = "error";
            $response['message'] = "Error! Credenciais inválidas.";
	}
    echoResponse(200, $response);
});

$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'name', 'passwd', 'birthday'),$r->customer);
    require_once 'passwdHash.php';
    $db = new DB_Handler();
    $email = $r->customer->email;
    $passwd = $r->customer->passwd;
    $name = $r->customer->name;
    $birthday = date("Y-m-d", strtotime($r->customer->birthday));
    $isUserExists = $db->get_singleRow("SELECT * FROM web_tp2.usuario WHERE email_usuario = '" . $email . "';");
    if(!$isUserExists){
        $passwd = passwdHash::hash($passwd);
        $table_name = "usuario";
        $column_names = array('email_usuario', 'passwd_usuario', 'nome_usuario', 'data_nasc_usuario');
        $values = array($email, $passwd, $name, $birthday);
        $result = $db->create_register($table_name, $column_names, $values);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Erro ao cadastrar usuário! Por favor tente novamente.";
            echoResponse(201, $response);
        }            
    } else{
        $response["status"] = "error";
        $response["message"] = "Email já cadastrado!";
        echoResponse(201, $response);
    }
});

$app->get('/logout', function() {
    $db = new DB_Handler();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logout feito com sucesso.";
    echoResponse(200, $response);
});

?>