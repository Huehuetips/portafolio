<?php 
	
	namespace app\models;
	use \PDO;

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require __DIR__ . '/../../vendor/autoload.php';

	if(file_exists(__DIR__."/../../config/server.php")){
		require_once __DIR__."/../../config/server.php";
	}

	/**
	 * MODELOS PRINCIPALES
	 */
	class mainModel
	{

		private $server = DB_SERVER;
		private $db = DB_NAME;
		private $user = DB_USER;
		private $pass = DB_PASS;
		private $port = DB_PORT;

		
		protected function conect()
		{
			
			try {
			    $link = new PDO("mysql:host=".DB_SERVER.";port=".DB_PORT.";dbname=".DB_NAME, DB_USER, DB_PASS);
			    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
			    die("Connection failed: " . $e->getMessage());
			}
		    
		    return $link;

		}

		protected function execQue($query,$dataReturn=true)
		{
			$sql=$this->conect()->prepare($query);
			echo '<pre>'; print_r($sql); echo '</pre>';
			
			$sql->execute();

			if ($dataReturn) {
				return $sql -> fetchAll(PDO::FETCH_CLASS);
			} else {
				return $sql;
			}

		}


		public function cleanString($string)
		{
			$blackList = ["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==","=",";","::","EXECUTE","EXEC"];

			$string = trim($string);
			$string = stripcslashes($string);

			foreach ($blackList as $word) {
				$string = str_ireplace($word, "", $string);
			}

			$string = trim($string);
			$string = stripcslashes($string);

			if(empty($string)){
				$string="";
			}

			return $string;

		}

		protected function dataValid($filter, $string)
		{
			if (preg_match("/^".$filter."$/", $string)) {
				return false;
			} else {
				return true;
			}
			
		}


		protected function queSP($SP,$fields,$dataReturn=true)
		{
			$SP=$this->cleanString($SP);
			foreach ($fields as $field) {
				$field["field_value"]=$this->cleanString($field["field_value"]);
			}

			$query="Call $SP (";

			$cont=0;
			foreach ($fields as $field) {
				$query.= $field["field_mark"].",";
			}
			$query = substr($query, 0, -1);

			$query.=")";
			
			$sql=$this->conect()->prepare($query);

			foreach ($fields as $field) {
				$sql->bindParam($field["field_mark"],$field["field_value"]);
			}

			$sql->execute();

			if ($dataReturn) {
				return $sql -> fetchAll(PDO::FETCH_CLASS);
			} else {
				return $sql;
			}
			
		}

		public function encryption($string)
		{
			// return urlencode(base64_encode($string));
			/*-------------------------------------------*/
			$output=false;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

		public function decryption($string)
		{
			// return base64_decode(urldecode($string));
			/*-------------------------------------------*/
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

		protected function TabPages($pag, $numPag, $url, $buttons)
		{
			$table='<nav aria-label="Page navigation example"><ul class="pagination">';

	        if($pag<=1){
	            $table.='<li class="page-item disabled"><a class="page-link"><</a></li>';
	        }else{
	            $table.='<li class="page-item"><a class="page-link" href="'.$url."/".($pag-1).'/"><</a></li>';
	        }

	        for ($i=1; $i <$pag ; $i++) { 
	        	$table.='<li class="page-item"><a class="page-link" href="'.$url."/".$i.'/">'.$i.'</a></li>';
	        }

        	$table.='<li class="page-item active"><a class="page-link" href="'.$url."/".$pag.'/">'.$pag.'</a></li>';

        	for ($i=($pag+1); $i <=$numPag ; $i++) { 
	        	$table.='<li class="page-item"><a class="page-link" href="'.$url."/".$i.'/">'.$i.'</a></li>';
	        }


	        if($pag==$numPag){
	            $table.='<li class="page-item disabled"><a class="page-link">></a></li>
	            ';
	        }else{
	            $table.='<li class="page-item"><a class="page-link" href="'.$url."/".($pag+1).'/">></a></li>';
	       }

	        $table.='  </ul></nav>';
	        return $table;

		}

		function generarColorHexadecimal() {
		    // Genera un color hexadecimal aleatorio
		    $color = '#';
		    $hex_chars = '0123456789ABCDEF';
		    
		    // Selecciona seis caracteres hexadecimales aleatorios
		    for ($i = 0; $i < 6; $i++) {
		        $color .= $hex_chars[rand(0, 15)];
		    }
		    
		    return $color;
		}

		protected function enviarCorreo($correo, $texto, $asunto) {
		    $mail = new PHPMailer(true);
		    try {
		        $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo a UTF-8
		        $mail->Encoding = 'base64'; // Codificación del contenido del correo

		        // Configuración del servidor SMTP de Gmail
		        $mail->Subject = $asunto;
		        $mail->isSMTP();
		        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
		        $mail->SMTPAuth = true;
		        $mail->Username = 'sendmail3535@gmail.com'; // Tu dirección de correo de Gmail
		        $mail->Password = 'ekwtrtpkzyghnzqs'; // Tu contraseña de aplicación generada
		        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		        $mail->Port = 587;

		        // Configuración del correo
		        $mail->setFrom('sendmail3535@gmail.com', NAME_ENG);
		        $mail->addAddress($correo);

		        // Contenido del correo
		        $mail->isHTML(true);
		        $mail->Body    = $texto;
		        $mail->AltBody = "No se que es el altbody";

		        if ($this->verificarMX($correo)) {
				    $mail->send();
				} else {
				    return false;
				}
		        return true;
		    } catch (Exception $e) {
		        return null;
		    }
		}

		protected function verificarMX($email) {
		    return checkdnsrr(substr(strrchr($email, "@"), 1)/*Extrae el dominio */, "MX"); // Verifica si el dominio tiene registros MX
		}




		protected function MessageTypeMail($Type,$data=[])
		{
			switch ($Type) {
				case 'msgToMe':
					$mensaje = '
						<!DOCTYPE html>
						<html>
						<head>
						    <meta charset="UTF-8">
						    <meta name="viewport" content="width=device-width, initial-scale=1.0">
						    <title>Correo con Botón Estilizado</title>
						    <style>
						        .btn-custom {
						            background-color: #007bff; /* Color azul */
						            color: white; /* Texto blanco */
						            border-radius: 50px; /* Bordes redondeados */
						            padding: 10px 20px; /* Espaciado interno */
						            font-size: 1.2em; /* Tamaño de fuente */
						            text-decoration: none; /* Quitar subrayado */
						            display: inline-block; /* Mostrar como bloque en línea */
						            transition: background-color 0.3s ease; /* Transición suave */
						        }
						        .btn-custom:hover {
						            background-color: #0056b3; /* Color azul oscuro al pasar el ratón */
						        }
						    </style>
						</head>
						<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
						    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 10px;">
						        <div style="text-align: center; padding-bottom: 20px;">
						            <h1>'.$data["correo"].' te ha enviado  un mensaje</h1>
						        </div>
						        <div style="text-align: left;">
						            <p>MENSAJE</p>
						            <p>'.$data["message"].'</p>
						            <p style="text-align: center;">
						                <a href="'.APP_URL.'" target="_blank" class="btn-custom" style="
						                    background-color: #007bff;
						                    color: white;
						                    border-radius: 50px;
						                    padding: 10px 20px;
						                    font-size: 1.2em;
						                    text-decoration: none;
						                    display: inline-block;
						                    transition: background-color 0.3s ease;
						                ">Ir a Portafolio</a>
						            </p>
						        </div>
						        <div style="text-align: center; padding-top: 20px; font-size: 12px; color: #999;">
						            <p>&copy; 2024 Mi Portafolio. Libre de Derechos.</p>
						        </div>
						    </div>
						</body>
						</html>
						';
					break;
				
				case 'Contact':
					$mensaje = '
						<!DOCTYPE html>
						<html>
						<head>
						    <meta charset="UTF-8">
						    <meta name="viewport" content="width=device-width, initial-scale=1.0">
						    <title>Correo con Botón Estilizado</title>
						    <style>
						        .btn-custom {
						            background-color: #007bff; /* Color azul */
						            color: white; /* Texto blanco */
						            border-radius: 50px; /* Bordes redondeados */
						            padding: 10px 20px; /* Espaciado interno */
						            font-size: 1.2em; /* Tamaño de fuente */
						            text-decoration: none; /* Quitar subrayado */
						            display: inline-block; /* Mostrar como bloque en línea */
						            transition: background-color 0.3s ease; /* Transición suave */
						        }
						        .btn-custom:hover {
						            background-color: #0056b3; /* Color azul oscuro al pasar el ratón */
						        }
						    </style>
						</head>
						<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
						    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 10px;">
						        <div style="text-align: center; padding-bottom: 20px;">
						            <h1>ES UN GUSTO ATENDERTE!</h1>
						        </div>
						        <div style="text-align: left;">
						            <p>Hola,</p>
						            <p>Muchas gracias por tu mensaje a '.NAME_ENG.'.</p>
						            <p>Trataremos de contestarte lo mas pronto posible.</p>
						            <p style="text-align: center;">
						                <a href="'.APP_URL.'" target="_blank" class="btn-custom" style="
						                    background-color: #007bff;
						                    color: white;
						                    border-radius: 50px;
						                    padding: 10px 20px;
						                    font-size: 1.2em;
						                    text-decoration: none;
						                    display: inline-block;
						                    transition: background-color 0.3s ease;
						                ">Ir a Portafolio</a>
						            </p>
						        </div>
						        <div style="text-align: center; padding-top: 20px; font-size: 12px; color: #999;">
						            <p>&copy; 2024 Mi Portafolio. Libre de Derechos.</p>
						        </div>
						    </div>
						</body>
						</html>
						';
					break;
				
				default:
					break;
			}
			return $mensaje;
		}
}
 ?>