<?php 
	/////////////////////////////////////
	//configuración de URL Y APLICACIÓN//
	/////////////////////////////////////

	const APP_URL="http://localhost/portafolio/";
	const APP_NAME="Adony Montejo";
	const NAME_ENG="Adony Montejo";
	const APP_SESSION_NAME="PIXELWORKS";

	//CONFIGURACIÓN DE RUTAS
	const APP_LOGO=APP_URL."app/views/img/Logo.webp";
	const APP_IMAGEN=APP_URL."app/views/img/";

	//CONFIGURACIÓN DE FORMULARIOS
	const CONFIG_FORM="container-md";


	//CONFIGURACIÓN DE ENCRIPTACIÓN
	const METHOD="AES-256-CBC";
	const SECRET_KEY=''; //comillas simples para evitar interpretación como variable
	const SECRET_IV="";


	date_default_timezone_set("America/Guatemala");

 ?>