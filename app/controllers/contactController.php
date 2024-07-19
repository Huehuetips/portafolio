<?php 

	namespace app\controllers;
	use app\models\mainModel;

	/**
	 * CONTROLADOR DE LOGIN
	 */
	class contactController extends mainModel
	{
		/**
		 * CONTROLADOR DEL INICIO DE SESION
		 */
		
		public function mailContact()
		{

			/**
			 * LIMPIANDO Y ALMACENANDO DATOS
			 */

			$email      =$this->cleanString($_POST['email']);
			$message  =$this->cleanString($_POST['message']);	
		

			if ($email=="" || empty($email) || $message=="" || empty($message)) {
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
			
			if ($this->dataValid("[a-zA-Z0-9@.]{3,50}",$email)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El CORREO no coincide con el formato establecido",
					"icon"  =>"danger",
					"focus" =>"email"
				];
				return json_encode($alert);
				exit();
			}
			if ($this->dataValid(".{15,500}",$message)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El CORREO no coincide con el formato establecido",
					"icon"  =>"danger",
					"focus" =>"message"
				];
				return json_encode($alert);
				exit();
			}

			
			$Msg=$this->MessageTypeMail("Contact");
			$mailValidate=$this->enviarCorreo($email,$Msg,"Gracias por tu comentario", "no-reply");

			if (is_null($mailValidate)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Ha habido un error con el servidor, no se  ha podido enviar el coreo al cliente",
					"icon"  =>"danger",
					"focus" =>"email"
				];
				return json_encode($alert);
				exit();
			}elseif (!$mailValidate) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Tu correo no parece válido, intenta nuevamente",
					"icon"  =>"danger",
					"focus" =>"email"
				];
				return json_encode($alert);
				exit();
			}

			$dataMail=[
				"correo" => $email,
				"message" => $message
			];

			$Msg=$this->MessageTypeMail("msgToMe",$dataMail);
			$mailValidate=$this->enviarCorreo("emontejodev@emontejodev.com",$Msg,"Nuevo Mensaje de la página", "emontejodev");

			if (is_null($mailValidate)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Ha habido un error con el servidor, no se  ha podido enviar el correo",
					"icon"  =>"danger",
					"focus" =>"email"
				];
				return json_encode($alert);
				exit();
			}elseif (!$mailValidate) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El correo no parece válido, intenta nuevamente",
					"icon"  =>"danger",
					"focus" =>"email"
				];
				return json_encode($alert);
				exit();
			}

			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"pMessageEmail",
					"field_mark"  =>":pMessageEmail",
					"field_value" =>$email
	 	 		],
	 	 		[
					"field_name"  =>"pMessageContent",
					"field_mark"  =>":pMessageContent",
					"field_value" =>$message
	 	 		]
	 	 	];
			$Msg=$this->queSP("InsertMessage",$fields);

			if (empty($Msg)) {

	 	 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"Lo sentimos, el mensaje solo se ha guardado temporalmente, tendrá una respuesta muy pronto",
					"icon"     =>"error",
					"position" =>"bottom-end"
				];

				return json_encode($alert);
				exit();
	 	 	}

			$alert=[
				"type"     =>"clean",
				"title"    =>"GRACIAS!",
				"position" =>"top-end",
				"text"     =>"El correo ha sido enviado",
				"icon"     =>"success",
				"timer"    =>1,
				"focus"    =>"email"
			];
			return json_encode($alert);
			exit();
		}


	}

?>