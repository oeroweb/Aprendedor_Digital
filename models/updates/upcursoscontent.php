<?php 

  if(isset($_POST)){
		require_once('../../config/db.php');
	
		if(!isset($_SESSION)){
			session_start();
		}

		$id = $_POST['id'];		
		$nombre = $_POST['nombre'];		
		$descripcion = $_POST['descripcion'];		
		$orden = $_POST['orden'];
				
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

		$sql= "UPDATE cursos_contenido SET nombre = '$nombre', descripcion = '$descripcion', orden = $orden, fechamodificacion = NOW(), usuario = '$usuario' where id = $id";	
		
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
			