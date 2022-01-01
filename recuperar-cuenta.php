<?php 
include 'layout/header.php';

?>

<body >
	<div class="box-recupera">
		<div class="center">
			<div class="box-image">
				<img src="../assets/img/logo.png" alt="logo"  class="img-logo">
			</div>
			<div class="box-inner-recupera">
				<div class="box-title">
					<h2 class="title"> ¿Olvidó su contraseña? </h2>
				</div>
				<div class="box-login">							
					<form action="models/recuperar-cuenta.php" method="post" id="form" autocomplete="false">			
						<div class="w100">
							<p class="parrafo">Por favor, introduzca la dirección de correo electrónico que utilizó para registrarse. Recibirá un código para restablecer su contraseña.</p>	
						</div>
						<?php if(isset($_SESSION['recupera_cuenta'])) :?>
							<div class="alerta-exito"> 
								<?=$_SESSION['recupera_cuenta']; ?>
							</div> 
						<?php endif; ?>	
						<?php if(isset($_SESSION['error_cuenta'])) :?>
							<div class="alerta-error"> 
								<?=$_SESSION['error_cuenta']; ?>
							</div> 
						<?php endif; ?>	
						<div class="inputEmail">
							<label for="" class="label">Dirección de correo electrónico </label>
							<div>
								<input type="text" name="email" class="input w100" id="email" placeholder="correo@aprendedordgitigital.com" onkeydown="validaemail()" required>
								<span id="validaemail"></span>
							</div>
						</div>
						<div class="w100">
							<button type="submit" name="submit" class="btn w100">SOLICITAR RESTABLECER CONTRASEÑA</button>
						</div>
					</form>		
					<div class="w100 ">
						<a href="index.php" class="enlaces2"><i class="fas fa-angle-left"></i> volver a inicio sesión</a>
					</div>
				</div>
			</div>
		</div>
	</div>	
	
	<?php include 'layout/footer.php'; ?>

	<script type="text/javascript"> 				
				
		function validaemail(){
			var form = document.getElementById("form");			
			var email = document.getElementById("email").value;
			var validaemail = document.getElementById("validaemail");
			var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

			if(email.match(pattern)){
				form.classList.add("valido");
				form.classList.remove("invalido");
				validaemail.innerHTML = "El formato de correo es valido";
				validaemail.style.color = "#45590F";
			}else{
				form.classList.remove("valido");
				form.classList.add("invalido");
				validaemail.innerHTML = "El formato de correo es invalido";
				validaemail.style.color = "#ff0000";
			}
			if(email == ""){
				form.classList.remove("valido");
				form.classList.remove("invalido");
				validaemail.innerHTML = "";
				validaemail.style.color = "#ff0000";
			}
		}
					
	</script>