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
					<h1 class="title">Añadir Nuevo Evento </h1>					
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
						<form action="models/add/eventos-add.php" enctype="multipart/form-data" class="box-formulario" method="post">
							<div class="w100 container-wrap mg-bt10" >
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
											<option value="<?=$grupo['id']?>" >
												<?=$grupo['nombre']?>								
											</option>
										<?php 
											endwhile;
										endif;
										?>	
									</select>
								</div>
								<div class="box-input w50">
									<label for="fecha">Fecha del Evento: </label>					
									<input type="datetime-local" name="fechaevento" id="fechaevento" required>
								</div>	
								<div class="box-input w100">										
									<label for="titulo">Titulo del Evento: </label>		
									<input class="w100 inputnombre" type="text" name="titulo" id="titulo" maxlength="200">
									<span class="counter counterNombre">250</span>
								</div>
								<div class="box-input w100">
									<label for="descripcion">Descripcion / Mensaje: </label>
									<textarea name="descripcion" class="textdescripcion" rows="5" id="descripcion" maxlength="500"></textarea>
									<span class="counter-2 counterDescripcion">500</span>
								</div>										
								<div class="box-input w100">
									<label for="link">Link o Iframe: </label>
									<textarea name="link" class="textdescripcion" id="link" rows="3" maxlength=""></textarea>
								</div>													
								<div class="box-input w50">
									<label for="imagen">Imagen: </label>
									<input type="file" name="imagen" id="imagen">
								</div>													
								<div class="box-input w50">
									<label for="archivo">Archivo: (Puede seleccionar 2 o más con CRTL)</label>
									<input type="file" name="archivo[]" id="archivo" multiple>
								</div>																		
							</div>											
							<input type="submit" value="Añadir y Guardar" class="btn">			
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