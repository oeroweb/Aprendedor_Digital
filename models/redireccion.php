<?php

	session_set_cookie_params(60*60*24*2);
	session_start();

	// iniciar la sesion
	if(!isset($_SESSION)){
		session_start();
	}

	if(!isset($_SESSION['sesion_aprenDigital'])){
		header("Location: index.php");
	}

?>