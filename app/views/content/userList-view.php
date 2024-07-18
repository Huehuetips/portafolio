<?php 

	$register =10;
	use app\controllers\userController;

	if (isset($url[1]) and $url[1]!="" ) {
		$brws     =$url[1];
	}else{
		$brws=1;
	}

	$dataUser = new userController();
	if (is_numeric($brws)) {
		$userList=$dataUser->userLister(1000,0);
	}else{
		$userList=$dataUser->userLister(0,0,$brws);	
	}
		// echo '<pre>'; print_r($userList); echo '</pre>';

	$totalReg=count($userList);

	$totalPag=ceil($totalReg/$register);

	$path   =APP_URL.$url[0];
	// echo '<pre>'; print_r($path); echo '</pre>';

	// echo '<pre>'; print_r($url); echo '</pre>';

	$pag      = (isset($url[1]) && $url[1]>0) ? (int) $url[1] : 1;
	$start    = $pag*$register-$register;
	$end      = $pag*$register;

	$pagination=$dataUser->pagination($pag,$totalPag,$path);

 ?>

<div class="<?php echo CONFIG_FORM; ?>">
	<h2>Usuarios</h2>
	<span>Lista de Usuarios</span>
    <div id="divAlert"></div>
	<div class="table-responsive mt-4">
		<table class="table table-hover  table-borderless tableList">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Usuario</th>
					<th scope="col" class="text-center" colspan="4">OPCIONES</th>
				</tr>
			</thead>
			<tbody>
			<?php
			if (!empty($userList)) {
	 	 	for ($i=$start; $i < $end; $i++) {
	 	 		if (isset($userList[$i])) {
			 	 		
		 	 		if ($userList[$i]->userId==$_SESSION['User']->userId) {
		 	 			echo '<tr class="table-primary">';
		 	 		}elseif ($userList[$i]->userActive) {
		 	 			echo '<tr>';
		 	 		}else{
		 	 		 	echo '<tr class="table-danger">';
		 	 		}
			?>
				<th class="table-light"><?php echo $i+1; ?></th>
				<td><?php echo $userList[$i]->userName; ?></td>
                <td>
                	<a href="<?php echo APP_URL."userUpdate/".$userList[$i]->userId; ?>/" role="button" title="INFORMACIÓN" class="btn btn-dark btn-outline-info"><i class="bi bi-person-circle"></i></a>
                </td>
                
            	<?php 
                	if ($userList[$i]->userActive) {
		 	 		 	echo '<td><form class="ConfirmForm" action="'.APP_URL.'app/ajax/usersAjax.php" method="POST" autocomplete="off" >

								<input type="hidden" name="register" value="Dis">
		                		<input type="hidden" name="userId" value="'.$userList[$i]->userId.'">

		                    	<button type="submit" class="btn btn-dark btn-outline-danger" title="DESHABILITAR"><i class="bi bi-person-x"></i></button>
		                    </form></td>
		                    <td></td>
		                    ';
		 	 		}else{
		 	 			echo ' <td><form class="ConfirmForm" action="'.APP_URL.'app/ajax/usersAjax.php" method="POST" autocomplete="off" >
								
								<input type="hidden" name="register" value="Ena">
		                		<input type="hidden" name="userId" value="'.$userList[$i]->userId.'">

		                    	<button type="submit" class="btn btn-dark btn-outline-success" title="HABILITAR"><i class="bi bi-person-check"></i></button>
		                    </form></td>
		                    <td><form class="ConfirmForm" action="'.APP_URL.'app/ajax/usersAjax.php" method="POST" autocomplete="off" >
								
								<input type="hidden" name="register" value="Del">
		                		<input type="hidden" name="userId" value="'.$userList[$i]->userId.'">

		                    	<button type="submit" class="btn btn-dark btn-outline-danger" title="ELIMINAR"><i class="bi bi-trash3"></i></button>
		                    </form></td>
		                   ';
		 	 		}

            	 ?>  	
                

			</tr>
	 		<?php 
	 			}else{
	 				$end=$i;
	 				break;
	 			}
	 		}
			}else{
			?>
				<tr class="text-center">
					<td colspan="9" class="h4">
						No se encontraron registros
					</td>
				</tr>
			<?php 
			}

	  		?>
			</tbody>
		</table>
		<!-- <div class="container"> -->
				
			<div class="d-flex bd-highlight mb-3" style="width: 100%;">
				
		    	<div class="me-auto p-2 bd-highlight">
		            <a href="<?php echo $path; ?>/" role="button" class="btn btn-primary btn-lg btl-block">
		                <i class="bi bi-arrow-clockwise"></i>
		            </a>
		    	</div>
		    	<div class="p-2 bd-highlight">
		    		
			<?php 
			$start++;
			if(!empty($userList) && $pag<=$totalPag && $totalPag>1){
				echo '<p class="has-text-right">Mostrando usuarios del <strong>'.$start.'</strong> al <strong>'.$end.'</strong> de un <strong>total de '.$totalReg.'</strong></p>'.$pagination;

				
			}




			 ?>

		    	</div>

			</div>
		<!-- </div> -->


	</div>
</div>