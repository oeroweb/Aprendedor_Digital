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
				<h1 class="title">Administración de Grupos / Estados de Grupo</h1>
				
				</div>
				<div class="box-botones">						
					<a href="grupos-add.php" class="btn" title="Añadir Grupo"><i class="fas fa-plus"></i> Crear Nuevo Grupo</a>					 
										 
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
				
				<div class="admin-cursos-content container-wrap w100">												
					<div class="container-wrap w100">								
						<div class="w10 al-ct ">Items</div>
						<div class="w20 al-ct ">Nombre de Grupo</div>							
						<div class="w20 al-ct">Descripción</div>							
						<div class="w20 al-ct ">Estado</div>							
						<div class="w30 al-ct ">Opciones</div>							
					</div>	
						<?php 
							$contador = 0;
							$datos = selectalldatos($db, 'grupos');        
								if(!empty($datos) && mysqli_num_rows($datos) >= 1):
									while($dato = mysqli_fetch_assoc($datos)): 
										$contador = $contador + 1; 
							?> 
						<div class="accordion">
							<div class="content-accordion">
								<div class="btn-accordion"><i class="fas fa-chevron-up"></i></div>
								<div class="box-label">
									<div class="w10 al-ct"><?=$contador?></div>
									<div class="w20 al-ct"><?php echo $dato['nombre']?></div>
									<div class="w20 al-ct"><?php echo $dato['descripcion']?></div>							
									<div class="w20 al-ct">								
									<?php if($dato['estado_id'] == 2) :?>
											<a href="models/updates/grupos-public.php?id=<?=$dato['id']?>" class="btn-3" title="No publicado">							
											<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Inactivo</a>												
										<?php else : ?>
											<a href="models/updates/grupos-private.php?id=<?=$dato['id']?>" class="btn-3" title="Activo">			
											<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</a>												
										<?php endif; ?>	
									</div>							
									<div class="w30 al-ct">										
										<a href="grupos-content.php?id=<?=$dato['id']?>" class="btn-2 btn-azul" title="Ver alumnos"><i class="far fa-eye"></i></a>
										<a href="grupos-usuarios-add.php?id=<?=$dato['id']?>" class="btn-2 btn-azul" title="Añadir Usuarios"><i class="fas fa-users"></i></a>
										<a href="grupos-fases-add.php?id=<?=$dato['id']?>" class="btn-2 btn-azul" title="Añadir Fase"><i class="fas fa-plus"></i></a>
										<a href="grupos-edit.php?id=<?=$dato['id']?>" class="btn-2 btn-azul" title="Editar"><i class="fas fa-pen"></i></a>
										<a href="models/deletes/grupo-delete.php?id=<?=$dato['id']?>" class=" btn-2" title="Borrar" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
									</div>
								</div>

								<div class="inner-content-accordion">
									<div class="container-wrap">
										<div class="w20 al-ct">Fase</div>
										<div class="w20 al-ct">Fecha Inicio</div>
										<div class="w20 al-ct">Fecha Fin</div>
										<div class="w20 al-ct">Estado</div>
										<div class="w20 al-ct">Opciones</div>

									</div>
									<?php 
										$grupos = selecttogrupoId($db, 'grupos_fases', $dato['id']);
										if(!empty($grupos) && mysqli_num_rows($grupos) >= 1):
											while($grupo = mysqli_fetch_assoc($grupos)):
									?>
									<div class="inner-curso-content">
										<div class="w20 al-ct"># Fase <?=$grupo['fase_id']?></div>
										<div class="w20 al-ct"><?=$grupo['fec_inicio']?></div>
										<div class="w20 al-ct"><?=$grupo['fec_fin']?></div>
										<div class="w20 al-ct">								
											<?php if($grupo['acceso_id'] == 4) :?>
												<a href="models/updates/grupos-fase-public.php?id=<?=$grupo['id']?>" class="btn-3" title="No publicado">
												<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Bloqueado</a>													
											<?php else : ?>
												<a href="models/updates/grupos-fase-private.php?id=<?=$grupo['id']?>" class="btn-3" title="Activo">			
												<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</a>																				
											<?php endif; ?>	
										</div>
										<div class="w20 al-ct">
											<a href="grupos-content-fase.php?id=<?=$grupo['id']?>" class="btn-2 btn-azul" title="Ver cursos de la fase"><i class="far fa-eye"></i></a>		
											<a href="grupos-cursos-add.php?id=<?=$grupo['id']?>" class="btn-2 btn-azul" title="Añadir Cursos y Clases"><i class="fas fa-plus"></i></a>			
											<a href="grupos-fase-edit.php?id=<?=$grupo['id']?>" class="btn-2 btn-azul" title="Editar"><i class="fas fa-pen"></i></a>
											<a href="models/deletes/grupo-fase-delete.php?id=<?=$grupo['id']?>" class=" btn-2" title="Borrar" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
										</div>
									</div>
									<?php  endwhile; else : ?>
										<div class="inner-curso-content">
											<p class="parrafo">No hay fases añadidas en este grupo.</p>
										</div>
									<?php  endif; ?>
								</div>																					
							</div>
						</div>
						<?php 
							endwhile;
							endif; 
						?>
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
			</div>
			<!--fin center  -->
			<?php borrarErrores(); ?>		
		</div>
	</section>

	<?php include 'layout/footer.php'; ?>
  </body>
</html>