<?php 
	session_start();

	if(isset($_SESSION['sesion_aprenDigital'])){
		session_destroy();
	}
	// setcookie("zilsysActiva", "Session generada de forma diaria", time() -1);
	header('Location: ../index.php');
 ?>
