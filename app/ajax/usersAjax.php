<?php 

	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";

	use app\controllers\userController;

	if (isset($_POST['register'])) {

		$insUsuario=new userController();
		
		if($_POST['register']=="Ins"){
			echo $insUsuario->registerUser();
		}

		if($_POST['register']=="Dis"){
			echo $insUsuario->disableUser();
		}

		if($_POST['register']=="Ena"){
			echo $insUsuario->enableUser();
		}

		if($_POST['register']=="Del"){
			echo $insUsuario->deleteUser();
		}

		if($_POST['register']=="Upd"){
			echo $insUsuario->updateUser();
		}

		

	} else {
		session_destroy();
		header("Location: ".APP_URL."LOGIN/");
	}
	











 ?>