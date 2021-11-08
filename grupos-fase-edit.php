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
					<h1 class="title">Administrar Grupo </h1>					
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
					<div class="inner-content mg-bt20 w50">												
						<form action="models/updates/upgrupos-fase.php" class="box-formulario"  method="post">
							<h3 class="title">Editar </h3>
								<?php 
									$datos = obtenerdatos($db, 'grupos_fases', $id);
									if(!empty($datos) && mysqli_num_rows($datos) >= 1):
										while($dato = mysqli_fetch_assoc($datos)):
								?>											
								<div class="w100 container-wrap mg-bt10">									
									<div class="box-input-checkbox">
										<label for="">Seleccionar Fases: </label>									
										<input type="hidden" name="id" value="<?=$dato['id']?>" checked >
										<input type="checkbox" name="fase" class="w30" value="<?=$dato['fase_id']?>" checked ><?=$dato['fase_id']?>	
									</div>							
									<div class="box-input">
										<label for="fecinicio">Fecha Inicio: </label>		
										<input class="w100" type="date" name="fecinicio" value="<?=$dato['fec_inicio']?>" >
									</div>							
									<div class="box-input">
										<label for="fecfin">Fecha Termino: </label>		
										<input class="w100" type="date" name="fecfin" value="<?=$dato['fec_fin']?>" >
									</div>																
									<div class="box-input">
										<label for="descripcion">Estado : </label>								
										<select name="acceso" > 
											<option value="3" <?=($dato['acceso_id'] == 3) ? 'selected="selected"' : '' ?> >Activo</option>
											<option value="4" <?=($dato['acceso_id'] == 4) ? 'selected="selected"' : '' ?>>Bloqueado</option>
										</select>
									</div>																			
									<div class="box-input">
										<label for="descripcion">Descripción / Observación: </label>
										<textarea class="w100" rows="3" name="descripcion" ><?=$dato['descripcion']?> </textarea>
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
			
			<?php borrarErrores(); ?>		
		</div>
		</section>
	<?php include 'layout/footer.php'; ?>
</div>
</main>

<script>

</script>