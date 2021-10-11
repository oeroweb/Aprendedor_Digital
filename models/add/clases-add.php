<?php 

  if(isset($_POST)){
		require_once('../../config/db.php');		
	
		if(!isset($_SESSION)){
				session_start();
		}
				
		$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false; 
		$url = isset($_POST['url']) ? $_POST['url'] : null; 
		$fase = isset($_POST['fase']) ? $_POST['fase'] : false; 
		$orden = isset($_POST['orden']) ? $_POST['orden'] : null; 

		$nombre_imagen = $_FILES['imagen']['name'];
		$tipo_imagen = $_FILES['imagen']['type'];

		$nombre_archivo = $_FILES['video']['name'];
		$tipo_archivo = $_FILES['video']['type'];

    $tamano_archivo = $_FILES['video']['size'];
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];
	
		if($nombre_archivo or $nombre_imagen){			
			
			$carpeta = $fase;
			//$ruta = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/cursos/';
			$ruta = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/clases/';

			if(!is_dir($carpeta)){
				mkdir($ruta.$carpeta, 0777);
			}

			if($nombre_archivo){
				//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/videos/clases/';				
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/videos/clases/';
	
				move_uploaded_file($_FILES['video']['tmp_name'], $carpeta_destino.$nombre_archivo);
			}

			if($nombre_imagen){				
				//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/cursos/'.$carpeta.'/';	
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/clases/'.$carpeta.'/';
				move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino.$nombre_imagen);
			}

				
				$sql="INSERT INTO clases (nombre, descripcion, fase_id, url, video, imagen, carpeta, orden, fechacreacion, usuario, estado_id) VALUES ('$nombre', '$descripcion', $fase, '$url', '$nombre_archivo','$nombre_imagen', '$carpeta','$orden', CURDATE(), '$usuario', 1);";
				$resul = mysqli_query($db,$sql);				
				
					if(mysqli_affected_rows($db)>0){
						$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
					}else{
						$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";	
					}
					header("Location: ../../admin-cursos-maestras.php");	
				
				header("Location: ../../admin-cursos-maestras.php");	
				
			} else {	
				
				$sql="INSERT INTO clases (nombre, descripcion, fase_id, url, orden, fechacreacion, usuario, estado_id) VALUES ('$nombre', '$descripcion', $fase, '$url','$orden', CURDATE(), '$usuario', 1);";
				$resul = mysqli_query($db,$sql);
			
				if(mysqli_affected_rows($db)>0){
					$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
				}else{
					$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";	
				}
				header("Location: ../../admin-cursos-maestras.php");
								
			}	
			header("Location: ../../admin-cursos-maestras.php");					
	}else{
		$_SESSION['errores_usuario'] = $errores;
		header("Location: ../../admin-cursos-maestras.php");	
			
	}
?>
			