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
				<?php 
					$cursos = obtenerdatos($db, 'cursos_contenido',$id);
					if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):
						while($curso = mysqli_fetch_assoc($cursos)):
				?>
				<div class="box-titles">
					<h1 class="title">Añadir Contenido al <?=$curso['nombre']?>	</h1>					
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
					<div class="inner-content mg-bt20 mg-auto w70">		
						<form action="models/updates/upcursoscontent.php" class="box-formulario" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="box-input">
									<label for="nombre">Nombre del Capitulo: </label>					
									<input class="" type="hidden" name="id" value="<?=$curso['id']?>" >
									<input class="w100" type="text" name="nombre" value="<?=$curso['nombre']?>" >
								</div>
								<div class="box-input">
									<label for="descripcion">Breve Descripcion: </label>
									<textarea name="descripcion" rows="5"><?php echo $curso['descripcion']; ?></textarea>
								</div>										
								<div class="box-input">
									<label for="nombre">Orden a mostrar: </label>
									<input class="w100" type="number" name="orden" value="<?=$curso['orden']?>" min="1">
								</div>													
							</div>						
							<input type="submit" value="Guardar" class="btn" >				
							
						</form>					
					</div>					
				</div>
				<?php 
							endwhile;
						endif;
						?>
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