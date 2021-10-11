<?php 

  if(isset($_POST)){
		require_once('../../config/db.php');
	
		if(!isset($_SESSION)){
			session_start();
		}

		$id = $_POST['id'];		
		$nombre = $_POST['nombre'];		
		$pais = $_POST['pais'];		
		$localidad = $_POST['localidad'];		
		$direccion = $_POST['direccion'];		
				
		$usuario = $_SESSION['usuario']['nombre'].' '.$_SESSION['usuario']['apePaterno'];	

		$sql= "UPDATE instituciones SET nombre = '$nombre', pais = '$pais', localidad = '$localidad', direccion = '$direccion', fechamodificacion = NOW(), usuario = '$usuario' where id = $id";	
		
		$resultado = mysqli_query($db,$sql);	

		if($resultado){
			$_SESSION['completado'] = "El registro se modificó de forma exitosa";
			header("Location: ../../admin-instituciones.php");
		} else{
			$_SESSION['fallo'] = "Error no se completo la carga; por favor volver a intentar";
			header("Location: ../../admin-instituciones.php");
		}
	}
?>
			