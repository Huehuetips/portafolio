<?php 
		

	namespace app\controllers;
	use app\models\viewsModel;
	/**
	 * CONTROLADOR DE LAS VISTAS
	 */
	class viewsController extends viewsModel
	{
		
		public function getControllerViews($view)
		{
			if ($view!="") {
				$answer = $this->getModelViews($view);
			} else {
				$answer = "HOME";
			}
			
			return $answer;


		}
	}



 ?>