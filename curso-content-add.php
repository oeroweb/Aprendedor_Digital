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
						$cursos = obtenerdatos($db, 'cursos',$id);
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
						<form action="models/add/cursos-content-add.php" class="box-formulario" method="post">
							<div class="w100 container-wrap mg-bt10" >
								<div class="box-input">
									<input class="w100" type="hidden" name="id" value="<?=$id?>">
									<label for="nombre">Nombre del Capitulo: </label>		
									<input class="w100 inputnombre" type="text" name="nombre" maxlength="200">
									<span class="counter counterNombre">200</span>
								</div>
								<div class="box-input">
									<label for="descripcion">Breve Descripcion: </label>
									<textarea name="descripcion" class="textdescripcion" rows="5" maxlength="500"></textarea>
									<span class="counter-2 counterDescripcion">500</span>
								</div>										
								<div class="box-input">
									<label for="nombre">Orden a mostrar: </label>
									<input class="w100" type="number" name="orden" value="1" min="1">
								</div>													
							</div>						
							<input type="submit" value="Añadir y Guardar" class="btn" >				
							
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