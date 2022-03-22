<?php
	session_start();
	// if(!isset($_SESSION['sesion_aprenDigital'])){
	// 	header("Location: dashboard.php");
	// }

  require_once 'controllers/controller.php'; 
	require_once 'config/db.php'; 
  require_once 'models/helpers.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title><?php echo APP_TITLE ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta name="author" content="Oscar Rojas O."/>
  <meta name="description" content=""/>
  <meta name="keywords" content=""/>
  <meta name="robots" content="Index, Follow">  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="theme-color" content="#0A2558">
  <!---------------- favicon ---------------->
  <link rel="icon" href="../assets/img/logo.ico" type="image/ico">

  <!---------------- estilos ---------------->
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <link rel="stylesheet" href="assets/css/eapdstyles.css">  
  <link rel="stylesheet" href="assets/css/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css"/>

  <!---------------- jquery ---------------->
  <script type="text/javascript" src="assets/js/jquery.js"></script> 
  
</head>
<body></body>
  <div class="container-wrap login-escuela">
    
    <div class="w50 box-imagen">
      <img src="../assets/img/logo.png" alt="" class="img-login">
    </div>
    <div class="w50 box-formulario-login">
      <div class="box-title">
        <h1 class="title">Formulario de Ingreso</h1>
      </div>
      <form action="models/login.php" method="post" id="form" class="form" autocomplete="off">			
        <?php if(isset($_SESSION['error_login'])) :?>
          <div class="alerta-error"> 
            <?=$_SESSION['error_login'];?>
          </div> 
        <?php endif; ?>
        
							<div class="box-input inputEmail">
								<input type="text" name="email" class="input w100" id="email" placeholder="Ingresa tu Email" onkeydown="validaemail()" required>
								<div class="icon"><i class="fas fa-user"></i></div>
								<div class="toggle toggle-user">
									<span id="span1" class="none"><i class="fas fa-check-circle"></i></span>
									<span id="span2" ><i class="fas fa-times-circle"></i></span>
								</div>
								<span class="erroremail" id="erroremail"></span>
							</div>	
							<div class="box-input inputBox">
								<input type="password" name="password" id="password" class="input w100" placeholder="Ingresa tu Contraseña" onkeyup="lengthpassword()" required>
								<div class="icon"><i class="fas fa-lock"></i></div>
								<div class="toggle toggle-pass" onclick="showHide()">
									<span id="span3"><i class="far fa-eye-slash"></i></span>
									<span id="span4" class="none"><i class="far fa-eye"></i> </span>
								</div>
							</div>
							<div class="field">
								<a href="recuperar-cuenta.php" class="link">¿Olvide mi contraseña?</a>
							</div>							
							<div class="box-buttons">
								<input type="submit" name="submit" value="Ingresar" class="btn btn-azul">			
								<label for="register" class="register">¡No estoy registrado! </label>
                <a href="../form-alumno.php" class="link">Registrarme</a>
							</div>							
				</form>
      
    
    </div>
  </div>
</body>
</html>

<script type="text/javascript">
	
	/**
  * VALIDACIONES DEL LOGIN
  * */	
	function validaemail(){
		const form = document.getElementById("form"),
		email = document.getElementById("email").value,
		emailLenght = email.length,
		span1 = document.querySelector('#span1'),
		span2 = document.querySelector('#span2'),
		toggle = document.querySelector('.toggle-user'),
		erroremail = document.getElementById("erroremail");		
		let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

		if(emailLenght >= 1){
			toggle.classList.add("active");
		}

		if(email.match(pattern)){
			form.classList.add("valido");
			span1.classList.remove("none");
			span2.classList.add("none");
			form.classList.remove("invalido");
			erroremail.innerHTML = "";			
		}else{
			form.classList.remove("valido");
			form.classList.add("invalido");
			span1.classList.add("none");
			span2.classList.remove("none");
			erroremail.innerHTML = "El correo no es valido!";
			erroremail.style.color = "#ff0000";
		}
		if(email == ""){
			form.classList.remove("valido");
			form.classList.remove("invalido");
			erroremail.innerHTML = "";
			erroremail.style.color = "#ff0000";
		}
	}

	function lengthpassword(){
		const password2 = document.getElementById('password').value,
		password2length = password2.length,
		toggle = document.querySelector('.toggle-pass');		
		if(password2length >= 1){
			toggle.classList.add("active");
		}else{
			toggle.classList.remove("active");
		}

	}

	const password = document.getElementById('password'),				
		span3 = document.querySelector('#span3'),
		span4 = document.querySelector('#span4');

	function showHide(){
		if(password.type == 'password'){
			password.setAttribute('type','text');			
			span3.style.display = "none";
			span4.style.display = "block";
		}else{
			password.setAttribute('type','password');
			span3.style.display = "block";
			span4.style.display = "none";
		}
	}

</script>