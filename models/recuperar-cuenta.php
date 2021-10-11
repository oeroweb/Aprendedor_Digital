<?php 
	
	if(isset($_POST['submit'])){	
    require_once '../config/db.php';
    
		if(!isset($_SESSION)){
			session_start();
		}

		$email = trim($_POST['email']); 		
		//consultar las credenciales del usuarios
		$sql ="SELECT * FROM usuarios WHERE email = '$email'";
		$cuenta = mysqli_query($db, $sql); 

		if($cuenta && mysqli_num_rows($cuenta) == 1){
      
      $_SESSION['recupera_cuenta'] = "Se envío un correo a tu cuenta " . $email. " para restablecer la clave";

      header("Location:../recuperar-cuenta.php");
      
		}else{
      $_SESSION['error_cuenta'] = "La cuenta ingresada no es validad!";		
      header("Location:../recuperar-cuenta.php");
		}	
  }
  header("Location:../recuperar-cuenta.php");
?>