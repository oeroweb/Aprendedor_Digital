<?php 
  include 'layout/header.php'; 
	
	if($_SESSION['sesion_aprenDigital']['perfil_id'] == 4){

    $cursos = obtenerdatosusuarios($db, 'grupos_usuarios_cursos', $_SESSION['sesion_aprenDigital']['id']);        
      if(!empty($cursos) && mysqli_num_rows($cursos) >= 1){
        $cantidad_cursos = mysqli_num_rows($cursos); 
        //echo $cantidad;
        //$cantidad_programa = round((($cantidad_cursos * 100)/12),2);									
        $cantidad_programa = 0;									
      }
  }
								
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
					<h1 class="title">Mi Perfil</h1>
					<div class="box-botones">						
						<a href="perfil-edit.php" class="btn-2 btn-azul " title="Editar Perfil"><i class="fas fa-pen"></i></a>				 
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

				<div class="container-wrap w100">
					<div class="inner-content mg-bt20 w30">					
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
							<div class="box-redes-sociales">
								<?php if($perfil['redes_facebook']) :?>					
								<a href="<?php echo $perfil['redes_facebook'];?>"
								target="_blank"><i class="fab fa-facebook-f"></i></a>
								<?php endif ?>
								<?php if($perfil['redes_instagran']) :?>	
									<a href="<?php echo $perfil['redes_instagran'];?>" target="_blank"><i class="fab fa-instagram"></i></a>      	
								<?php endif ?>
								<?php if($perfil['redes_linkedin']) :?>	
									<a href="<?php echo $perfil['redes_linkedin'];?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
								<?php endif ?>
							</div>										
						<?php endwhile;
						endif; ?>						
					</div>
					
					<?php if($_SESSION['sesion_aprenDigital']['perfil_id'] == 4) : ?>
					<div class="inner-content mg-bt20 w70">					 			
						<div class="inner-content-cursos">	
								<div class="item-cursos">
									<h2 class="title">Porcentaje del Programa</h2>
									<?php if(isset($cantidad_programa)) : ?>
										<input type="text" value="<?=$cantidad_programa?>" class="porcentaje_programa">
									<?php else: ?>
										<input type="text" value="0" class="porcentaje_programa">
									<?php endif; ?>
								</div>
								<div class="item-cursos">
									<h2 class="title">Porcentaje <?=$cantidad_programa?>% de avance de Cursos</h2>
									<?php 
										$cursos = obtenerdatosusuarios($db, 'grupos_usuarios_cursos', $_SESSION['sesion_aprenDigital']['id']);										
											if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):												  
									?> 
									<ul class="list-avance">
										<li>
											<h3 class="title">Cursos Completados</h3>
										</li>
										<li>
											<h3 class="title">Fases</h3>
										</li>
										<li>
											<h3 class="title">Foros</h3>
										</li>
									</ul>
									<?php 
										else: ?>
												<div class="inner-content mg-bt20">
												<h2 class="title">No tienes cursos registrados aún. </h2>
											</div>
									<?php endif; ?>
								</div>
						</div>							
					</div>
					<?php endif; ?>

					<!-- DATOS -->
					<div class="inner-content w100">
						<?php 
							$perfiles = obtenerdatos($db, 'usuarios', $_SESSION['sesion_aprenDigital']['id']);        
							if(!empty($perfiles) && mysqli_num_rows($perfiles) >= 1):
								while($perfil = mysqli_fetch_assoc($perfiles)):  
						?> 
							<div class="datos-perfil">														
								<div class="box-text">
									<label for="">Nombres y Apellidos: </label>									
									<p class="parrafo"><i class="fas fa-user"></i> <?php echo $perfil['nombre'] .' ' .$perfil['ape_paterno'] .' '.$perfil['ape_materno']; ?></p>
								</div>													
								<div class="box-text">
									<label for="">Correo: </label>	
									<p class="parrafo"><i class="far fa-envelope"></i> <?php echo $perfil['email'];?></p>
								</div>
								<div class="box-text">
									<label for="">Celular / Whatapp: </label>										
									<p class="parrafo"><i class="fab fa-whatsapp"></i> <?php echo $perfil['celular'];?></p>
								</div>
								<div class="box-text">
									<label for="">Información Biográfica: </label> 
									<p class="parrafo"><i class="fas fa-address-card"></i> <?php echo $perfil['descripcion'];?></p>
								</div>
								<div class="box-text">
									<label for="">Intereses: </label>										
									<p class="parrafo"><i class="fas fa-heart"></i> 
										<?php if($perfil['interes']) :
											$miInteres = $perfil['interes'];

											$array_interes = explode(', ', $miInteres);
											foreach($array_interes as $interes) : ?>
									<span class="etiqueta"><?=$interes?></span>
										<?php endforeach; endif; ?>
									</p>
								</div>								
								<div class="box-text">
									<label for="">Nicho: </label>										
									<p class="parrafo"><i class="fas fa-search-dollar"></i> <?php echo $perfil['nicho_mercado']; ?></p>
								</div>
								<div class="box-text">
									<label for="">Proposito: </label>										
									<p class="parrafo"><i class="far fa-id-badge"></i> <?php echo $perfil['proposito']; ?></p>
								</div>
								<div class="box-text">
									<label for="">Nacionalidad: </label>										
									<p class="parrafo"><i class="fas fa-globe-americas"></i> <?php echo $perfil['nacionalidad']; ?></p>
								</div>
								<div class="box-text">
									<label for="">Localidad / Pais: </label>										
									<p class="parrafo"><i class="fas fa-map-marker-alt"></i> <?php echo $perfil['localidad'] .' - '.$perfil['pais']; ?></p>
								</div>
								<?php if($perfil['archivo'] != null): ?>   
									<div class="box-text">	
										<label for="">Mi CV: </label>
										<p class="parrafo"><i class="far fa-file-pdf" ></i>
											<a href="assets/files/<?php echo $perfil['carpeta'].'/'.$perfil['archivo']; ?>" class="btn-file" target="_blank"> <?php echo $perfil['archivo']; ?> <i class="fas fa-download"></i></a>
										</p>								
									</div>
								<?php endif ?>
							</div>						
						<?php endwhile;
						endif; ?>			
					</div>
					
					<!-- CERTIFICADOS -->
					<div class="inner-content w100 hidden">
						<h2 class="title">CERTIFICADOS</h2>
						<?php 
							$cursos = obtenerdatos($db, 'cursos', $_SESSION['sesion_aprenDigital']['id']);        
								if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):
									while($curso = mysqli_fetch_assoc($cursos)):  
						?> 
						<?php endwhile;
							else: ?>
									<div class="inner-content mg-bt20">
									<h2 class="title">No tienes Certificados registrados.</h2>
								</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
				<!--fin center  -->
			<?php borrarErrores(); ?>		
		</div>
	</section>
	<?php include 'layout/footer.php'; ?>
</div>
</main>

<script>
		$(document).ready(function() {
			//$(".dial").knob();
			$('.porcentaje_programa').knob({
				'min':0,
				'max':100,
				'width':220,
				'height':220,
				'displayInput':true,
				'fgColor':"#1c75bc",
				'bgColor':"#a6a6a6",
				'release':function(v) {$(".p").text(v);},
				'readOnly':true
			});
		});
</script>
<script>

	const progress = document.getElementById("porcentaje");
	let numberprogress = document.getElementById("numeroporcentaje");

	let cantidad1 = 0;
	let cantidad2 = 440;

	// let tiempo = setInterval(() => {
	// 	cantidad1 += 1;
	// 	let value = Math.ceil(cantidad2 -=4.5);
	// 	numberprogress.textContent = cantidad1;
	// 	progress.style.strokeDashoffset=`${value}`;

	// 	if(cantidad1 === 100){
	// 		clearInterval(tiempo)
	// 	}


	// }, 80);
</script>