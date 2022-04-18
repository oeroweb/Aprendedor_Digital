<?php 
	session_start();
	require_once	'config/db.php';
	date_default_timezone_set('America/Lima');
	$ahora = date('d-m-Y h:i:s a');

	if(isset($_SESSION['sesion_aprenDigital'])){
		$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
	
		$sql ="UPDATE usuarios set estado_login = 'desconectado', fechamodificacion = NOW(), ultimasesion = '$ahora' WHERE id = $usuario_id";
		$estadoLogin = mysqli_query($db, $sql);

		session_destroy();
	}
	header('Location: index.php');
	
 ?>
