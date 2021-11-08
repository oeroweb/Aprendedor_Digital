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
					<h1 class="title">Editar CLase Maestra</h1>
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
								$datos = obtenerdatos($db, 'clases', $id);        
								if(!empty($datos) && mysqli_num_rows($datos) >= 1):
									while($dato = mysqli_fetch_assoc($datos)):  
						?> 						
						<form action="models/updates/upclase.php" class="box-formulario" enctype="multipart/form-data" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="box-input">
									<label for="nombre">Nombre de la Fase: </label>	
									<input class="w100" type="hidden" name="id" value="<?php echo $dato['id']; ?>">
									<!-- <input class="w100" type="text" name="nombre" value="<?php //echo $dato['nombre']; ?>"> -->
									<input class="w100 inputnombre" type="text" name="nombre" maxlength="200" value="<?php echo $dato['nombre']; ?>">
									<span class="counter counterNombre">200</span>
								</div>
								<div class="box-input">
									<!-- <span class="counter-2 counterDescripcion">500</span> -->
									<label for="descripcion">Descripcion: </label>						
									<textarea name="descripcion" class="textdescripcion" rows="5" maxlength="500"><?php echo $dato['descripcion']; ?></textarea>
								</div>
								<div class="box-input mg-tp20">
									<?php if($dato['imagen']): ?>
									<label for="">Cambiar Imagen:</label>
									<?php else : ?>
										<label for="">Añadir Imagen:</label>
									<?php endif; ?>
									<input class="w100" type="hidden" name="imagen_existente" value="<?php echo $dato['imagen']; ?>">
									<img src="assets/clases/<?php echo $dato['carpeta'].'/'.$dato['imagen'] ?>" alt=""><hr class="w100 mg-bt10">							
									<input class="w100" type="file" name="imagen" >
								</div>							
								<div class="box-input">
									<label for="">Fase: </label>
									<select class="w70" name="fase">
									<?php 
										$fases = selectalldatos($db, 'fases');
										if(!empty($fases) && mysqli_num_rows($fases) >= 1):
											while($fase = mysqli_fetch_assoc($fases)):
									?>
										<option value="<?=$fase['id']?>" <?=($fase['id']) == $dato['fase_id'] ? 'selected="selected"': '' ?>>
											<?=$fase['nombre']?>								
										</option>
									<?php 
										endwhile;
									endif;
									?>																
									</select>									
								</div>
								<div class="box-input">
									<label for="">Cambiar Video:</label>
									<input class="w100" type="hidden" name="video_existente" value="<?php echo $dato['video']; ?>">
									<video class="w90" src="assets/videos/clases/<?php echo $dato['video']?>" controls muted></video>	
									<input type="file" name="video" class="" >
								</div>																		
								<div class="box-input">
									<label for="">Ingresar URL del Video:</label>						
									<textarea name="linkurl" id="" cols="10" rows="5"><?php echo $dato['url']; ?></textarea>
								</div>
								<div class="box-input">
									<label for="orden">Orden a Mostrar: </label>
									<input class="w100" type="number" name="orden" value="<?php echo $dato['orden']; ?>" min="1">
								</div>																		
								<?php 
									endwhile;
								endif;
								?>
							</div>						
							<input type="submit" value="Actualizar Datos" class="btn" name="editarfase" id="" >				
							
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

<script>
	CKEDITOR.replace( 'descripcion' ); 

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