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
					<h1 class="title">Añadir Grupo</h1>
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
						<form action="models/add/grupos-add.php" class="box-formulario" enctype="multipart/form-data" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="box-input">
									<label for="nombre">Nombre del Grupo: </label>					
									<input class="w100" type="text" name="nombre" required>	
								</div>
								<div class="box-input">
									<label for="descripcion">Descripción: </label>									
									<textarea name="descripcion" rows="5"></textarea>
								</div>		
							</div>						
							<input type="submit" value="Añadir Grupos" class="btn">
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