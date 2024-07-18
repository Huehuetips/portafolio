<?php 

	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";

	use app\controllers\contactController;

	if (isset($_POST['con'])) {

		$contact=new contactController();
		
		if($_POST['con']=="con"){
			echo $contact->mailContact();
		}

	} else {
		session_destroy();
		header("Location: ".APP_URL."LOGIN/");
	}
	



 ?>