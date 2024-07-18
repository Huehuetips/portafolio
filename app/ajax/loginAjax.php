<?php 

	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";

	use app\controllers\loginController;

	if (isset($_POST['log'])) {

		$login=new loginController();
		
		if($_POST['log']=="log"){
			echo $login->sessionStart();
		}

	} else {
		session_destroy();
		header("Location: ".APP_URL."LOGIN/");
	}
	



 ?>