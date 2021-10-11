<?php 

  if(isset($_POST)){
		require_once('../../config/db.php');		
	
		if(!isset($_SESSION)){
				session_start();
		}
				
		$curso_id = isset($_POST['id']) ? $_POST['id'] : false; 
		$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
	
		$video_nombre = $_FILES['video']['name'];
    $video_tipo = $_FILES['video']['type'];
		$url_video = isset($_POST['url_video']) ? $_POST['url_video'] : false;

		$archivo_nombre = $_FILES['archivo']['name'];
    $descripcion_archivo = isset($_POST['descripcion_archivo']) ? $_POST['descripcion_archivo'] : null;

		$url_articulo = isset($_POST['url_articulo']) ? $_POST['url_articulo'] : false; 
		$nombre_articulo = isset($_POST['nombre_articulo']) ? $_POST['nombre_articulo'] : '';
		$descripcion_articulo = isset($_POST['descripcion_articulo']) ? $_POST['descripcion_articulo'] : '';

    $etiquetas = $_POST['etiquetas'];
		
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

		/*
    $multiEtiquetas = null;
    $num_array1 = count($etiquetas);
    $contador1 = 0;

		if($num_array1 > 0){
			foreach($etiquetas as $key1 => $value){
				if($contador1 !=  $num_array1 - 1){
					$multiEtiquetas .= $value . ', ';
				}else{
					$multiEtiquetas = $value;
					$contador1++;
				}
			}
		}
		*/
		if($video_nombre || $archivo_nombre ){
			echo "video o archivo <br>";
			echo "video " . $video_nombre . ' '. $video_tipo. '' .$_FILES['video']['tmp_name']. "<br>";	

			if($video_nombre){
				$carpeta = $curso_id;
				//$ruta = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/cursos/';
				$ruta = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/cursos/';

				if(!is_dir($carpeta)){
					mkdir($ruta.$carpeta, 0777, true);
				}
				//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/cursos/'.$carpeta.'/';	
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/cursos/'.$carpeta.'/';
				move_uploaded_file($_FILES['video']['tmp_name'], $carpeta_destino.$video_nombre);
			}

			if($archivo_nombre){
				$carpeta = $curso_id;

				foreach($_FILES['archivo']['tmp_name'] as $key => $tmp_name){

					if($_FILES['archivo']['name'][$key]){
						$filename = $_FILES['archivo']['name'][$key];
						$temporal = $_FILES['archivo']['tmp_name'][$key];
						echo "filename " . $filename . '<br>';

						//$ruta = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/cursos/';
						$ruta = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/cursos/';

						//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/cursos/'.$carpeta.'/';	
						$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/cursos/'.$carpeta.'/';

						if(!is_dir($carpeta)){
							mkdir($ruta.$carpeta, 0777, true);
						}

						if(move_uploaded_file($temporal, $carpeta_destino)){
							echo "subidos";
						}
					}
				}		
				
			}

      $sql="INSERT INTO cursos_contenido_detalle (curso_id, nombre, descripcion, video, url_video, archivo, descripcion_archivo, url_articulo, nombre_articulo, descripcion_articulo, etiquetas, carpera, fechacreacion, usuario, estado_id) VALUES ($curso_id, '$nombre', '$descripcion', '$video_nombre', '$url_video', '$filename','$descripcion_archivo', '$url_articulo', '$nombre_articulo', '$descripcion_articulo', '$etiquetas', '$carpeta', CURDATE(), '$usuario', 1);";
			$resul = mysqli_query($db,$sql);

      var_dump($sql);
      //die();
					
				if(mysqli_affected_rows($db)>0){
					$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
				}else{
					$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";			
				}
				header("Location: ../../admin-cursos.php");      
				
		}else {					
			echo "else sin nada";
			//die();
			
      $sql="INSERT INTO cursos_contenido_detalle (curso_id, nombre, descripcion,  url_video, descripcion_archivo, url_articulo, nombre_articulo, descripcion_articulo, etiquetas, carpeta, fechacreacion, usuario, estado_id) VALUES ($curso_id, '$nombre', '$descripcion', '$url_video', '$descripcion_archivo', '$url_articulo', '$nombre_articulo', '$descripcion_articulo', '$etiquetas', '$carpeta', CURDATE(), '$usuario', 1);";
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
			