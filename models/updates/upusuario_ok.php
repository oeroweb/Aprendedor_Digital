<?php 
  
		session_start();
		require_once '../../config/db.php';

		$id= $_POST['id'];
		$institucion = $_POST['institucion'];
		$nombre = $_POST['nombre'];
		$apePaterno = $_POST['apepaterno'];
		$apeMaterno = $_POST['apematerno'];				
		$docident= $_POST['docidentidad'];
		$sexo= $_POST['sexo'];
		$perfil= $_POST['perfil'];
		$clave = $_POST['clave'];	
		
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].$_SESSION['sesion_aprenDigital']['ape_paterno'];
		
		$password_segura = password_hash($clave, PASSWORD_BCRYPT,['cost' =>4]);

		$sql="UPDATE usuarios SET institucion_id=$institucion, nombre='$nombre', ape_paterno='$apePaterno', ape_materno='$apeMaterno', doc_identidad=$docident, sexo_id= $sexo, perfil_id='$perfil', clave='$password_segura', fechamodificacion=NOW(), usuario='$usuario' WHERE id = $id";

		//var_dump($sql); //die();

		$resultado = mysqli_query($db,$sql);
        
		if($resultado){
			echo json_encode(array('error' => false));
		}else{
			echo json_encode(array('error' => true));
		}
  
?>