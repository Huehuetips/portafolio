<?php 
	require_once "../../../../config/app.php";
	require_once "../../../../autoload.php";

	use app\models\mainModel;
	$colors=new mainModel();

	$lleno = json_decode($_POST['lleno']);

	$cantidad = 9;
	$colores = array(
	    '#FFFFFF' => 9,   // Blanco
	    '#FFF600' => 9,   // Amarillo
	    '#18C10B' => 9,   // Verde
	    '#1800FF' => 9,   // Azul
	    '#FF8400' => 9,   // Naranja
	    '#FF0000' => 9    // Rojo
	);

	$caras = [
		"front",
		"back",
		"left",
		"right",
		"top",
		"bottom"
		];


	function getColor($colores) {
	    $colores_disponibles = array_keys(array_filter($colores, function($cantidad) {
	        return $cantidad > 0;
	    }));
	    
	    $color = $colores_disponibles[array_rand($colores_disponibles)];
	    $colores[$color]--;
	    
	    return $color;
	}


	function generarCara($color, $cantidad, $clase, $lleno, $colores) {

	    
	}


	foreach ($caras as $cara) {
	    echo '<div class="face ' . $cara . '">';
	    if ($lleno) {
	    	switch ($cara) {
	            case 'front':
	                $color = '#FFFFFF';
	                break;
	            case 'back':
	                $color = '#FFF600';
	                break;
	            case 'left':
	                $color = '#18C10B';
	                break;
	            case 'right':
	                $color = '#1800FF';
	                break;
	            case 'top':
	                $color = '#FF8400';
	                break;
	            case 'bottom':
	                $color = '#FF0000';
	                break;
	            default:
	                $color = '#FFFFFF';
	                break;
	        }
	        for ($i = 0; $i < $cantidad; $i++) {
	            echo '<div style="background: ' . $color . ';" class="cube"></div>';
	        }
	    } else {
	        // Mostrar cubo desarmado con colores aleatorios
	        for ($i = 0; $i < $cantidad; $i++) {
	            echo '<div style="background: ' . getColor($colores) . ';" class="cube"></div>';
	        }
	    }
	    echo '</div>';
	}



?>