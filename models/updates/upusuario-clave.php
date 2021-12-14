<?php 
		session_start();
		require_once '../../config/db.php';
				
		$id= isset($_POST['id']) ? $_POST['id'] : false;		
		$clave = isset($_POST['clave']) ? $_POST['clave'] : false;	
		
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].$_SESSION['sesion_aprenDigital']['ape_paterno'];
		
		$password_segura = password_hash($clave, PASSWORD_BCRYPT,['cost' =>4]);

		$sql="UPDATE usuarios SET clave='$password_segura', fechamodificacion=NOW(), usuario='$usuario' WHERE id = $id";

		$resultado = mysqli_query($db,$sql);
        
		if($resultado){
			$_SESSION['completado'] = "<i class='far fa-check-circle'></i> Tu clave se cambio de forma segura"; 
			header("Location: ../../contrasenna-segura.php");
		}else{
			$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> Hubo un error, por favor vuelve a intentar";
			header("Location: ../../contrasenna-segura.php");	
		}
  
?>