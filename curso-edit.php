<?php 
  include 'layout/header.php'; 
	if(!isset($_POST)){		
		header("Location:admin-cursos.php");
	}else{
		$id = $_GET['id'];	
	}
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
					<h1 class="title">Editar Curso</h1>
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
						<?php 
								$datos = obtenerdatos($db, 'cursos', $id);        
								if(!empty($datos) && mysqli_num_rows($datos) >= 1):
									while($dato = mysqli_fetch_assoc($datos)):  
						?> 						
						<form action="models/updates/upcurso.php" class="box-formulario" enctype="multipart/form-data" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="box-input">
									<label for="nombre">Nombre de la Fase: </label>	
									<input class="w100" type="hidden" name="id" value="<?php echo $dato['id']; ?>">
									<input class="w100" type="text" name="nombre" value="<?php echo $dato['nombre']; ?>">
								</div>
								<div class="box-input">
									<label for="descripcion">descripcion: </label>									
									<textarea name="descripcion" rows="5"><?php echo $dato['descripcion']; ?></textarea>
								</div>
								<div class="box-input">
									<label for="orden">Orden a Mostrar: </label>
									<input class="w100" type="number" name="orden" value="<?php echo $dato['orden']; ?>" min="1">
								</div>
								<div class="box-input">
									<label for="">Fase: </label>
									<select class="w70" name="fase">
										<?php 
											$fases = selectalldatos($db, 'fases');
											if(!empty($fases) && mysqli_num_rows($fases) >= 1):
												while($fase = mysqli_fetch_assoc($fases)):
										?>
											<option value="<?=$fase['id']?>" <?=($fase['id']) == $dato['fase_id'] ? 'selected="selected"': '' ?>>
												<?=$fase['nombre']?>								
											</option>
										<?php 
											endwhile;
										endif;
										?>																
									</select>									
								</div>
								<div class="box-input">
									<label for="">Cambiar Foto:</label>
									<input class="w100" type="hidden" name="documento" value="<?php echo $dato['imagen']; ?>">
									<img src="assets/img/cursos/<?php echo $dato['imagen'] ?>" alt=""><hr class="w100 mg-bt10">									
									<input class="w100" type="file" name="foto" >
								</div>																		
								<?php 
									endwhile;
								endif;
								?>
							</div>						
							<input type="submit" value="Actualizar Datos" class="btn">				
							
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