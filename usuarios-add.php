<?php 
  include 'layout/header.php';
	if(isset($_POST)){
		$number = $_POST['number'];		
	}
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>    
		
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
					<h1 class="title">Administración de Usuarios / Docentes / Alumnos</h1>
					<div class="box-botones">						
						 <a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>						 
					</div>
				</div>
				<?php if(isset($_SESSION['completado'])): ?>
					<div class="alerta-exito">
						<?=$_SESSION['completado']?>  
					</div>
				<?php elseif(isset($_SESSION['fallo'])): ?>
					<div class="alerta-error">
						<?=$_SESSION['fallo']?>
					</div>
				<?php endif; ?> 
				<div class="box-message" id="info"></div>
				<div class="container-wrap w100">		
					<form action="models/add/usuarios-add.php" class="box-formulario" id="" method="post">
						<?php for($i = 1; $i <= $number; $i++): ?>	
							<div class="box-formulario-register mg-bt10" >
								<div class="box-input w25">
									<label for="nombre">Nombre: </label>									
									<input class="text50" type="text" name="nombre[]" maxlength="50" data-maxlength="50" required>
									<!-- <span class="counterNombre">16</span> -->									
								</div>
								<div class="box-input w25">
									<label for="apepaterno">Ape. Paterno: </label>
									<input class=" text50" type="text" name="apepaterno[]" maxlength="50" data-maxlength="50" required>
									<!-- <span class="counterApePaterno">16</span> -->								
								</div>
								<div class="box-input w25">
									<label for="apematerno">Ape. Materno: </label>
									<input class=" text50" type="text" name="apematerno[]" maxlength="50" data-maxlength="50" required>
									<!-- <span class="counterApeMaterno">16</span> -->									
								</div>							
								<div class="box-input w25">
									<label for="doc">Documento Identidad: </label>
									<input class="number" type="text" name="doc[]" minlength="8" required>
									
								</div>
								<div class="box-input w25">
									<label for="email">Correo: </label>										
									<input id="email<?=$i?>" type="email" name="email[]" maxlength="80" required>
									<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'email') : ''; ?>									
								</div>
								<div class="box-input w25">
									<label for="password">Contraseña:</label>
									<input type="text" name="password[]" minlength="8" required>
									<!-- <a class="btn" onclick="getPassword();">Generar Clave</a>	 -->
									
								</div>																		
								<div class="box-input w25">
									<label for="sexo">Sexo: </label>										
									<select class="w70" name="sexo[]" required>
										<option value="" disabled selected>Seleccionar Sexo</option>
										<?php 
											$instituciones = selectalldatos($db, 'sexo');
											if(!empty($instituciones) && mysqli_num_rows($instituciones) >= 1):
												while($dato = mysqli_fetch_assoc($instituciones)):
										?>
											<option value="<?=$dato['id']?>"><?=$dato['nombre']?></option>
										<?php endwhile; endif; ?>							
									</select>
								</div>
								<div class="box-input w25">
									<label for="fecnac">Fecha Nacimiento: </label>					
									<input class="" type="date" name="fecnac[]" value="<?php echo date("Y-m-d");?>" required >
								</div>								
								<div class="box-input w25">
									<label for="">Celular / Whatapp: </label>			
									<input class="number" type="text" name="celular[]" required>
								</div>																						
								<div class="box-input w25">
									<label for="">Pais: </label>										
									<input class="texto " type="text" name="pais[]" id="pais" required></div>																	
								<div class="box-input w25">
									<label for="perfil">Perfil: </label>										
									<select class="w65" name="perfil[]" id="perfil" required>
										<option value="" disabled >Seleccionar perfil</option>
										<?php 
											$perfiles = selectalldatos($db, 'perfil');
											if(!empty($perfiles) && mysqli_num_rows($perfiles) >= 1):
												while($dato = mysqli_fetch_assoc($perfiles)):
										?>
											<?php if($dato['id'] <= '2' ): ?>
												<option value="<?=$dato['id']?>" disabled><?=$dato['nombre']?></option>
											<?php elseif($dato['id'] == '4' ): ?>
												<option value="<?=$dato['id']?>" selected><?=$dato['nombre']?></option>				
											<?php else: ?>
													<option value="<?=$dato['id']?>"><?=$dato['nombre']?></option>
											<?php endif; ?>										
										<?php endwhile; endif; ?>
										<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'perfil') : ''; ?>
									</select>	
								</div>
								<div class="box-input w25">
									<label for="institucion">Institución : </label>					
									<select class="w65" name="institucion[]" id="institucion" required>
										<option value="" disabled selected>Seleccionar Institución</option>
										<?php 
											$instituciones = selectalldatos($db, 'instituciones');
											if(!empty($instituciones) && mysqli_num_rows($instituciones) >= 1):
												while($dato = mysqli_fetch_assoc($instituciones)):
										?>
											<option value="<?=$dato['id']?>"><?=$dato['nombre']?></option>
										<?php endwhile; endif; ?>
										<?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'institucion') : ''; ?>
									</select>	
								</div>															
							</div>
							<hr class="w100">						
						<?php endfor;	?>
						<?php if($number > 1 ): ?>      							
							<input type="submit" value="Añadir Usuarios" class="btn" name="anadirusuarios" id="anadirusuarios">
							<?php else : ?>	
								<input type="submit" value="Añadir Usuario" class="btn" name="anadirusuarios" id="anadirusuarios">
						<?php endif; ?>
					</form>	
										
				</div>
			</div>
			<!--fin center  -->
			<?php borrarErrores(); ?>		
		</div>
	
	</section>

	<?php include 'layout/footer.php'; ?>
</main>

<script>
	for(var i = 1; i <= <?=$number?>; i++){		
		
		$("#email"+i).on("keyup", function(){			
			var email = $(this).val();
			var correolength = $(this).val().length;

			if(correolength >= 6 ){
				var dataString = 'email='+ email;			
				$.ajax({
					url: 'models/searchs/verificarEmail.php',
					type: "GET",
					data: dataString,
					dataType: "JSON",
					success: function(respuesta){
						if(respuesta.success == 1){												
							$("#info").html(respuesta.message);
							$("#info").fadeOut(10000, function(){
								$(this).html("");
								$(this).fadeIn(5000);
							});							
							//$("#nickname").css("border-color","red");
							$("#anadirusuarios").addClass("btn-none");
							$("#anadirusuarios").attr('disabled',true);
						}else{							
							$("#info").html(respuesta.message);							
							//$("#nickname").css("border-color","rgba(28, 117, 188, 0.5)");
							$("#anadirusuarios").removeClass("btn-none");
							$("#anadirusuarios").attr('disabled',false); 
						}
					}
				});

			}
				

		});
		
	}

</script>