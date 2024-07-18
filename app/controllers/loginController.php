<?php 

	namespace app\controllers;
	use app\models\mainModel;

	/**
	 * CONTROLADOR DE LOGIN
	 */
	class loginController extends mainModel
	{
		/**
		 * CONTROLADOR DEL INICIO DE SESION
		 */
		
		public function sessionStart()
		{

			/**
			 * LIMPIANDO Y ALMACENANDO DATOS
			 */

			$userName      =$this->cleanString($_POST['userName']);
			$userPassword  =$this->cleanString($_POST['userPassword']);	
		

			if ($userName=="" || empty($userName) || $userPassword=="" || empty($userPassword)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"No has llenado todos los campos obligatorios",
					"icon"  =>"danger"
				];
				return json_encode($alert);
				exit();
			}

			/**
			 * VERIFICANDO DATOS VÁLIDOS
			 */
			
			if ($this->dataValid("[a-zA-Z0-9]{7,30}",$userName)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El USUARIO no coincide con el formato establecido",
					"icon"  =>"danger",
					"focus" =>"userName"
				];
				return json_encode($alert);
				exit();
			}

			if ($this->dataValid("[a-zA-Z0-9]{8,100}",$userPassword)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El PASSWORD no coincide con el formato establecido",
					"icon"  =>"danger",
					"focus" =>"userPassword"
				];
				return json_encode($alert);
				exit();
			}

			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"userName",
					"field_mark"  =>":userName",
					"field_value" =>$userName
	 	 		]
	 	 	];
	 	 	// echo "$userName";
			/**
			 * VALIDANDO DATOS
			 */
			$userValidate=$this->queSP("getUsersByName",$fields);




			if (empty($userValidate)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Usuario o Password incorrectos",
					"icon"  =>"danger",
					"focus" =>"userName"
				];
				return json_encode($alert);
				exit();
			}


			if (password_verify($userPassword, $userValidate[0]->userPassword)) {

				if ($userValidate[0]->userActive==0) {
					$alert=[
						"type"     =>"pop-up",
						"title"    =>"ERROR",
						"text"     =>"Este Usuario no tiene permisos para acceder",
						"icon"     =>"error",
						"position" =>"center"
					];
					return json_encode($alert);
					exit();
				}

				$_SESSION['User']=$userValidate[0];
			
				$alert=[
					"type"  =>"redirect",
					"url" =>APP_URL
				];
				return json_encode($alert);
				exit();

			}else{
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Usuario o Password incorrectos",
					"icon"  =>"danger",
					"focus" =>"userName"
				];
				return json_encode($alert);
				exit();
			}
		}

		public function sessionClose()
		{
			session_destroy();

			if (headers_sent()) {
				echo "
					 <script>
					 	window.location.href='".APP_URL."';
					 </script>
				 ";
			} else {

				header("location: ".APP_URL);
				
			}
			

		}



	}

?>