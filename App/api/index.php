<?php
if (isset($_POST['ident']) && $_POST['ident'] != '') {
	$ident = $_POST['ident'];

	// resposta
	$response = array(
        "ident" => $ident,
        "success" => 0
	);

	if ($ident == 'get_instituicao') {
		$id  = $_POST['id'];

		require_once 'Functions_instituicao.php';
		$inst = new Functions_instituicao();
			
		echo $inst->get_instituicao($id);
	} 
	else if($ident == 'get_allInstituicao') {
		require_once 'Functions_instituicao.php';
		$inst = new Functions_instituicao();
			
		echo $inst->list_all();
	}

}
?>