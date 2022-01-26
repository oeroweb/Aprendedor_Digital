<?php 
	
	if(isset($_POST['submit'])){	
    require_once '../config/db.php';
    
		if(!isset($_SESSION)){
			session_start();
		}

		$logitudPass = 4;
		$miPassword  = substr( md5(microtime()), 1, $logitudPass);
		$clave       = $miPassword;

		$email = trim($_POST['email']);
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].$_SESSION['sesion_aprenDigital']['ape_paterno'];

		$password_segura = password_hash($clave, PASSWORD_BCRYPT,['cost' =>4]);
		
		$sql ="SELECT * FROM usuarios WHERE email = '$email'";
		$cuenta = mysqli_query($db, $sql);
		$data = mysqli_fetch_array($cuenta);

		if($cuenta && mysqli_num_rows($cuenta) == 1){
      echo "if"; //die();
			$sql2 = "UPDATE usuarios SET clave='$password_segura', fechamodificacion=NOW(), usuario='$usuario' WHERE email = $email";
			$resultado = mysqli_query($db, $sql2); 

			$destinatario = $email;
			$asunto = "Recuperando Clave - Aprendedor Digital";
		
			$cuerpo = '
    		<!DOCTYPE html>
    			<html lang="es">
    				<head>
    				<title>Recuperar Clave de Usuario</title>
						<link rel="stylesheet" href="assets/css/css/all.min.css">';
			$cuerpo .= '
			</head>
			<body>
				<table style="max-width:800px; padding: 10px; margin:0 auto; border-collapse: collapse;">			
					<tr>
						<td style="width: 100%; text-align: center; height:180px; box-sizing: border-box; ">
							<img width="auto" height="110px" style="display:block; margin:20px auto;" src="https://aprendedordigital.org/assets/img/logo.png">			
						</td>
					</tr>
					<tr>
						<td style="font-family: sans-serif; font-size: 18px; box-sizing: border-box;">
							<div style="text-align: center; padding: 10px 25px; " >
								<h3 style="color:#1c75bc;">Hola, '. $data['nombre'] .' '. $data['ape_paterno'] .'</h3>
								<p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
								Te hemos creado una nueva clave temporal para que puedas iniciar sesión, la clave temporal es: <strong>'.$clave.'</strong></p>
								<p>Haz click <a href="https://aprendedordigital.org/index.php" style="color:#1c75bc; font-weight: 700;">aquí</a> para ingresar
								</p>											
							</div>
							<div style="text-align: center; margin-top: 50px;" >							
								<p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
									P.D.  Para cualquier consulta siempre puedes escribirnos a: <a href="mailto:info@aprendedordigital.org">info@aprendedordigital.org</a>
								</p>														
							</div>
							<div style="width:100%; padding: 30px 20px; box-sizing: border-box; text-align: center;background-color: #0A2558; color:#fff; border-radius:0 0 6px 6px;">				
									<a style="padding: 6px; margin-right: 10px; color:#fff; font-size: 24px;" href="https://www.facebook.com/Aprendedor-Digital-110587471240379" target="_blank"><i class="fab fa-facebook-f"></i></a>
									<a style="padding: 6px; margin-right: 10px; color:#fff; font-size: 24px;" href="https://www.instagram.com/escuela.aprendedordigital/" target="_blank"><i class="fab fa-instagram"></i></a>
									<a style="padding: 6px; margin-right: 10px; color:#fff; font-size: 24px;" href="https://www.youtube.com/channel/UC7c-NHW2US8ukag2l8AWhJA" target="_blank"><i class="fab fa-youtube"></i></a>
									<a style="padding: 6px; margin-right: 10px; color:#fff; font-size: 24px;" href="https://www.linkedin.com/company/aprendedor-digital" target="_blank"><i class="fab fa-linkedin-in"></i></a>
									<div style="padding: 20px 0; color:#fff; font-size: 20px;"> 
										<a style="text-decoration: none; color:#fff;" href="https://aprendedordigital.org/">Aprendedor Digital </a>	©2021  
									</div>
							</div>														
						</td>
					</tr>		
				</table>
			</body>
			</html>
			';

      $_SESSION['recupera_cuenta'] = "Se envío un correo a tu cuenta " . $email. " para restablecer la clave";

      header("Location:../recuperar-cuenta.php?email=$email");
      
		}else{
			echo "else"; die();
      $_SESSION['fallo'] = "La cuenta de correo no está registrada, por favor validar!";		
      header("Location:../recuperar-cuenta.php");
		}	
  }
  header("Location:../recuperar-cuenta.php");
?>