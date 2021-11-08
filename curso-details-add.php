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
					<?php 
						$cursos = obtenerdatos($db, 'cursos_contenido', $id);
						if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):
							while($curso = mysqli_fetch_assoc($cursos)):
					?>
					<h1 class="title">Añadir Contenido al <?=$curso['nombre']?>	</h1>
					<?php 
							endwhile;
						endif;
						?>
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
						<form action="models/add/cursos-details-add.php" class="box-formulario" enctype="multipart/form-data" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="w100 mg-bt50">
									<div class="box-input">
										<label for="nombre">Titulo : </label>			
										<input class="w100" type="hidden" name="id" value="<?=$id?>" >
										<input class="w100" type="text" name="nombre" >
									</div>
									<div class="box-input">
										<label for="descripcion">Descripción: </label>
										<textarea name="descripcion" id="" cols="30" rows="5"></textarea>
										
									</div>
								</div>
								<div class="w100 mg-bt50">
									<h2 class="title">Video o URL HTML</h2>		
									<div class="box-input">
										<label for="video">Subir Video: </label>			
										<input class="w100" type="file" name="video">
									</div>
									<div class="box-input">
										<label for="url">HTML: </label>					
										<textarea name="url_video" cols="30" rows="5"></textarea>
									</div>								
								</div>
								<div class="w100 mg-bt50">
									<h2 class="title">Contenido Extra</h2>	
									<div class="box-input">
										<label for="nombre">Archivo: (Puede seleccionar 2 o más con CRTL) </label>	
										<input class="w100" type="file" name="archivo[]" multiple>
									</div>
									<div class="box-input">
										<label for="descripcion">Descripcion Archivo: </label>
										<textarea name="descripcion_archivo" cols="30" rows="5"></textarea>		
									</div>					
								</div>

								<div class="w100 mg-bt50">
									<h2 class="title">Lectura Complementaria</h2>						
									<div class="box-input">
										<label for="url">URL / Enlace: </label>
										<input type="url" name="url_articulo">									
									</div>
									<div class="box-input">
										<label for="nombre_articulo">Nombre del Articulo: </label>		
										<input class="w100" type="text" name="nombre_articulo" >
									</div>
									<div class="box-input">
										<label for="descripcion_articulo">Descripción Articulo: </label>
										<textarea name="descripcion_articulo" id="" cols="30" rows="5"></textarea>
										
									</div>
								</div>
								<div class="w100">
									<div class="box-input">
										<label for="etiquetas">Etiquetas (separado por comas): </label>	
										<input class="w100" type="text" name="etiquetas" >
									</div>
								</div>
								<div class="w100 mg-bt50">
									<div class="box-input">
										<label for="orden">Orden a Mostrar: </label>	
										<input class="w100" type="number" name="orden" value="1" min="1">
									</div>
								</div>
							</div>						
							<input type="submit" value="Añadir" class="btn" name="">				
							
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