<?php 
	
	namespace app\models;

	/**
	 * MODELO DE CONTROLADOR DE VISTAS
	 */
	class viewsModel
	{
		

		protected function getModelViews($view)
		{
			$witheList = [	"userForm",
							"logOut",
							"userList",
							"userUpdate"];


			if (in_array($view, $witheList) && is_file("app/views/content/".$view."-view.php")) {
				$content = "app/views/content/".$view."-view.php";
			}elseif ($view=="LOGIN") {
				$content = "LOGIN";
			}elseif ($view=="HOME") {
				$content = "HOME";
			}elseif (!is_file("app/views/content/".$view."-view.php")) {
				$content = "404";
			}elseif (!in_array($view, $witheList)) {
				$content = "403";
			}

			return $content;

		}
	}













 ?>