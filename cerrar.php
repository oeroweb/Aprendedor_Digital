<?php 
	session_start();
	require_once	'config/db.php';

	if(isset($_SESSION['sesion_aprenDigital'])){
		$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
	
		$sql ="UPDATE usuarios set estado_login = 'desconectado', fechamodificacion = NOW() WHERE id = $usuario_id";
		$estadoLogin = mysqli_query($db, $sql);

		session_destroy();
	}
	header('Location: index.php');
 ?>