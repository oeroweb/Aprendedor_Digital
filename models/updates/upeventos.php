<?php 

  if(isset($_POST)){
		require_once '../../config/db.php';
	
		if(!isset($_SESSION)){
				session_start();
		}

		$id = isset($_POST['id']) ? $_POST['id'] : false; 
		$carpeta = isset($_POST['carpeta']) ? $_POST['carpeta'] : false; 
		$grupo_id = isset($_POST['grupo_id']) ? $_POST['grupo_id'] : false; 
		$fechaevento = isset($_POST['fechaevento']) ? $_POST['fechaevento'] : false; 
		$titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($db,$_POST['titulo']) : false;
		$texto = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;		
		$link = isset($_POST['link']) ? $_POST['link'] : false; 
		$imagenActual = isset($_POST['imagenActual']) ? $_POST['imagenActual'] : false; 
		$archivosActual = isset($_POST['archivosActual']) ? $_POST['archivosActual'] : false; 

		$imagen_nombre = isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : null;
		$archivo_nombre = isset($_FILES['archivo']['name']) ? $_FILES['archivo']['name'] : null;	
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];	
		
		if( $imagen_nombre or $archivo_nombre ){		

			//$ruta = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/eventos/';
			$ruta = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/eventos/';

			if(!is_dir($carpeta)){
				mkdir($ruta.$carpeta, 0777);
			}
			
			if($imagen_nombre){
				//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/eventos/'.$carpeta.'/';	
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/eventos/'.$carpeta.'/';			
										
				move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino.$imagen_nombre);
			}

			if($archivo_nombre){
				foreach($_FILES['archivo']['tmp_name'] as $key => $tmp_name){

					if($_FILES['archivo']['name'][$key]){
						$filename = $_FILES['archivo']['name'][$key];
						$temporal = $_FILES['archivo']['tmp_name'][$key];						

						//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/eventos/'.$carpeta.'/';	
						$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/eventos/'.$carpeta.'/';
						
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

			if($imagen_nombre){
				$ingresar_imagen = $imagen_nombre;
			}else{
				$ingresar_imagen = $imagenActual;
			}

			if($multiArchivos){
				$ingresar_archivo = substr($multiArchivos,0,-2);
			}else{
				$ingresar_archivo = $archivosActual;
			}
			
			//echo 'ingresar'. $ingresar_archivo;	die();
			
			$sql="UPDATE eventos SET grupo_id='$grupo_id', titulo='$titulo', texto='$texto', link='$link',fechaevento='$fechaevento', archivos='$ingresar_archivo', imagen='$ingresar_imagen', fechamodificacion=NOW(), usuario='$usuario' WHERE id = $id;";
			
				$resul = mysqli_query($db,$sql);			
					
				if(mysqli_affected_rows($db)>0){
					$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se modifico de forma exitosa"; 
				}else{
					$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";
				}
				header("Location: ../../setting.php");

		}else {
			
			$sql="UPDATE eventos SET grupo_id='$grupo_id', titulo='$titulo', texto='$texto', link='$link',fechaevento='$fechaevento', fechamodificacion=NOW(), usuario='$usuario' WHERE id = $id;";
			
			$resul = mysqli_query($db,$sql);

			$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se modifico de forma exitosa"; 
		}	
		header("Location: ../../setting.php");			
			 		
 	}else{ 		
 		header("Location: ../../setting.php");	
  }
?>