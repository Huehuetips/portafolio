<div class="<?php echo CONFIG_FORM ?> ">
	<h2>Usuarios</h2>
	<span>Registro de Usuarios</span>
	<form class="row g-3 mt-4 AjaxForm" action="<?php echo APP_URL; ?>app/ajax/usersAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="register" value="Ins">
	  <div class="col-md-4" data-toggle="tooltip" data-placement="top" title="Por favor utilizar solo letras y números (sin espacios, tildes, ñ o caracteres especiales) con un mínimo de 7 caracteres">
	    <label for="userUser" class="form-label is-required">Nombre de Usuario</label>
	    <input type="text" class="form-control" maxlength="30" id="userUser" name="userUser" pattern="[a-zA-Z0-9]{7,30}" placeholder="Usuario" autocomplete="off" required>
	  </div>
	  <div class="col-md-4" data-toggle="tooltip" data-placement="top" title="Por favor utilizar solo letras y números (sin espacios, tildes, ñ o caracteres especiales) con un mínimo de 8 caracteres">
	    <label for="userPassword" class="form-label is-required">Password</label>
	    <input type="password" class="form-control" id="userPassword" name="userPassword" pattern="[a-zA-Z0-9]{8,100}" maxlength="100" autocomplete="off" placeholder="Password" required>
	  </div>
	  <div class="col-md-4">
	    <label for="userPassword2" class="form-label is-required">Repetir Password</label>
	    <input type="password" class="form-control" id="userPassword2" name="userPassword2" pattern="[a-zA-Z0-9]{8,100}" maxlength="100" autocomplete="off" placeholder="Password" required>
	  </div>
		<div id="divAlert"></div>
	  <div class="col-12">
	    <button type="submit" class="btn btn-primary">Insertar</button>
	    <button type="reset" class="btn btn-secondary">Cancelar</button>
	  </div>
	</form>
</div>
