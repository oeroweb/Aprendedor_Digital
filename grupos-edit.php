<?php 
  include 'layout/header.php'; 
	if(!isset($_POST)){		
		header("Location:admin-grupos.php");
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
					<h1 class="title">Editar Grupo</h1>
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
					<div class="inner-content mg-bt20 w40">
						<?php 
								$datos = obtenerdatos($db, 'grupos', $id);        
								if(!empty($datos) && mysqli_num_rows($datos) >= 1):
									while($dato = mysqli_fetch_assoc($datos)):  
						?> 												
						<form action="models/updates/upgrupos.php" class="box-formulario" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="box-input">
									<label for="nombre">Nombre del Grupo: </label>					
									<input class="w100" type="hidden" name="id" value="<?php echo $dato['id'] ?>">	
									<input class="w100" type="text" name="nombre" value="<?php echo $dato['nombre']; ?>">	
								</div>
								<div class="box-input">
									<label for="descripcion">Descripción: </label>									
									<textarea name="descripcion" rows="5"><?php echo $dato['descripcion']; ?></textarea>
								</div>		
							</div>	
							<?php 
									endwhile;
								endif;
								?>					
							<input type="submit" value="Editar Grupo" class="btn">
						</form>						
					</div>					
				</div>
			</div>	
			
			<?php borrarErrores(); ?>		
		</div>
		</section>
	<?php include 'layout/footer.php'; ?>
</div>
</main>