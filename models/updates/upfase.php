<?php 

  if(isset($_POST)){
		require_once('../../config/db.php');
	
		if(!isset($_SESSION)){
			session_start();
		}

		$id = $_POST['id'];		
		$nombre = $_POST['nombre'];		
		$descripcion = $_POST['descripcion'];			
				
		$usuario = $_SESSION['usuario']['nombre'].' '.$_SESSION['usuario']['apePaterno'];	

		$sql= "UPDATE fases SET nombre = '$nombre', descripcion = '$descripcion',
		fechamodificacion = NOW(), usuario = '$usuario' where id = $id";	
		
		$resultado = mysqli_query($db,$sql);	

		if($resultado){
			$_SESSION['completado'] = "El registro se modificó de forma exitosa";
			header("Location: ../../admin-cursos.php");
		} else{
			$_SESSION['fallo'] = "Error no se completo la carga; por favor volver a intentar";
			header("Location: ../../admin-cursos.php");
		}
	}
?>
			