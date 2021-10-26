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
					<h1 class="title">Administración de Fases / Cursos / Modulos </h1>
					<!-- <div class="box-botones">
						 <a href="curso-add.php" class="btn" title="Añadir Nuevo Curso"><i class="fas fa-pen"></i></a>	 
					</div> -->
				</div>
				<div class="box-botones">						
					<a href="curso-add.php" class="btn" title="Añadir Curso"><i class="fas fa-plus"></i> Añadir Nuevo Curso</a>						 
					<a href="admin-cursos-maestras.php" class="btn" title="Clases Maestras"><i class="far fa-eye"></i> Administrar Clases Maestras</a>						 
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

				<?php 
					$fases = selectalldatos($db, 'fases');        
						if(!empty($fases) && mysqli_num_rows($fases) >= 1):
							while($fase = mysqli_fetch_assoc($fases)):  
				?> 
				<div class="admin-cursos-content container-wrap w100">							
					<div class="box-titles">
						<div class="w50">
							<h2 class="title"><?php echo $fase['nombre']; ?> </h2>
							<p class="text"><?php echo $fase['descripcion']; ?></p>	
						</div>
						<div class="w30 al-ct">								
							<?php if($fase['estado_id'] == 2) :?>
								<a href="models/updates/fases-public.php?id=<?=$fase['id']?>" class="btn-3" title="No publicado">							
								<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
								Inactivo</a>												
							<?php else : ?>
								<a href="models/updates/fases-private.php?id=<?=$fase['id']?>" class="btn-3" title="Activo">							
								<img src="assets/fonts/toggle-on.svg" alt="activo">	
								Activo</a>												
							<?php endif; ?>	
						</div>	
						<div class="">						
							<a href="fase-edit.php?id=<?=$fase['id']?>" class="btn-2 btn-azul " title="Editar"><i class="fas fa-pen"></i></a>						 
						</div>
					</div>										
					<div class="container-wrap w100">								
						<div class="w20 pd10">Imagen</div>
						<div class="w20 pd10">Titulo del Curso</div>							
						<div class="w20 pd10">Orden a Mostrar</div>							
						<div class="w20 pd10">Estado</div>							
						<div class="w20 pd10">Opciones</div>							
					</div>	
						<?php 
						$cursos = selectfasestocursos($db, 'fases', 'cursos', $fase['id']);        
							if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):
								while($curso = mysqli_fetch_assoc($cursos)):  
						?> 
						<div class="accordion">
							<div class="content-accordion">
								<div class="btn-accordion"><i class="fas fa-chevron-up"></i></div>
								<div class="box-label">
									<div class="w20 al-ct">
										<?php if($curso['imagen'] != null) :?>
											<img src="assets/img/cursos/<?php echo $curso['imagen'] ?>" alt="">
										<?php else : ?>
											<img src="assets/img/cursos/example.PNG" alt="">
										<?php endif; ?>			
									</div>
									<div class="w20 al-ct"><?php echo $curso['nombrecurso'] . '<br>'. $curso['descripcion'] ?></div>							
									<div class="w20 al-ct"><?php echo $curso['orden']?></div>							
									<div class="w20 al-ct">								
										<?php if($curso['estado_id'] == 2) :?>
											<a href="models/updates/cursos-public.php?id=<?=$curso['id']?>" class="btn-3" title="No publicado">							
											<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Inactivo</a>												
										<?php else : ?>
											<a href="models/updates/cursos-private.php?id=<?=$curso['id']?>" class="btn-3" title="Activo">							
											<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</a>												
										<?php endif; ?>	
									</div>							
									<div class="w20 al-ct">										
										<a href="curso-content.php?id=<?=$curso['id']?>" class="btn-2 btn-azul" title="Ver Curso"><i class="far fa-eye"></i></a>
										<a href="curso-content-add.php?id=<?=$curso['id']?>" class="btn-2 btn-azul" title="Añadir contenido"><i class="fas fa-plus"></i></a>
										<a href="curso-edit.php?id=<?=$curso['id']?>" class="btn-2 btn-azul" title="Editar curso"><i class="fas fa-pen"></i></a>
										<a href="models/deletes/curso-contenido-delete.php?id=<?=$curso['id']?>" class=" btn-2" title="Borrar curso" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
									</div>
								</div>
								<div class="inner-content-accordion">
									<?php 										
											$contenidos = obtenerContenidoCurso($db, 'cursos_contenido', $curso['id']);        
										if(!empty($contenidos) && mysqli_num_rows($contenidos) >= 1):
											while($contenido = mysqli_fetch_assoc($contenidos)):  
									?> 
									<div class="inner-curso-content">
										<div class="w20 al-ct"><?php echo $contenido['nombre'] ?></div>
										<div class="w20 al-ct"><?php echo $contenido['descripcion'] ?></div>
										<div class="w20 al-ct"><?php echo $contenido['orden'] ?></div>
										<div class="w20 al-ct">								
											<?php if($contenido['estado_id'] == 2) :?>
												<a href="models/updates/contenido-public.php?id=<?=$contenido['id']?>" class="btn-3" title="No publicado">							
												<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
												Inactivo</a>												
											<?php else : ?>
												<a href="models/updates/contenido-private.php?id=<?=$contenido['id']?>" class="btn-3" title="Activo">							
												<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</a>												
											<?php endif; ?>	
										</div>
										<div class="w20 al-ct">										
											<!-- <a href="curso-content.php?id=<?//=$contenido['id']?>" class="btn-2 btn-azul" title="Ver contenido"><i class="far fa-eye"></i></a> -->
											<a href="curso-details-add.php?id=<?=$contenido['id']?>" class="btn-2 btn-azul" title="Añadir contenido"><i class="fas fa-plus"></i></a>
											<a href="curso-content-edit.php?id=<?=$contenido['id']?>" class="btn-2 btn-azul" title="Editar contenido"><i class="fas fa-pen"></i></a>
											<a href="models/deletes/curso-contenido.php?id=<?=$contenido['id']?>" class=" btn-2" title="Borrar" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
										</div>
									</div>
									<?php 
										endwhile;
										endif; 
									?>
								</div>																					
							</div>
							</div>
						<?php 
							endwhile;
							endif; 
						?>
				</div>					
				<?php endwhile; endif; ?>

				<?php if(isset($_SESSION['completado'])): ?>
					<div class="alerta-exito">
						<?=$_SESSION['completado']?>  
					</div>
				<?php elseif(isset($_SESSION['fallo'])): ?>
					<div class="alerta-error">
						<?=$_SESSION['fallo']?>
					</div>
				<?php endif; ?> 
			</div>
			<!--fin center  -->
			<?php borrarErrores(); ?>		
		</div>
	</section>

	<?php include 'layout/footer.php'; ?>
  </body>
</html>