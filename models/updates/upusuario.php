<?php 
		session_start();
		require_once '../../config/db.php';
				
		$id= isset($_POST['id']) ? $_POST['id'] : false;
		$institucion = isset($_POST['institucion']) ? $_POST['institucion'] : false;
		$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
		$apePaterno = isset($_POST['apepaterno']) ? mysqli_real_escape_string($db,$_POST['apepaterno']) : false;
		$apeMaterno = isset($_POST['apematerno']) ? mysqli_real_escape_string($db,$_POST['apematerno']) : false;				
		$docident= isset($_POST['docidentidad']) ? $_POST['docidentidad'] : false;
		$celular= isset($_POST['celular']) ? $_POST['celular'] : false;
		$sexo= isset($_POST['sexo']) ? $_POST['sexo'] : false;
		$perfil= isset($_POST['perfil']) ? $_POST['perfil'] : false;
		$clave = isset($_POST['clave']) ? $_POST['clave'] : false;	
		$claveActual = isset($_POST['clave-actual']) ? $_POST['clave-actual'] : false;	
		
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].$_SESSION['sesion_aprenDigital']['ape_paterno'];
		
		$password_segura = password_hash($clave, PASSWORD_BCRYPT,['cost' =>4]);

		if($clave){
			$clave_ingreso = $password_segura;
		}else{
			$clave_ingreso = $claveActual;
		}

		$sql="UPDATE usuarios SET institucion_id=$institucion, nombre='$nombre', ape_paterno='$apePaterno', ape_materno='$apeMaterno', doc_identidad=$docident, celular='$celular', sexo_id= $sexo, perfil_id='$perfil', clave='$clave_ingreso', fechamodificacion=NOW(), usuario='$usuario' WHERE id = $id";

		$resultado = mysqli_query($db,$sql);
        
		if($resultado){
			echo json_encode(array('error' => false));
		}else{
			echo json_encode(array('error' => true));
		}
  
?>