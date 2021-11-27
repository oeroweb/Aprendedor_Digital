<?php 

  if(isset($_POST)){
		require_once('../../config/db.php');		
	
		if(!isset($_SESSION)){
				session_start();
		}
				
		$contenido_id = isset($_POST['id']) ? $_POST['id'] : false; 
		$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
	
		$video_nombre = isset($_FILES['video']['name']) ? $_FILES['video']['name'] : null;
		$url_video = isset($_POST['url_video']) ? $_POST['url_video'] : false;

		$archivo_nombre = isset($_FILES['archivo']['name']) ? $_FILES['archivo']['name'] : null;
    $descripcion_archivo = isset($_POST['descripcion_archivo']) ? $_POST['descripcion_archivo'] : null;

		$url_articulo = isset($_POST['url_articulo']) ? $_POST['url_articulo'] : false; 
		$nombre_articulo = isset($_POST['nombre_articulo']) ? $_POST['nombre_articulo'] : '';
		$descripcion_articulo = isset($_POST['descripcion_articulo']) ? $_POST['descripcion_articulo'] : '';
    $etiquetas = isset($_POST['etiquetas']) ? $_POST['etiquetas'] : false;
		$orden = isset($_POST['orden']) ? $_POST['orden'] : null;
		$t = time();
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

		
		if( $video_nombre or $archivo_nombre ){

			$carpeta = $contenido_id;
			$ruta = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/cursos/';
			//$ruta = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/cursos/';

			if(!is_dir($carpeta)){
				mkdir($ruta.$carpeta, 0777);
			}

			if($video_nombre){
				
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/cursos/'.$carpeta.'/';	
				//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/cursos/'.$carpeta.'/';
				move_uploaded_file($_FILES['video']['tmp_name'], $carpeta_destino.$video_nombre);
			}

			if($archivo_nombre){			

				foreach($_FILES['archivo']['tmp_name'] as $key => $tmp_name){

					if($_FILES['archivo']['name'][$key]){
						$filename = $_FILES['archivo']['name'][$key];
						$temporal = $_FILES['archivo']['tmp_name'][$key];						

						$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/cursos/'.$carpeta.'/';	
						//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/cursos/'.$carpeta.'/';
						
						move_uploaded_file($temporal, $carpeta_destino.$filename);					
					}
				}
				
				$multiArchivos = null;
    		$num_array = count($archivo_nombre);
    		$contador = 0;
				if($num_array > 0){
					foreach($archivo_nombre as $key => $value){
						if($contador !=  $num_array - 1){
							$multiArchivos .= $value . ', ';
						}else{
							$multiArchivos = $value. ' ';
							$contador++;
						}
					}
				}
				
			}

      $sql="INSERT INTO cursos_contenido_detalle (cursoContenido_id, nombre, descripcion, video, url_video, archivos, descripcion_archivo, url_articulo, nombre_articulo, descripcion_articulo, etiquetas, orden, carpeta, fechacreacion, usuario, estado_id) VALUES ($contenido_id, '$nombre', '$descripcion', '$video_nombre', '$url_video', '".substr($multiArchivos,0,-2)."','$descripcion_archivo', '$url_articulo', '$nombre_articulo', '$descripcion_articulo', '$etiquetas','$orden', '$carpeta', CURDATE(), '$usuario', 1);";
			$resul = mysqli_query($db,$sql);
					
				if(mysqli_affected_rows($db)>0){
					$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
				}else{
					$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";			
				}
				header("Location: ../../admin-cursos.php");  
				
		}else {						
      $sql="INSERT INTO cursos_contenido_detalle (cursoContenido_id, nombre, descripcion,  url_video, descripcion_archivo, url_articulo, nombre_articulo, descripcion_articulo, etiquetas, orden, carpeta, fechacreacion, usuario, estado_id) VALUES ($contenido_id, '$nombre', '$descripcion', '$url_video', '$descripcion_archivo', '$url_articulo', '$nombre_articulo', '$descripcion_articulo', '$etiquetas', '$orden', '$carpeta', CURDATE(), '$usuario', 1);";
			$resul = mysqli_query($db,$sql);
					
				if(mysqli_affected_rows($db)>0){
						$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
				}else{
						$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";					
				}
					header("Location: ../../admin-cursos.php");
				
			} 
			header("Location: ../../admin-cursos.php");			
	}else{
		$_SESSION['errores_usuario'] = $errores;
		header("Location: ../../admin-cursos.php");			
	}
?>
			