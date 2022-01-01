<?php 
  include 'layout/header.php'; 
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
					<h1 class="title">Editar Perfil</h1>				
					<div class="box-botones">						
						<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>
					</div>
				</div>
				<hr class="w100">
				<?php if(isset($_SESSION['completado'])): ?>
					<div class="alerta-exito">
						<?=$_SESSION['completado']?>  
					</div>
				<?php elseif(isset($_SESSION['fallo'])): ?>
					<div class="alerta-error">
						<?=$_SESSION['fallo']?>
					</div>				
				<?php endif; ?> 

				<div class="container-wrap mg-auto w80">
					<div class="inner-content w40">	
						<?php 
							$perfiles = obtenerdatos($db, 'usuarios', $_SESSION['sesion_aprenDigital']['id']);        
								if(!empty($perfiles) && mysqli_num_rows($perfiles) >= 1):
									while($perfil = mysqli_fetch_assoc($perfiles)):  
						?>  			
							<?php if($perfil['imagen'] != null): ?> 
								<div class="box-image">
									<img class="img-perfil" src="assets/files/<?php echo $perfil['carpeta_img'].'/'.$perfil['imagen']; ?>" alt="Foto de Perfil">
								</div>
							<?php else : ?>
								<div class="box-image">
								<img class="img-perfil" src="assets/img/avatar/male.png" alt="Foto de Perfil">
								</div>
							<?php endif ?>					
						<?php 
							endwhile;
						endif;
						?>											
					</div>
					<div class="inner-content w60">
						<?php 
							$perfiles = obtenerdatos($db, 'usuarios', $_SESSION['sesion_aprenDigital']['id']);        
								if(!empty($perfiles) && mysqli_num_rows($perfiles) >= 1):
									while($perfil = mysqli_fetch_assoc($perfiles)):  
						?>  												
						
							<form action="models/updates/upfotoperfil.php" enctype="multipart/form-data" class="box-formulario" method='post'>			
								<div class="box-input" >
									<?php if($perfil['imagen'] != null ): ?>
										<label for="">Cambiar Foto:</label>
									<?php else: ?>
										<label for="">Añadir Foto:</label>
									<?php endif; ?>
									<input type="file" name="foto" required><br>
								</div>
								<input type="submit" value="Actualizar Foto" class="btn">
							</form>
							<?php 
							endwhile;
						endif;
						?>		
					</div>

					<div class="inner-content mg-bt20 w100">					
						<?php 
								$perfiles = obtenerUsuariosPorId($db, 'usuarios', $_SESSION['sesion_aprenDigital']['id']);        
								if(!empty($perfiles) && mysqli_num_rows($perfiles) >= 1):
									while($perfil = mysqli_fetch_assoc($perfiles)):  
						?> 						
						<form action="models/updates/upperfil.php" class="box-formulario" enctype="multipart/form-data" method="post">
							<div class="w100 container-wrap" >
								<div class="w50">
									<div class="box-input ">
										<label for="">Nombre: </label>						
										<input class="w100" type="text" name="nombre" value="<?php echo $perfil['nombre']; ?>">
										<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'nombre') : ''; ?>	
									</div>
									<div class="box-input ">
										<label for="">Ape. Paterno: </label>
										<input class="w100" type="text" name="apepaterno" value="<?php echo $perfil['ape_paterno']; ?>">
										<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'apepaterno') : ''; ?>	
									</div>
								</div>
								<div class="w50">	
									<div class="box-input ">
										<label for="">Ape. Materno: </label>
										<input class="w100" type="text" name="apematerno" value="<?php echo $perfil['ape_materno']; ?>">
										<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'apematerno') : ''; ?>
									</div>
									<div class="box-input">
									<label for="docident">Documento Identidad: </label>
									<input class="w100" type="text" name="docident" value="<?php echo $perfil['doc_identidad']; ?>">
									<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'dni') : ''; ?>								
									</div>
								</div>
								<div class="box-input">
									<label for="descripcion">Información Biográfica: </label>
									<textarea class="w100" name="descripcion" rows="5"  cols="3" placeholder="descripción"><?php echo $perfil['descripcion']; ?></textarea>
								</div>
								<div class="w50">
									<div class="box-input">
										<label for="">Sexo: </label>
										<select class="w70" name="sexo">
										<?php 
											$sexos = selectalldatos($db, 'sexo');
											if(!empty($sexos) && mysqli_num_rows($sexos) >= 1):
												while($sexo = mysqli_fetch_assoc($sexos)):
										?>											
											<option value="<?=$sexo['id']?>" <?=($sexo['id']) == $perfil['sexo_id'] ? 'selected="selected"': '' ?>>
												<?=$sexo['nombre']?>
											</option>										
										<?php 
											endwhile;
										endif;
										?>																
										</select>									
									</div>
									<div class="box-input">
										<label for="fecnac">Fecha Nacimiento: </label>	
										<input class="w100" type="date" name="fecnac" value="<?php echo $perfil['fec_nacimiento'] ?>" required>
										<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'fecnac') : ''; ?>
										<input class="w100" type="hidden" name="edad" value="<?=$perfil['calculaedad']?>" readonly>
									</div>
									<div class="box-input">
										<label for="">Celular / Whatapp: </label>				
										<input class="w100" type="text" name="celular" value="<?php echo $perfil['celular']; ?>">
									</div>
									<div class="box-input">
										<label for="email">Correo: <span class="font-light">(no se permite cambiar)</span> </label>			
										<input class="w100" type="email" name="email" value="<?php echo $perfil['email']; ?>" readonly>
									</div>
									<div class="box-input">
										<label for="">Institución: </label>
										<select class="w70" name="institucion">
										<?php 
											$datos = selectalldatos($db, 'instituciones');
											if(!empty($datos) && mysqli_num_rows($datos) >= 1):
												while($dato = mysqli_fetch_assoc($datos)):
										?>
											<option value="<?=$dato['id']?>" <?=($dato['id']) == $perfil['institucion_id'] ? 'selected="selected"': '' ?>>
												<?=$dato['nombre']?>								
											</option>
										<?php 
											endwhile;
										endif;
										?>																
										</select>
									</div>
									<div class="box-input">
										<label for="pais">Pais: </label>								
										<input class="w100" type="text" name="pais" id="pais" value="<?php echo $perfil['pais']; ?>">
										<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'pais') : ''; ?>
									</div>
									<div class="box-input">
										<label for="pais">Nacionalidad: </label>		
										<input class="w100" type="text" name="nacionalidad" id="nacionalidad" value="<?php echo $perfil['nacionalidad']; ?>">	
									</div>
									<div class="box-input">
										<label for="localidad">Ciudada / Localidad actual: </label>	
										<input class="w100" type="text" name="localidad" id="localidad" value="<?php echo $perfil['localidad']; ?>">
									</div>														
									<div class="box-input">	
										<label for="direccion">Dirección: </label>		
										<input class="w100" type="text" name="direccion" value="<?php echo $perfil['direccion']; ?>">
									</div>
								</div>

								<div class="w50">
									<div class="box-input ">
										<label for="redes">Usuario: <span class="font-light">(@nombreusuario) </span> </label>			
										<input class="w100" type="text" name="nickname" id="nickname" placeholder="@usuario" value="<?=$perfil['nickname']; ?>">
										<div id="info"></div>
									</div>
									<div class="box-input ">
										<label for="redes">URL de tu cuenta de Facebook: </label>			
										<input class="w100" type="url" name="redes_facebook" value="<?php echo $perfil['redes_facebook']; ?>">
									</div>
									<div class="box-input ">
										<label for="redes">URL de tu cuenta de Instagram: </label>			
										<input class="w100" type="url" name="redes_instagran" value="<?php echo $perfil['redes_instagran']; ?>">
									</div>
									<div class="box-input ">
										<label for="redes">URL de tu cuenta de Linkedin: </label>			
										<input class="w100" type="url" name="redes_linkedin" value="<?php echo $perfil['redes_linkedin']; ?>">										
									</div>
									<div class="box-input">
										<label for="profesion">Profesión: </label>			
										<input class="w100" type="text" name="profesion" value="<?php echo $perfil['profesion']; ?>">
									</div>
									<div class="box-input">
										<label for="profesional">Nivel Profesional: </label>					
										<input class="w100" type="text" name="profesional" value="<?php echo $perfil['nivel_profesional']; ?>">
									</div>																
									<div class="box-input ">
										<label for="nicho">Nicho de Mercado: </label>		
										<input class="w100" type="text" name="nicho" value="<?php echo $perfil['nicho_mercado']; ?>">
									</div>
									<div class="box-input">
										<label for="proposito">Propósito: </label>				
										<input class="w100" type="text" name="proposito" value="<?php echo $perfil['proposito']; ?>">
									</div>
									<div class="box-input">
										<label for="interes">Intereses (Separado por comas): </label>			
										<input class="w100" type="text" name="interes" value="<?php echo $perfil['interes']; ?>">
									</div>									
								</div>
								<div class="box-input">	
									<div class="w50">
										<?php if($perfil['archivo'] != "") : ?>
											<label for="archivo">Cambiar CV: </label>							
											<input class="w100" type="hidden" name="documento" value="<?php echo $perfil['archivo']; ?>">
											<a href="assets/files/<?php echo $perfil['carpeta'].'/'.$perfil['archivo']; ?>" class="btn-file" target="_blank"><i class="far fa-file-pdf" ></i> <?php echo $perfil['archivo']; ?></a>
										<?php else : ?>
											<label for="archivo">Añadir CV: </label>										
										<?php endif; ?>
										<input type="file" name="archivo" accept="application/pdf">
										<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'archivo') : ''; ?>
									</div>								
									<!-- <iframe src="assets/files/<?php // echo $perfil['archivo']; ?>"></iframe> -->
								</div>										
								
								
								<!-- <div class="box-input-container">
									<label for='clave' >Clave</label>
									<input type='text' class="" name="clave" value="<?php //echo $perfil['clave']; ?>" id="clave">
									<a class="btn" onclick="getPassword();">Generar Clave</a>
								</div>									 -->
															
								<?php 
									endwhile;
								endif;
								?>
							</div>					
							<!-- <a href="#" class="btn btn-azul" id="mostrarinput" title="Editar Perfil"><i class='icon ion-edit'></i></a> -->
							<input type="submit" value="Actualizar Datos" class="btn" name="editarallperfil" id="editarallperfil" >				
							
						</form>						
					</div>
					
				</div>

			</div>	
			<!-- center -->
			<!-- <a class="btn" href="contenedor.php"> Inicio</a>		 -->
			<!-- <a class="btn" href="javascript:history.back()">Atrás</a>	 -->
			<?php borrarErrores(); ?>		
		</div>
		</section>
	<?php include 'layout/footer.php'; ?>
</div>
</main>

<script>
	$("#nickname").on("keyup", function(){
		var nickname = $("#nickname").val();
		var nicknamelenght = $("#nickname").val().length;

		if(nicknamelenght >= 3 ){

			var dataString = 'nickname='+ nickname;

			$.ajax({
				url: 'models/searchs/verificarNickname.php',
				type: "GET",
				data: dataString,
				dataType: "JSON",
				success: function(respuesta){
					if(respuesta.success == 1){
						$("#info").html(respuesta.message);						
						$("#nickname").focus();
						$("#nickname").css("border-color","red");
						$("#editarallperfil").addClass("btn-none");
						$("#editarallperfil").attr('disabled',true);
					}else{
						$("#info").html(respuesta.message);
						$("#nickname").css("border-color","rgba(28, 117, 188, 0.5)");
						$("#editarallperfil").removeClass("btn-none");
						$("#editarallperfil").attr('disabled',false); 
					}
				}

			});

		}
	});

</script>