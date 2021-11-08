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
						$cursos = obtenerdatos($db, 'cursos_contenido_detalle', $id);
						if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):
							while($curso = mysqli_fetch_assoc($cursos)):
					?>
					<h1 class="title">Editar Contenido <?=$curso['nombre']?>	</h1>
					
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
						<form action="models/updates/upcurso-details.php" class="box-formulario" enctype="multipart/form-data" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="w100 mg-bt50">
									<div class="box-input">
										<label for="nombre">Titulo : </label>			
										<input class="w100" type="hidden" name="id" value="<?=$curso['id']?>" readonly>
										<input class="w100" type="hidden" name="contenido_id" value="<?=$curso['cursoContenido_id']?>" readonly>
										<input class="w100" type="text" name="nombre" value="<?=$curso['nombre']?>">
									</div>
									<div class="box-input">
										<label for="descripcion">Descripción: </label>
										<textarea name="descripcion" rows="4"><?=$curso['descripcion']?></textarea>						
									</div>
								</div>
								<div class="w100 mg-bt50">
									<h2 class="title">Video o URL HTML</h2>		
									<div class="box-input">
										<label for="video">Subir Video: </label>
										<video class="w100" src="assets/cursos/<?php echo $curso['video']?>" controls muted preload="auto"></video>
										<input type="hidden" name="video_existente" value="<?=$curso['video']?>" readonly>
										<input class="w100" type="file" name="video">
									</div>
									<div class="box-input">
										<label for="url">HTML: </label>					
										<textarea name="url_video" rows="5"><?=$curso['url_video']?></textarea>
									</div>								
								</div>
								<div class="w100 mg-bt50">
									<h2 class="title">Contenido Extra</h2>	
									<div class="box-input">
										<label for="nombre">Archivo: (Puede seleccionar 2 o más con CRTL) </label>
										<input class="w100" type="hidden" name="archivos_existentes" value="<?=$curso['archivos']?>" readonly>	
										<input class="w100" type="file" name="archivo[]" multiple>
									</div>
									<div class="box-input">
										<label for="descripcion">Descripcion Archivo: </label>
										<textarea name="descripcion_archivo" cols="30" rows="5" ><?=$curso['descripcion_archivo']?></textarea>	
									</div>					
								</div>

								<div class="w100 mg-bt50">
									<h2 class="title">Lectura Complementaria</h2>						
									<div class="box-input">
										<label for="url">URL / Enlace: </label>
										<input type="url" name="url_articulo" value="<?=$curso['url_articulo']?>">									
									</div>
									<div class="box-input">
										<label for="nombre_articulo">Nombre del Articulo: </label>		
										<input class="w100" type="text" name="nombre_articulo" value="<?=$curso['nombre_articulo']?>">
									</div>
									<div class="box-input">
										<label for="descripcion_articulo">Descripción Articulo: </label>
										<textarea name="descripcion_articulo" id="" cols="30" rows="5" ><?=$curso['descripcion_articulo']?></textarea>
										
									</div>
								</div>
								<div class="w100">
									<div class="box-input">
										<label for="etiquetas">Etiquetas (separado por comas): </label>	
										<input class="w100" type="text" name="etiquetas" value="<?=$curso['etiquetas']?>">
									</div>
								</div>
								<div class="w100 mg-bt50">
									<div class="box-input">
										<label for="orden">Orden a Mostrar: </label>	
										<input class="w100" type="number" name="orden" value="<?=$curso['orden']?>" min="1">
									</div>
								</div>								
							</div>	
							<?php 
								endwhile;
							endif;
							?>					
							<input type="submit" value="Guardar" class="btn" >				
							
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