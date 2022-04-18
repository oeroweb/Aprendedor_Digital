<?php 
	session_set_cookie_params(60*60*24*2);
	session_start();
	date_default_timezone_set('America/Lima');
	$ahora = date('d-m-Y h:i:s a');

	// recoger datos del formulario
	if(isset($_POST['submit'])){	
		require_once '../config/db.php';		

		if(isset($_SESSION['error_login'])){
			session_unset($_SESSION['error_login']);
		}

		$email = trim(mysqli_real_escape_string($db, $_POST['email'])); 
		$password = mysqli_real_escape_string($db, $_POST['password']);
		
		//consultar las credenciales del usuarios
		$sql ="SELECT * FROM usuarios WHERE email = '$email'";
		$login = mysqli_query($db, $sql); 

		if($login && mysqli_num_rows($login) == 1){
			$usuario = mysqli_fetch_assoc($login);
			
			// comprobar la contaseña
			$verify = password_verify($password, $usuario['clave']);

			if($verify){
				$_SESSION['sesion_aprenDigital'] = $usuario;
				$usuario_id = $usuario['id'];				
				$sql2 ="UPDATE usuarios set estado_login = 'conectado', fechamodificacion = NOW(), ultimasesion = '$ahora' WHERE id = $usuario_id";
				$estadoLogin = mysqli_query($db, $sql2);
				header("Location: ../dashboard.php");				
			}else{								
				$_SESSION['error_login'] = "La contraseña es incorrecta!";		
				header('Location:../index.php');    
			}
		}else{
			//mensaje de error
			$_SESSION['error_login'] = "El correo ingresado no está regristrado!";		
			header('Location:../index.php');
		}	
	}
?>