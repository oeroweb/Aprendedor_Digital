<?php 

  if(isset($_POST)){
		require_once '../../config/db.php';
	
		if(!isset($_SESSION)){
				session_start();
		}
		
		$id= $_SESSION['sesion_aprenDigital']['id'];
		$institucion = isset($_POST['institucion']) ? $_POST['institucion'] : false;
		$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
		$apePaterno = isset($_POST['apepaterno']) ? mysqli_real_escape_string($db,$_POST['apepaterno']) : false;
		$apeMaterno = isset($_POST['apematerno']) ? mysqli_real_escape_string($db,$_POST['apematerno']) : false;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false; 		
		$docident= isset($_POST['docident']) ? $_POST['docident'] : false;
		$sexo= isset($_POST['sexo']) ? $_POST['sexo'] : false;
		$edad= isset($_POST['edad']) ? $_POST['edad'] : false;
		$cargo= isset($_POST['cargo']) ? $_POST['cargo'] : false;
		$nickname= isset($_POST['nickname']) ? $_POST['nickname'] : false;
		$fecnac = isset($_POST['fecnac']) ? $_POST['fecnac'] : false;
		$celular = isset($_POST['celular']) ? $_POST['celular'] : false;
		$clave = isset($_POST['clave']) ? $_POST['clave'] : false;
		$proposito = isset($_POST['proposito']) ? $_POST['proposito'] : false;
		$interes = isset($_POST['interes']) ? $_POST['interes'] : false;
		$profesion= isset($_POST['profesion']) ? $_POST['profesion'] : false;
		$profesional = isset($_POST['profesional']) ? $_POST['profesional'] : false; 		
		$cursos= isset($_POST['cursos']) ? $_POST['cursos'] : false;
		$nicho = isset($_POST['nicho']) ? $_POST['nicho'] : false;
		$redes_facebook = isset($_POST['redes_facebook']) ? $_POST['redes_facebook'] : false;
		$redes_instagran = isset($_POST['redes_instagran']) ? $_POST['redes_instagran'] : false;
		$redes_linkedin = isset($_POST['redes_linkedin']) ? $_POST['redes_linkedin'] : false;
		$pais= isset($_POST['pais']) ? $_POST['pais'] : false;
		$nacionalidad= isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : false;
		$localidad= isset($_POST['localidad']) ? $_POST['localidad'] : false;
		$direccion= isset($_POST['direccion']) ? $_POST['direccion'] : false;
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].$_SESSION['sesion_aprenDigital']['ape_paterno'];
		
		$documento= isset($_POST['documento']) ? $_POST['documento'] : false;
		$nombre_archivo = $_FILES['archivo']['name'];
		$tipo_archivo = $_FILES['archivo']['type'];
		$tamano_archivo = $_FILES['archivo']['size'];	

  	$errores = array(); 

		if(!empty($nombre) && !is_numeric($nombre)){
			$nombre_validado = true;
		}else{
			$nombre_validado = false;
			$errores['nombre'] = "El nombre ingresado no es correcto!";
		}

		if(!empty($apePaterno) && !is_numeric($apePaterno) ){
			$apellidosp_validado = true;
		}else{
			$apellidosp_validado = false;
			$errores['apepaterno'] = "El apellidos ingresado no es correcto!";
		}

		if(!empty($apeMaterno) && !is_numeric($apeMaterno) ){
			$apellidosm_validado = true;
		}else{
			$apellidosm_validado = false;
			$errores['apematerno'] = "El apellido ingresado no es correcto!";
		}
		
		if(!empty($docident)){
			$dni_validado = true;
		}else{
			$dni_validado = false;
			$errores['dni'] = "Tienes que ingresar tu número de documento de identidad";
		}

		if(!empty($fecnac)){
			$fecnac_validado = true;
		}else{
			$fecnac_validado = false;
			$errores['fecnac'] = "Tienes que ingresar tu fecha de nacimiento";
		}

		if(!empty($pais)){
			$pais_validado = true;
		}else{
			$pais_validado = false;
			$errores['pais'] = "Tienes que ingresar el Pais de Residencia";
		}

 		$guardar_usuario = false;
 	
		if(count($errores) == 0 ){

			$guardar_usuario = true;
			$carpeta= $nombre.$apePaterno.$apeMaterno;

			$ruta = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/files/';			
			//$ruta = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/files/';

			if(!is_dir($carpeta)){
				mkdir($ruta.$carpeta, 0777, true);
				//mkdir($ruta.$carpeta);
			}
			
			$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/files/'.$carpeta.'/';	
			//$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/files/'.$carpeta.'/';
				
			move_uploaded_file($_FILES['archivo']['tmp_name'], $carpeta_destino.$nombre_archivo);

			$password_segura = password_hash($clave, PASSWORD_BCRYPT,['cost' =>4]);

			$subir_archivo = "";

			if($nombre_archivo){
				$subir_archivo = $nombre_archivo;
			}else{
				$subir_archivo = $documento;
			}
			
			
			$sql="UPDATE usuarios SET institucion_id=$institucion, nombre='$nombre', ape_paterno='$apePaterno', ape_materno='$apeMaterno', nickname='$nickname',doc_identidad=$docident, sexo_id= $sexo, fec_nacimiento='$fecnac', edad=$edad, celular='$celular', cargo='$cargo', descripcion='$descripcion', proposito='$proposito', interes='$interes', profesion='$profesion', nivel_profesional='$profesional', nicho_mercado='$nicho', redes_facebook='$redes_facebook', redes_instagran='$redes_instagran', redes_linkedin='$redes_linkedin', pais='$pais', nacionalidad='$nacionalidad', localidad='$localidad', direccion= '$direccion', fechamodificacion=NOW(), usuario='$usuario', carpeta = '$carpeta', archivo='$subir_archivo' WHERE id = $id";

			$guardar = mysqli_query($db,$sql);	
					
			if($guardar){
				$_SESSION['completado'] = "<i class='far fa-check-circle'></i> Los datos se actualizarón exitosamente"; 
			}else{
				$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo el registro";
			}
			
			header("Location: ../../perfil-edit.php");			

 	}else{
 		$_SESSION['errores'] = $errores;		
 		header("Location: ../../perfil-edit.php");
  }
}

?>