<?php 
	// recoger datos del formulario
	if(isset($_POST['submit'])){	
		require_once '../config/db.php';
		if(!isset($_SESSION)){
			session_start();
		}	

		// recoger datos del formulario
		$email = trim($_POST['email']); 
		$password = $_POST['password'];
		
		//consultar las credenciales del usuarios
		$sql ="SELECT * FROM usuarios WHERE email = '$email'";
		$login = mysqli_query($db, $sql); 

		if($login && mysqli_num_rows($login) == 1){
			$usuario = mysqli_fetch_assoc($login);
			
			// comprobar la contaseña
			$verify = password_verify($password, $usuario['password']);

			if($verify){
				$_SESSION['usuario'] = $usuario;				
				header('Location:../contenedor.php');
			}else{
				//si algo falla enviar session de fallo
				//echo "clave incorrecta";
				$_SESSION['error_login'] = "La contraseña es incorrecta!";
				
				header('Location:../index.php');    
			}
		}else{
			//mensaje de error
			$_SESSION['error_login'] = "El correo ingresado no esta regristrado!, solicita tu cuenta en el enlace inferior o <a href='solicitar-cuenta.php'>Solicitar Cuenta</a>";
			// var_dump($_SESSION['error_login']);
			// die();
			header('Location:../index.php');
		}	
	}
?>