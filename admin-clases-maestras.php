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
					<h1 class="title">Administración Clases Maestras</h1>
					<div class="box-botones">
						<a class="btn" href="admin-cursos.php" title="Atras"><i class="fas fa-arrow-left"></i></a>	 
					</div>
				</div>
				<div class="box-botones">						
					<a href="clases-add.php" class="btn" title="Añadir Curso"><i class="fas fa-plus"></i> Añadir Nueva Clase Maestra</a>	
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
							<p class="text"><?=$fase['descripcion']?></p>								
						</div>
						<div class="w30 al-ct">								
							<?php if($fase['estado_id'] == 2) :?>
								<a href="models/updates/fases-public-2.php?id=<?=$fase['id']?>" class="btn-3" title="No publicado">							
								<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
								Inactivo</a>												
							<?php else : ?>
								<a href="models/updates/fases-private-2.php?id=<?=$fase['id']?>" class="btn-3" title="Activo">							
								<img src="assets/fonts/toggle-on.svg" alt="activo">	
								Activo</a>												
							<?php endif; ?>	
						</div>	
						<div class="">						
							<a href="fase-edit.php?id=<?=$fase['id']?>" class="btn-2 btn-azul " title="Editar"><i class="fas fa-pen"></i></a>					 
						</div>
					</div>
					<div class="box-tabla mg-bt20 w100">					
						<table class="w100">
							<thead >
								<tr>
									<th class="w10 pd10">Orden a mostrar</th>
									<th class="w20 pd10">Video</th>
									<th class="w20 pd10">Imagen</th>
									<th class="w20 pd10">Titulo de la Clase</th>
									<th class="w10 pd10">Estado</th>
									<th class="w20 pd10">Opciones</th>
								</tr>
							</thead>

							<tbody>	
							<?php 
							$cursos = selectfasestoclases($db, 'fases', 'clases', $fase['id']);        
								if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):
									while($curso = mysqli_fetch_assoc($cursos)):  
							?> 
								<tr>
									<td class=""> <?=$curso['orden']?> 	</td>	
									<td class="">										
										<?php if($curso['video'] != null) :?>
											<video class="" src="assets/videos/clases/<?php echo $curso['video']?>" controls muted preload="auto"></video>							
										<?php else : ?>
											<?php echo $curso['url'] ?>
										<?php endif; ?>
									</td>
									<td class="">										
									<?php if($curso['imagen'] != null) :?>
										<img src="assets/clases/<?php echo $curso['carpeta'].'/'.$curso['imagen'] ?>">
									<?php else : ?>
										<img src="assets/img/clases/curso.PNG" alt="">
									<?php endif; ?>
									</td>
									<td class="">
										<h3 class="title al-ct"><?=$curso['nombreclase']?> </h3>
										<div class="text">
											<?php if(strlen($curso['descripcion']) > 50) : ?>
												<?=substr($curso['descripcion'],0,180)."..."?>
											<?php else : ?>
												<?=$curso['descripcion']?>
												<?php endif ?>
										</div>
									</td>															
									<td class="al-ct">								
										<?php if($curso['estado_id'] == 2) :?>
											<a href="models/updates/clases-public.php?id=<?=$curso['id']?>" class="btn-3" title="No publicado">							
											<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Inactivo</a>												
										<?php else : ?>
											<a href="models/updates/clases-private.php?id=<?=$curso['id']?>" class="btn-3" title="Activo">			
											<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</a>												
										<?php endif; ?>	
									</td>							
									<td class=" al-ct">									
										<a href="clase-edit.php?id=<?=$curso['id']?>" class="btn-2 btn-azul" title="Editar"><i class="fas fa-pen"></i></a>
										<a href="models/deletes/clase-delete.php?id=<?=$curso['id']?>" class=" btn-2" title="Borrar" onclick="confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
									</td>							
								</tr>						
								<?php 
									endwhile;
									else : ?>
								<tr>
									<td colspan="4" class="al-ct">
										<h2 class="sinpost">No hay publicaciones que mostrar</h2>
									</td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>								
					</div>					
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