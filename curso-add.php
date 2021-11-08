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
					<h1 class="title">Añadir Curso</h1>
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

				<div class="container-wrap mg-auto w100">
					<div class="inner-content mg-bt20 w70">												
						<form action="models/add/cursos-add.php" class="box-formulario" enctype="multipart/form-data" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="box-input">
									<label for="nombre">Nombre del Curso: </label>					
									<input class="w100" type="text" name="nombre" >
								</div>
								<div class="box-input">
									<label for="descripcion">Breve Descripcion: </label>									
									<textarea name="descripcion" rows="5"></textarea>
								</div>
								<div class="box-input">
									<label for="">Fase: </label>
									<select class="w70" name="fase" required>
										<option >Seleccionar Fase</option>
										<?php 
											$fases = selectalldatos($db, 'fases');
											if(!empty($fases) && mysqli_num_rows($fases) >= 1):
												while($fase = mysqli_fetch_assoc($fases)):
										?>
											<option value="<?=$fase['id']?>">
												<?=$fase['nombre']?>								
											</option>
										<?php 
											endwhile;
										endif;
										?>
										</select>									
								</div>		
								<div class="box-input">
									<label for="nombre">Orden a mostrar: </label>
									<input class="w100" type="number" name="orden" value="1" min="1">
								</div>																		
								<div class="box-input">
									<label for="nombre">Imagen: </label>			
									<input class="w100" type="file" name="imagen" required>
								</div>						
							</div>						
							<input type="submit" value="Añadir Curso" class="btn" name="" id="" >				
							
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