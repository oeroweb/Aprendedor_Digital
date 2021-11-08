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
					<h1 class="title">Editar Fase</h1>
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
								$datos = obtenerdatos($db, 'fases', $id);        
								if(!empty($datos) && mysqli_num_rows($datos) >= 1):
									while($dato = mysqli_fetch_assoc($datos)):  
						?> 						
						<form action="models/updates/upfase.php" class="box-formulario" enctype="multipart/form-data" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="box-input">
									<label for="nombre">Nombre de la Fase: </label>	
									<input class="w100" type="hidden" name="id" value="<?php echo $dato['id']; ?>">
									<input class="w100" type="text" name="nombre" value="<?php echo $dato['nombre']; ?>">
								</div>
								<div class="box-input">
									<label for="descripcion">descripcion: </label>
									<input class="w100" type="text" name="descripcion" value="<?php echo $dato['descripcion']; ?>">
								</div>																		
								<?php 
									endwhile;
								endif;
								?>
							</div>					
							<!-- <a href="#" class="btn btn-azul" id="mostrarinput" title="Editar Perfil"><i class='icon ion-edit'></i></a> -->
							<input type="submit" value="Actualizar Datos" class="btn" name="editarfase" id="" >				
							
						</form>						
					</div>
					
				</div>

			</div>	
			<!-- center -->
		
			<?php borrarErrores(); ?>		
		</div>
		</section>
	<?php include 'layout/footer.php'; ?>
</div>
</main>