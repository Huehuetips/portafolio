<?php 

	namespace app\controllers;
	use app\models\mainModel;

	/**
	 * CONTROLADOR DE USUARIOS
	 */
	class userController extends mainModel
	{

		/**
		 * OBTIENE LA LISTA DE USUARIOS DE LA DB
		 */

		public function userLister($limit,$offset,$brws="",$id=0)
		{			

			if ($id==0) {
				
				if (isset($brws) && $brws!="") {
					$fields =[ #CAMPOS DE REGISTRO DEL QUERY
			 	 		[
							"field_name"  =>"p_userName",
							"field_mark"  =>":p_userName",
							"field_value" => $brws
			 	 		]
			 	 	];
			 	 	$userList=$this->queSP("getUsersLikeName",$fields);
			

				} else {

					$fields =[ #CAMPOS DE REGISTRO DEL QUERY
			 	 		[
							"field_name"  =>"p_limit",
							"field_mark"  =>":p_limit",
							"field_value" => $limit
			 	 		],
			 	 		[
							"field_name"  =>"p_offset",
							"field_mark"  =>":p_offset",
							"field_value" =>$offset
			 	 		]
			 	 	];
			 	 	$userList=$this->queSP("getUsersWithPagination",$fields);


				}
			}else{
				$fields =[ #CAMPOS DE REGISTRO DEL QUERY
			 	 		[
							"field_name"  =>"p_userId",
							"field_mark"  =>":p_userId",
							"field_value" => $id
			 	 		]
			 	 	];
			 	 	$userList=$this->queSP("getUserById",$fields);
			}

			return $userList;
		}



		/**
		 *	CONTROLADOR PARA REGISTRAR USUARIOS
		 */
		public function registerUser()
		{
			//////////////////////////////////////////
			/// ALMACENAMIENTO DE DATOS DE USUARIOS //
			//////////////////////////////////////////

	
			$userUser      =$this->cleanString($_POST['userUser']);
			$userPassword  =$this->cleanString($_POST['userPassword']);
			$userPassword2 =$this->cleanString($_POST['userPassword2']);
			// $type          =$this->cleanString($_POST['type']);


			// echo '<pre>'; print_r($_POST); echo '</pre>';
			// echo '<pre>'; print_r($_FILES['userPhoto']); echo '</pre>';

			////////////////////////////////////////
			///Verificación de campos obligatorio //
			////////////////////////////////////////

			if ($userUser=="" || empty($userUser) || $userPassword=="" || empty($userPassword) || $userPassword2=="" || empty($userPassword)) {

				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"No has llenado todos los campos obligatorios",
					"icon"  =>"danger"
				];
				return json_encode($alert);
				exit();
			}

			///////////////////////////////
			///verificando datos válidos //
			///////////////////////////////

			if ($this->dataValid("[a-zA-Z0-9]{7,30}",$userUser)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El USUARIO no coincide con el formato establecido",
					"icon"  =>"danger",
					"focus" =>"userUser"
				];
				return json_encode($alert);
				exit();
			}

			if ($this->dataValid("[a-zA-Z0-9]{8,100}",$userPassword) || $this->dataValid("[a-zA-Z0-9]{8,100}",$userPassword2)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"los PASSWORD no coincide con el formato establecido",
					"icon"  =>"danger",
					"focus" =>"userPassword"
				];
				return json_encode($alert);
				exit();
			}

			/**
			 * VERIFICANDO EL USUSARIO
			 */
			
		

			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"userName",
					"field_mark"  =>":userName",
					"field_value" =>$userUser
	 	 		]
	 	 	];
			/**
			 * VALIDANDO DATOS
			 */
			$userValidate=$this->queSP("getUsersByName",$fields);

			if (!empty($userValidate)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El USUARIO que intenta registrar ya existe",
					"icon"  =>"warning",
					"focus" =>"userUser"
				];
				return json_encode($alert);
				exit();
			}

			/**
			 * VALIDANDO LA COINCIDENCIA DE LOS PASWORD
			 */

			if ($userPassword!=$userPassword2) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Las contraseñas no coinciden",
					"icon"  =>"danger",
					"focus" =>"userPassword"
				];
				return json_encode($alert);
				exit();
			} else {
				$userPassword=password_hash($userPassword2,PASSWORD_BCRYPT,["cost"=>8]);
			}
			
			/**
			 * DATOS PARA REALIZAR EL QUERY
			 */

			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
							"field_name"  =>"userName",
							"field_mark"  =>":userName",
							"field_value" =>$userUser
	 	 		],
	 	 		[
							"field_name"  =>"userPassword",
							"field_mark"  =>":userPassword",
							"field_value" =>$userPassword
	 	 		]
	 	 	];

	 	 	$registerUser=$this->queSP("insertUser",$fields);

	 	 	if (empty($registerUser)) {

	 	 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No se ha podido registrar el usuario, intente nuevamente",
					"icon"     =>"error",
					"position" =>"center-end" ,
					"timer"    =>5
				];

				return json_encode($alert);
				exit();
	 	 	}

	 	 	$alert=[
					"type"     =>"clean",
					"title"    =>"EXITO!",
					"icon"     =>"success",
					"position" =>"top-end" ,
					"timer"    =>0.65
				];
			return json_encode($alert);
			exit();
		}
	 	 	


		public function disableUser()
		{
			$id=$this->cleanString($_POST['userId']);

			//validando que no intenten eliminar el usuario principal
			if($id==1){
				$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No podemos deshabilitar el usuario principal",
					"icon"     =>"error",
					"position" =>"center",
				];
				return json_encode($alert);
				exit();
			}

			//verificando datos del usuario
			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"userName",
					"field_mark"  =>":userName",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userLastName",
					"field_mark"  =>":userLastName",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userEmail",
					"field_mark"  =>":userEmail",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userUser",
					"field_mark"  =>":userUser",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userPassword",
					"field_mark"  =>":userPassword",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userPhoto",
					"field_mark"  =>":userPhoto",
					"field_value" =>""
	 	 		],
	 	 		[ 
					"field_name"  =>"userId", 
					"field_mark"  =>":userId" , 
					"field_value" =>$id
	 	 		]
	 	 	];

		 	$user=$this->queSP("SpUsers","Whe",$fields);

		 	if (empty($user)) {
		 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No tenemos registro de este usuario",
					"icon"     =>"error",
					"position" =>"center",
				];
				return json_encode($alert);
				exit();
		 	}


		 	$disableUser=$this->queSP("SpUsers","Dis",$fields);
		 	if (empty($user)) {
		 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No se ha podido eliminar el usuario",
					"icon"     =>"error",
					"position" =>"center",
					];
				return json_encode($alert);
				exit();
		 	}

		 	$alert=[
				"type"     =>"reload",
				"text"     =>"Se ha deshabilitado el usuario",
				"icon"     =>"success",
				"position" =>"center",
			];
			return json_encode($alert);
			exit();
		}


		public function deleteUser()
		{
			$id=$this->cleanString($_POST['userId']);

			//validando que no intenten eliminar el usuario principal
			if($id==1){
				$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No podemos eliminar el usuario principal",
					"icon"     =>"error",
					"position" =>"center",
				];
				return json_encode($alert);
				exit();
			}

			//verificando datos del usuario
			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"userName",
					"field_mark"  =>":userName",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userLastName",
					"field_mark"  =>":userLastName",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userEmail",
					"field_mark"  =>":userEmail",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userUser",
					"field_mark"  =>":userUser",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userPassword",
					"field_mark"  =>":userPassword",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userPhoto",
					"field_mark"  =>":userPhoto",
					"field_value" =>""
	 	 		],
	 	 		[ 
					"field_name"  =>"userId", 
					"field_mark"  =>":userId" , 
					"field_value" =>$id
	 	 		]
	 	 	];

		 	$user=$this->queSP("SpUsers","Whe",$fields);

		 	if (empty($user)) {
		 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No tenemos registro de este usuario",
					"icon"     =>"error",
					"position" =>"center",
				];
				return json_encode($alert);
				exit();
		 	}




		 	$disableUser=$this->queSP("SpUsers","Del",$fields);
		 	if (empty($user)) {
		 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No se ha podido eliminar el usuario",
					"icon"     =>"error",
					"position" =>"center",
					];
				return json_encode($alert);
				exit();
		 	}

		 	$alert=[
				"type"     =>"reload",
				"text"     =>"Se ha eliminado el usuario",
				"icon"     =>"success",
				"position" =>"center",
			];
			return json_encode($alert);
			exit();
		}

		public function updateUser()
		{
			//////////////////////////////////////////
			/// ALMACENAMIENTO DE DATOS DE USUARIOS //
			//////////////////////////////////////////

			$userName      =$this->cleanString($_POST['userUser']);
			$idUsuario      =$this->cleanString($_POST['idUsuario']);
			$userPassword  =$this->cleanString($_POST['userPassword']);
			$userPassword2 =$this->cleanString($_POST['userPassword2']);
			// $type          =$this->cleanString($_POST['type']);


			// echo '<pre>'; print_r($_POST); echo '</pre>';
			// echo '<pre>'; print_r($_FILES['userPhoto']); echo '</pre>';

			////////////////////////////////////////
			///Verificación de campos obligatorio //
			////////////////////////////////////////

			if ($userName=="" || empty($userName) || $userPassword=="" || empty($userPassword) || $userPassword2=="" || empty($userPassword)) {

				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"No has llenado todos los campos obligatorios",
					"icon"  =>"danger"
				];
				return json_encode($alert);
				exit();
			}

			///////////////////////////////
			///verificando datos válidos //
			///////////////////////////////

			if ($this->dataValid("[a-zA-Z0-9]{7,30}",$userName)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El NOMBRE no coincide con el formato establecido",
					"icon"  =>"danger",
					"focus" =>"userUser"
				];
				return json_encode($alert);
				exit();
			}


			if ($this->dataValid("[a-zA-Z0-9]{8,100}",$userPassword) || $this->dataValid("[a-zA-Z0-9]{8,100}",$userPassword2)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"los PASSWORD no coincide con el formato establecido",
					"icon"  =>"danger",
					"focus" =>"userPassword"
				];
				return json_encode($alert);
				exit();
			}

			/**
			 * VERIFICANDO EL EMAIL
			 */
			

			/**
			 * VERIFICANDO EL USUSARIO
			 */
			
			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"userName",
					"field_mark"  =>":userName",
					"field_value" =>$userName
	 	 		]
	 	 	];
			// /**
			//  * VALIDANDO DATOS
			//  */

			// $userValidate=$this->queSP("getUsersByName",$fields);
					

			// if (!empty($userValidate)) {
			// 	$alert=[
			// 		"type"  =>"msg",
			// 		"title" =>"ERROR",
			// 		"text"  =>"El USUARIO que intenta registrar ya existe",
			// 		"icon"  =>"warning",
			// 		"focus" =>"userName"
			// 	];
			// 	return json_encode($alert);
			// 	exit();
			// }

			/**
			 * VALIDANDO LA COINCIDENCIA DE LOS PASWORD
			 */

			if ($userPassword!=$userPassword2) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Las contraseñas no coinciden",
					"icon"  =>"danger",
					"focus" =>"userPassword"
				];
				return json_encode($alert);
				exit();
			} else {
				$userPassword=password_hash($userPassword2,PASSWORD_BCRYPT,["cost"=>8]);
			}
			
			
			/**
			 * DATOS PARA REALIZAR EL QUERY
			 */

			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
							"field_name"  =>"p_userId",
							"field_mark"  =>":p_userId",
							"field_value" =>$idUsuario
	 	 		],
	 	 		[
							"field_name"  =>"p_userName",
							"field_mark"  =>":p_userName",
							"field_value" =>$userName
	 	 		],
	 	 		[
							"field_name"  =>"p_userPassword",
							"field_mark"  =>":p_userPassword",
							"field_value" =>$userPassword
	 	 		]
	 	 	];	
			
			if ($_SESSION['User']->userId!=$idUsuario) {
				$alert=[
					"type"     =>"msg",
					"title"    =>"ERROR",
					"text"     =>"Solo el propietario puede cambiar su contraseña",
					"icon"     =>"danger",
					"position" =>"center-end" ,
					"timer"    =>5
				];

				return json_encode($alert);
				exit();
			}

	 	 	$registerUser=$this->queSP("updateUser",$fields);

	 	 	if (empty($registerUser)) {
	 	 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No se ha podido registrar el usuario, intente nuevamente",
					"icon"     =>"error",
					"position" =>"center-end" ,
					"timer"    =>5
				];

				return json_encode($alert);
				exit();
	 	 	}

	 	 	if ($_SESSION['User']->userId==$idUsuario) {
	 	 		$alert=[
					"type" =>"redirect",
					"url"  => APP_URL."logOut"
				];
	 	 	}else{

		 	 	$alert=[
						"type"     =>"clean",
						"title"    =>"EXITO!",
						"icon"     =>"success",
						"position" =>"top-end" ,
						"timer"    =>0.65
					];
	 	 	}
			return json_encode($alert);
			exit();
		}



		/**
		 * Controlador de condiciones para habilitar un usuario
		 * @return json Código de alerta para informar el usuario habilitado
		 */
		public function enableUser()
		{
			$id=$this->cleanString($_POST['userId']);

			//validando que no intenten eliminar el usuario principal
		

			//verificando datos del usuario
			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"userName",
					"field_mark"  =>":userName",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userLastName",
					"field_mark"  =>":userLastName",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userEmail",
					"field_mark"  =>":userEmail",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userUser",
					"field_mark"  =>":userUser",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userPassword",
					"field_mark"  =>":userPassword",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"userPhoto",
					"field_mark"  =>":userPhoto",
					"field_value" =>""
	 	 		],
	 	 		[ 
					"field_name"  =>"userId", 
					"field_mark"  =>":userId" , 
					"field_value" =>$id
	 	 		]
	 	 	];

		 	$user=$this->queSP("SpUsers","Whe",$fields);

		 	if (empty($user)) {
		 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No tenemos registro de este usuario",
					"icon"     =>"error",
					"position" =>"center",
				];
				return json_encode($alert);
				exit();
		 	}


		 	$disableUser=$this->queSP("SpUsers","Ena",$fields);
		 	if (empty($user)) {
		 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No se ha podido habilitar el usuario",
					"icon"     =>"error",
					"position" =>"center",
					];
				return json_encode($alert);
				exit();
		 	}

		 	$alert=[
				"type"     =>"reload",
				"text"     =>"Ya se encuentra activo el Usuario el usuario",
				"icon"     =>"success",
				"position" =>"center",
			];
			return json_encode($alert);
			exit();
		}


		/**
		 * Es la función que devuelve el código html para la paginación en la consulta de usuarios
		 * @param  int $pag      el número de página a donde nos acabamos de mover
		 * @param  int $totalPag el total de páginas que deben haber
		 * @param  url $url      nombre de la vista en donde nos encontramos ubicados
		 * @return string           devuelve el código html para construir el navegador de páginas
		 */
		public function pagination($pag,$totalPag,$url)
		{
			return $this->TabPages($pag, $totalPag, $url, 7);
		}


	}

	
 ?>