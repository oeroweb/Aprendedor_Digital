<?php 
  include 'layout/header.php';

	$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
	$usuario_perfil = $_SESSION['sesion_aprenDigital']['perfil_id'];

	if($usuario_perfil >= 3){
		header("Location:dashboard.php");
	}
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
					<h1 class="title">Administración Instituciones</h1>
					<div class="box-botones">
						<a class="btn" href="javascript:history.back()" title="Atras"><i 	class="fa fa-undo"></i> Regresar</a>	
					</div>
				</div>
				<div class="box-botones">						
					<a href="instituciones-add.php" class="btn" title="Añadir Curso"><i class="fas fa-plus"></i> Añadir Nueva Institución</a>							 
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
					<div class="box-tabla mg-bt20 w100">					
						<table class="w100">
							<thead>
								<tr>
									<th class="w10 pd10">Id</th>
									<th class="w20 pd10">Nombre de la Institución</th>
									<th class="w20 pd10">Pais</th>									
									<th class="w20 pd10">Dirección</th>
									<th class="w20 pd10">Estado</th>
									<th class="w10 pd10">Opciones</th>
								</tr>
							</thead>

							<tbody>	
							<?php 
								$datos = selectalldatos($db, 'instituciones');        
								if(!empty($datos) && mysqli_num_rows($datos) >= 1):
									while($dato = mysqli_fetch_assoc($datos)):    
							?> 
								<tr>
									<td ><?php echo $dato['id']?></td>
									<td class=" al-ct"><?php echo $dato['nombre']?></td>		
									<td class=" al-ct"><?php echo $dato['pais']?></td>			
									<td class=" al-ct"><?php echo $dato['direccion']?></td>
									<td class=" al-ct">									
										<?php if($dato['estado_id'] == 2) :?>
											<a href="models/updates/instituciones-public.php?id=<?=$dato['id']?>" class="btn-3" title="No publicado">							
											<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Inactivo</a>												
										<?php else : ?>
											<a href="models/updates/instituciones-private.php?id=<?=$dato['id']?>" class="btn-3" title="Activo">							
											<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</a>												
										<?php endif; ?>										
									</td>							
									<td class="al-ct">									
										<a href="instituciones-edit.php?id=<?=$dato['id']?>" class="btn-2 btn-azul" title="Editar"><i class="fas fa-pen"></i></a>
										<a href="models/deletes/instituciones-delete.php?id=<?=$dato['id']?>" class="btn-2" title="Borrar" onclick="confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
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
	<span class="ir-arriba hidden" id="btnArriba" title="Subir"><i class="fa fa-chevron-up"></i></span>

	<?php include 'layout/footer.php'; ?>
  </body>
</html>