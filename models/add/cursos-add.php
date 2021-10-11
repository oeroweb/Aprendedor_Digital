<?php 

  if(isset($_POST)){
		require_once('../../config/db.php');		
	
		if(!isset($_SESSION)){
				session_start();
		}
				
		$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false; 
		$orden = isset($_POST['orden']) ? $_POST['orden'] : null; 
		$fase = isset($_POST['fase']) ? $_POST['fase'] : false; 
		$nombre_imagen = $_FILES['imagen']['name'];
		$tipo_imagen = $_FILES['imagen']['type'];
		$tamano_imagen = $_FILES['imagen']['size'];		
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

		
			if($nombre_imagen){
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/img/cursos/';	
				//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/img/cursos/';

				move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino.$nombre_imagen);

				$sql="INSERT INTO cursos (nombre, descripcion, fase_id, orden, imagen, fechacreacion, usuario, estado_id) VALUES ('$nombre', '$descripcion', $fase, $orden, '$nombre_imagen', CURDATE(), '$usuario', 1);";
				$resul = mysqli_query($db,$sql);
       	
					if(mysqli_affected_rows($db)>0){
						$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
					}else{
						$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";					
					}
					header("Location: ../../admin-cursos.php");
			}else {					
					$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> Error esto no es una imagen, vuele a probar";
			}	
			header("Location: ../../admin-cursos.php");				
							
		}else{
		$_SESSION['errores_usuario'] = $errores;
		header("Location: ../../admin-cursos.php");
			
	}
?>
			