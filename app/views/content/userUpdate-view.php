<div class="<?php echo CONFIG_FORM; ?>">
	<!-- <p class="text-end pt-4 pb-4">
		<a href="javascript:history.back()" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i> Volver</a>
	</p> -->

	<?php 
	use app\controllers\userController;
	$dataUser = new userController();


	$id= (isset($url[1]) && $url[1]>0) ? (int) $url[1] : $_SESSION['User']->userId;
	$id=$dataUser->cleanString($id);


	if ($id==$_SESSION['User']->userId) {
		?>	
		<h2>Mi Cuenta</h2>
		<span>Actualizar Cuenta</span>
		<?php 
		$userList=$_SESSION['User'];
	} else {
		?>
		<h2>Usuarios</h2>
		<span>Actualizar Usuarios</span>
		<?php 
		$userList=$dataUser->userLister("","","", $id);
		if (!empty($userList)) {
			$userList=$userList[0];
		}

	}

	if (!empty($userList)) {

		$userName         = $userList->userName;
		$completeName     = $userName;
		$userDateCreate   = date("d/m/Y h:i a",strtotime($userList->dateCreated));
		$userDateUpdate   = date("d/m/Y h:i a",strtotime($userList->dateUpdated));
		$userDateInactive = (empty($userList->userDateInactive)) ? "" : date("d/m/Y h:i a",strtotime($userList->userDateInactive)) ;
		$userId           = $userList->userId;
	}else{
		$userName         = "";
		$userLastName     = "";
		$completeName	  = "NO SE HA ENCONTRADO REGISTRO DE ESTE USUARIO";
		$userEmail        = "";
		$userUser         = "";
		$userDateCreate   = "";
		$userDateUpdate   = "";
		$userDateInactive = "";
		$userId           =0;
	}

	?>

	



	<h2 class="text-center"><?php echo $completeName; ?></h2>

	<p class="text-center"><strong>Usuario Creado:</strong> <?php echo $userDateCreate; ?> &nbsp; <strong>Usuario Actualizado:</strong> <?php echo $userDateUpdate; ?></p>
	<?php if (!empty($userDateInactive)) {
		?> 
		<p class="text-center"><strong>Usuario Inactivo desde:</strong> <?php echo $userDateInactive; ?></p>
		<?php 
	} ?>

    <div id="divAlert"></div>
	<form class="row g-3 mt-4 AjaxForm" action="<?php echo APP_URL; ?>app/ajax/usersAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="register" value="Upd">
		<input type="hidden" name="idUsuario" value="<?php echo $userId; ?>">
	<div class="col-md-6" data-toggle="tooltip" data-placement="top" title="Por favor utilizar solo letras y números (sin espacios, tildes, ñ o caracteres especiales) con un mínimo de 7 caracteres">
	    <label for="userUser" class="form-label is-required">Nombre de Usuario</label>
	    <input type="text" class="form-control" maxlength="30" id="userUser" name="userUser" value="<?php echo $userName; ?>" pattern="[a-zA-Z0-9]{7,30}" placeholder="Usuario" autocomplete="off" required>
	  </div>
	  
	  <span class="text-center mt-5">para actualizar el usuario debe ingresar su contraseña actual</span>
    <div class="col-md-6" data-toggle="tooltip" data-placement="top" title="Por favor utilizar solo letras y números (sin espacios, tildes, ñ o caracteres especiales) con un mínimo de 8 caracteres">
	    <label for="userPassword" class="form-label is-required">Password</label>
	    <input type="password" class="form-control" id="userPassword" name="userPassword" pattern="[a-zA-Z0-9]{8,100}" maxlength="100" autocomplete="off" placeholder="Password" required>
	  </div>
	  <div class="col-md-6">
	    <label for="userPassword2" class="form-label is-required">Repetir Password</label>
	    <input type="password" class="form-control" id="userPassword2" name="userPassword2" pattern="[a-zA-Z0-9]{8,100}" maxlength="100" autocomplete="off" placeholder="Password" required>
	  </div>
		<div id="divAlert"></div>
	  <div class="col-12">
	    <button type="submit" class="btn btn-primary">Actualizar</button>
	    <button type="reset" class="btn btn-secondary">Cancelar</button>
	  </div>
	</form>

</div>