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
						<?php 
							$datos = obtenerdatos($db, 'grupos', $id);
							if(!empty($datos) && mysqli_num_rows($datos) >= 1):
								while($dato = mysqli_fetch_assoc($datos)):
						?>
					<h1 class="title">Administrar el Grupo <?=$dato['nombre']?></h1>
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

				<div class="container-wrap w100">
					<div class="inner-content mg-bt20 w80">												
						<form action="models/add/grupos-fase-add.php" class="box-formulario" method="post">
							<div class="w100 container-wrap mg-bt10">	
								<h3 class="title">Añadir nueva fase</h3>
								<div class="box-input-checkbox w100">
									<input type="hidden" name="grupo" value="<?=$id?>">		
									<label for="">Seleccionar Fases: </label>
										<?php 
											$fases = selectalldatos($db, 'fases');
											if(!empty($fases) && mysqli_num_rows($fases) >= 1):
												while($fase = mysqli_fetch_assoc($fases)):								
										?>											
										<input type="checkbox" name="fase" value="<?=$fase['id']?>"?> <?=$fase['nombre']?>	
										<?php 
											endwhile;
										endif;								
										?>
								</div>							
								<div class="w50">
									<div class="box-input">
										<label for="fecinicio">Fecha Inicio: </label>		
										<input class="w100" type="date" name="fecinicio" value="<?=date('Y-m-d');?>">
									</div>
								</div>
								<div class="w50">
									<div class="box-input">
										<label for="fecfin">Fecha Termino: </label>		
										<input class="w100" type="date" name="fecfin" value="<?=date('Y-m-d');?>">
									</div>
								</div>						
																		
								<div class="box-input">
									<label for="descripcion">Descripción / Observación: </label>
									<textarea class="w100" rows="3" name="descripcion" ></textarea>
								</div>
								<div class="box-input ">
									<label for="acceso">Estado de la Fase: </label>
									<select name="acceso"> 
										<option value="3" selected>Activo</option>
										<option value="4">Bloqueado</option>
									</select>
								</div>

							</div>
							<input type="submit" value="Guardar" class="btn" name="" id="" >
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

<script>

</script>