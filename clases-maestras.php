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
					<h1 class="title">Clases Maestras</h1>					
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
				<?php 
					$fases = selectactivedatos($db, 'fases');        
						if(!empty($fases) && mysqli_num_rows($fases) >= 1):
							while($fase = mysqli_fetch_assoc($fases)):  
				?> 
				<div class="admin-cursos-content container-wrap w100">						
					<div class="box-titles">
						<div class="w50">
							<h2 class="title"><?php echo $fase['nombre']; ?> </h2>
							<p class="text"><?php echo $fase['descripcion']; ?></p>	
						</div>						
					</div>
					<div class="box-clases container-wrap mg-bt20 w100">					
						<?php 
						$cursos = selectactivefasestoclases($db, 'fases', 'clases', $fase['id']);        
							if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):
								while($curso = mysqli_fetch_assoc($cursos)):  
						?> 
							<div class="item-box-clases">
								<div class="box-imagen">
									<?php if($curso['imagen'] != null) :?>
										<img src="assets/clases/<?php echo $curso['carpeta'].'/'.$curso['imagen'] ?>">
									<?php else : ?>
										<img src="assets/img/clases/curso.PNG" alt="">
									<?php endif; ?>
								</div>								
								<div class="box-text">
									<h2 class="title"> Clase Maestra : <?=$curso['nombreclase'] ?></h2> 
									<?php if($curso['descripcion'] )  : ?>
									<?php echo  $curso['descripcion'] ?>
									<?php endif; ?>
								</div>
								
							</div>				
																												
						<?php 
							endwhile;
							else : ?>								
							<div class="w100">
								<h3 class="sinpost">No hay clases para mostrar</h3>
							</div>								
						<?php endif; ?>														
					</div>					
				</div>
				<?php endwhile; endif; ?>			
			
			</div>
			<!--fin center  -->
			<?php borrarErrores(); ?>		
		</div>
	</section>

	<?php include 'layout/footer.php'; ?>
  </body>
</html>