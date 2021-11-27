<?php 
  include 'layout/header.php';
	if(!isset($_POST)){		
		header("Location:setting.php");
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
								$datos = obtenerdatos($db, 'eventos', $id);        
								if(!empty($datos) && mysqli_num_rows($datos) >= 1):
									while($dato = mysqli_fetch_assoc($datos)):  
						?> 			
					<h1 class="title">Editar Evento : <?=$dato['titulo']?> </h1>		
					<?php endwhile; endif; ?>			
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
						<?php 
								$datos = obtenerdatos($db, 'eventos', $id);        
								if(!empty($datos) && mysqli_num_rows($datos) >= 1):
									while($dato = mysqli_fetch_assoc($datos)):  
						?> 
						<form action="models/updates/upeventos.php" enctype="multipart/form-data" class="box-formulario" method="post">
							<div class="w100 container-wrap mg-bt10" >
							<input class="w100" type="hidden" name="id" value="<?php echo $dato['id']; ?>">
							<input class="w100" type="hidden" name="carpeta" value="<?php echo $dato['carpeta']; ?>">
								<div class="box-input w50">
									<label for="archivo">Publicar para: </label>
									<select name="grupo_id" id="grupo_id">						
										<option value="">Seleccionar Grupo</option>
										<option value="0">Todos</option>
										<?php 
											$grupos = selectalldatos($db, 'grupos');
											if(!empty($grupos) && mysqli_num_rows($grupos) >= 1):
												while($grupo = mysqli_fetch_assoc($grupos)):
										?>
											<option value="<?=$grupo['id']?>" <?=($grupo['id']) == $dato['grupo_id'] ? 'selected="selected"': '' ?>>
												<?=$grupo['nombre']?>								
											</option>
										<?php 
											endwhile;
										endif;
										?>	
									</select>
								</div>
								<div class="box-input ">
									<label for="fecha">Fecha del Evento: </label>					
									<input type="datetime-local" name="fechaevento" id="fechaevento" value="<?=$dato['fechaevento']?>" required>
								</div>	
								<div class="box-input ">										
									<label for="titulo">Titulo del Evento: </label>		
									<input class="w100 inputnombre" type="text" name="titulo" id="titulo" maxlength="200" value="<?=$dato['titulo']?>">
									<span class="counter counterNombre">250</span>
								</div>
								<div class="box-input ">
									<label for="descripcion">Descripcion / Mensaje: </label>
									<textarea name="descripcion" class="textdescripcion" rows="5" id="descripcion" maxlength="500"><?=$dato['texto']?></textarea>
									<span class="counter-2 counterDescripcion">250</span>
								</div>										
								<div class="box-input ">
									<label for="link">Link o Iframe: </label>
									<textarea name="link" class="textdescripcion" id="link" rows="3" maxlength=""><?=$dato['link']?></textarea>
								</div>													
								
								<div class="box-input">
									<label for="">Cambiar Imagen:</label>
									<input class="w100" type="hidden" name="imagenActual" value="<?php echo $dato['imagen']; ?>">
									<img src="assets/eventos/<?php echo $dato['carpeta'].'/'.$dato['imagen'] ?>" alt=""><hr class="w100 mg-bt10">									
									<input class="w100" type="file" name="imagen" >
								</div>																				
															
								<div class="box-input">		
								<input class="w100" type="hidden" name="archivosActual" value="<?php echo $dato['archivos']; ?>">
								<?php if($dato['archivos'] != "") : ?>							
									<label for="archivo">Cambiar Archivos:  (Puede seleccionar 2 o más con CRTL) </label>										
									<?php $misarchivos = $dato['archivos'];																			
										$array_misarchivos = explode(', ', $misarchivos); 
										
										foreach( $array_misarchivos as $archivo) : ?>	

											<a href="assets/eventos/<?php echo $dato['carpeta'].'/'.$archivo; ?>" class="btn-file" target="_blank"> <i class="fas fa-file"></i> <?=$archivo?></a>
										<?php endforeach; ?>	
									<?php else : ?>
										<label for="archivo">Añadir Archivo:  (Puede seleccionar 2 o más con CRTL) </label>										
									<?php endif; ?>
									<input type="file" name="archivo[]" multiple>				
									
								</div>
							<?php 
									endwhile;
								endif;
								?>		
							<input type="submit" value="Modificar y Guardar" class="btn" >
											
			
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

<script>

const input = document.querySelector("form .inputnombre"), 
	maxlength = input.getAttribute("maxlength"),
	counter = document.querySelector("form .counterNombre"), 
	textarea = document.querySelector("form .textdescripcion"), 
  maxlengtharea = textarea.getAttribute("maxlength"),
	counterarea = document.querySelector("form .counterDescripcion"); 

  input.onkeyup = () =>{
    counter.innerText = maxlength - input.value.length;
  }
  textarea.onkeyup = () =>{
    counterarea.innerText = maxlengtharea - textarea.value.length;
  }

</script>