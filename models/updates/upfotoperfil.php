<?php 

  if(isset($_POST)){
		require_once '../../config/db.php';
	
		if(!isset($_SESSION)){
				session_start();
		}
		$id= $_SESSION['sesion_aprenDigital']['id'];
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].$_SESSION['sesion_aprenDigital']['ape_paterno'];	
		$nombre_imagen = $_FILES['foto']['name'];
		$tipo_imagen = $_FILES['foto']['type'];
		$tamano_imagen = $_FILES['foto']['size'];		
		
		//echo $nombre_imagen. ' ' . $tipo_imagen."<br>";
				 
		if($tamano_imagen <=2000000){
			if($tipo_imagen=="image/jpeg" || $tipo_imagen=="image/jpg" || $tipo_imagen=="image/png" || $tipo_imagen=="image/gif"){

				$carpeta= $id.$usuario;
				$ruta = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/files/';	
				//$ruta = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/files/';				

				if(!is_dir($carpeta)){
					mkdir($ruta.$carpeta, 0777, true);
					//mkdir($ruta.$carpeta);
				}
				
				$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/files/'.$carpeta.'/';	
				//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/files/'.$carpeta.'/';
										
				move_uploaded_file($_FILES['foto']['tmp_name'], $carpeta_destino.$nombre_imagen);

				$sql="UPDATE usuarios SET imagen='$nombre_imagen', carpeta_img = '$carpeta' WHERE id = $id;";
				$resul = mysqli_query($db,$sql);
					
					if(mysqli_affected_rows($db)>0){
						$_SESSION['completado'] = "<i class='far fa-check-circle'></i> La foto subio de forma exitosa"; 
					}else{
						$_SESSION['fallo'] = '<i class="far fa-times-circle"></i> No se completo la carga; por favor volver a intentar';
					}
					header("Location: ../../perfil-edit.php");	
				}else {
						$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> Esto no es una imagen, por favor verificar y vuelva a intentar.";
				}	
				header("Location: ../../perfil-edit.php");	
			} else {
				$_SESSION['fallo'] = '<i class="far fa-times-circle"></i> La foto es demasiado grande, el tamaño maximo permitdo es 1 MB; por favor vuelva a intentar.';
			}	
			header("Location: ../../perfil-edit.php");	
			 		
 	}else{
 		$_SESSION['errores_usuario'] = $errores;
 		header("Location: ../../perfil-edit.php");	
  }
?>