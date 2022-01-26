<?php 

require_once 'controllers/controller.php'; 
require_once 'config/db.php'; 
require_once 'models/helpers.php'; 

$correovalidado = isset($_POST['email']) ? $_POST['email'] : null; 
echo $correovalidado;

// correo5@correo.com
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

<body >
	<div class="box-recupera">
		<div class="center">
			<div class="box-image">
				<img src="../assets/img/logo.png" alt="logo"  class="img-logo">
			</div>
			<div class="box-inner-recupera">
				<div class="box-titles">
					<h2 class="title"> ¿Olvidó su contraseña? </h2>
				</div>

				<?php if($correovalidado == null) : ?>
					<div class="item-recupera">					
						<div id="info"></div>	
						
						<?php if(isset($_SESSION['completado'])): ?>
							<div class="alerta-exito">
								<?=$_SESSION['completado']?>  
							</div>
						<?php elseif(isset($_SESSION['fallo'])): ?>
							<div class="alerta-error">
								<?=$_SESSION['fallo']?>
							</div>
						<?php endif; ?> 
						<form action="models/uprecuperar-cuenta.php" method="post" id="form" class="form" autocomplete="off">			
							<div class="w100">
								<p class="parrafo">Por favor, introduzca la dirección de correo electrónico que utilizó para registrarse; recibirá una contraseña temporal para restablecer su cuenta.</p>	
							</div>							
							<div class="box-input inputEmail">
									<input type="text" name="email" class="input w100" id="email" placeholder="Email" onkeydown="validaemail()" required>
									<div class="icon"><i class="fas fa-user"></i></div>
									<div class="toggle toggle-user">
										<span id="span1" class="none"><i class="fas fa-check-circle"></i></span>
										<span id="span2" ><i class="fas fa-times-circle"></i></span>
									</div>
									<span class="erroremail" id="erroremail"></span>
								</div>	
							<div class="w100">
								<button type="submit" name="submit" id="submit" class="btn w100">SOLICITAR RESTABLECER CONTRASEÑA</button>
							</div>
						</form>		
						<div class="w100 mg-tp20">
							<a href="../index.php" class="link"><i class="fas fa-angle-left"></i> volver a inicio sesión</a>
						</div>
					</div>
				
				<?php else : ?>

					<div class="item-recupera">						
						<div class="w100">
							<p class="parrafo">Se tePor favor, introduzca la dirección de correo electrónico que utilizó para registrarse; recibirá una contraseña temporal para restablecer su cuenta.</p>	
						</div>
					</div>

				<?php endif; ?>
			</div>
		</div>
	</div>	
	<?php borrarErrores(); ?>
	<?php include 'layout/footer.php'; ?>

<script type="text/javascript"> 				
				
	function validaemail(){
		const form = document.getElementById("form"),
		email = document.getElementById("email").value,
		emailLenght = email.length,
		span1 = document.querySelector('#span1'),
		span2 = document.querySelector('#span2'),
		toggle = document.querySelector('.toggle-user'),
		erroremail = document.getElementById("erroremail");		
		let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

		if(emailLenght >= 10){
			//toggle.classList.add("active");
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
				erroremail.innerHTML = "ingresa un correo valido!";
				erroremail.style.color = "#ff0000";
			}
		}

		if(email == ""){
			form.classList.remove("valido");
			form.classList.remove("invalido");
			erroremail.innerHTML = "";
			erroremail.style.color = "#ff0000";
		}
	}
					
</script>

<script>		
		
	$("#email").on("keyup", function(){			
		var email = $(this).val();
		var correolength = $(this).val().length;

		if(correolength >= 10 ){
			var dataString = 'email='+ email;			
			$.ajax({
				url: 'models/searchs/recuperarEmail.php',
				type: "GET",
				data: dataString,
				dataType: "JSON",
				success: function(respuesta){
					if(respuesta.success == 0){
						$("#info").slideDown();											
						$("#info").html(respuesta.message);												
						$("#submit").addClass("btn-none");
						$("#submit").attr('disabled', true);
					}else{
						$("#info").slideDown();					
						$("#info").html(respuesta.message);				
						$("#submit").removeClass("btn-none");
						$("#submit").attr('disabled', false); 
					}
				}
			});
		}			

	});

	$("#submit").click(function(){
		var email = $("#email").val();

		if(email == ''){
			$("#info").html("<p class='alerta-error'><i class='fas fa-exclamation-circle'></i> Debe ingresar un correo.<strong>");
		}
	});	

</script>