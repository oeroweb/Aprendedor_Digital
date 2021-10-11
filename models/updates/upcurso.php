<?php 

  if(isset($_POST)){
		require_once '../../config/db.php';
	
		if(!isset($_SESSION)){
				session_start();
		}
		$id= $_POST['id'];
		$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false; 
		$orden = isset($_POST['orden']) ? $_POST['orden'] : false; 
		$fase = isset($_POST['fase']) ? $_POST['fase'] : false; 
		$nombre_imagen = $_FILES['foto']['name'];
		$tipo_imagen = $_FILES['foto']['type'];
		$tamano_imagen = $_FILES['foto']['size'];		
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];	
		
		//echo $_FILES['foto']['tmp_name'];
		//die();
		
			if($nombre_imagen){
				//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/img/cursos/';	
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/img/cursos/';				
										
				move_uploaded_file($_FILES['foto']['tmp_name'], $carpeta_destino.$nombre_imagen);

				$sql="UPDATE cursos SET fase_id='$fase', nombre='$nombre', descripcion='$descripcion', orden='$orden',  fechamodificacion=NOW(), usuario='$usuario', imagen='$nombre_imagen' WHERE id = $id;";
				$resul = mysqli_query($db,$sql);				
			
					
					if(mysqli_affected_rows($db)>0){
						$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se modifico de forma exitosa"; 
					}else{
						$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";
					}
					header("Location: ../../admin-cursos.php");	
				}else {
					
					$sql="UPDATE cursos SET fase_id='$fase', nombre='$nombre', descripcion='$descripcion', orden='$orden',fechamodificacion=NOW(), usuario='$usuario' WHERE id = $id;";
					
					$resul = mysqli_query($db,$sql);

					$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se modifico de forma exitosa"; 
				}	
				header("Location: ../../admin-cursos.php");			
			 		
 	}else{ 		
 		header("Location: ../../admin-cursos.php");	
  }
?>