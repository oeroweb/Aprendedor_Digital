<?php 

  if(isset($_POST)){
		require_once '../../config/db.php';
	
		if(!isset($_SESSION)){
				session_start();
		}
		$id= $_POST['id'];
		$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false; 
		$fase = isset($_POST['fase']) ? $_POST['fase'] : false; 
		$url = isset($_POST['linkurl']) ? $_POST['linkurl'] : false; 
		$imagen_existente = isset($_POST['imagen_existente']) ? $_POST['imagen_existente'] : false; 
		$video_existente = isset($_POST['video_existente']) ? $_POST['video_existente'] : false; 
		$orden = isset($_POST['orden']) ? $_POST['orden'] : false;

		$nombre_imagen = $_FILES['imagen']['name'];
		$tipo_imagen = $_FILES['imagen']['type'];

		$nombre_video = $_FILES['video']['name'];
		$tipo_video = $_FILES['video']['type'];

		$tamano_video = $_FILES['video']['size'];		
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];	
		
		$subir_video = "";
		if($nombre_video){
			$subir_video = $nombre_video;
		}else{
			$subir_video = $video_existente;
		}

		$subir_imagen = "";
		if($nombre_imagen){
			$subir_imagen = $nombre_imagen;
		}else{
			$subir_imagen = $imagen_existente;
		}				
				 
		
		if($nombre_video or $nombre_imagen){

			$carpeta = $fase;
			//$ruta = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/clases/';
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
				//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/clases/'.$carpeta.'/';	
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/clases/'.$carpeta.'/';
				move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino.$nombre_imagen);
			}
									
			move_uploaded_file($_FILES['video']['tmp_name'], $carpeta_destino.$nombre_video);

			$sql="UPDATE clases SET fase_id='$fase', nombre='$nombre', descripcion='$descripcion', video='$subir_video', imagen='$subir_imagen', url='$url', carpeta='$carpeta', orden='$orden', fechamodificacion=NOW(), usuario='$usuario' WHERE id = $id;";
			$resul = mysqli_query($db,$sql);
				
				if(mysqli_affected_rows($db)>0){
					$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se modifico de forma exitosa"; 
				}else{
					$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";
				}
				header("Location: ../../admin-clases-maestras.php");	
		}else {
			$sql="UPDATE clases SET fase_id='$fase', nombre='$nombre', descripcion='$descripcion', url='$url',orden='$orden', fechamodificacion=NOW(), usuario='$usuario' WHERE id = $id;";

			$resul = mysqli_query($db,$sql);

			$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se modifico de forma exitosa"; 
		}	
		
		header("Location: ../../admin-clases-maestras.php");		
			 		
 	}else{
 		$_SESSION['errores_usuario'] = $errores;
 		header("Location: ../../admin-clases-maestras.php");
  }
?>