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

				<div class="box-info">
					<p class="text"> <i class="fas fa-info-circle"></i> Puede añadir 1 o más fases a la vez presionando el botón de Guardar.</p>								
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
						<form action="" class="box-formulario" method="post">
							<h3 class="title">Añadir nueva fase</h3>
							<div id="info"></div>										
							<div class="w100 container-wrap mg-bt10">	
								<input type="hidden" name="grupo" id="grupo" value="<?=$id?>">
								<div class="box-info">
									<p class="text2"> <i class="fas fa-info-circle"></i> Las fases seleccionadas son las fases existentes de esté grupo, antes de añadir nueva(s) fases <input type="checkbox" > <strong> deseleccione </strong> las fases existentes  y <input type="checkbox" checked><strong> seleccione </strong> las nuevas fases que necesite.</p>
								</div>		
								<div class="w100">
									<label for="">Seleccionar fase(s) : </label>
								</div>
									<?php 
										$fases = selectalldatos($db, 'fases');
											if(!empty($fases) && mysqli_num_rows($fases) >= 1):
												while($fase = mysqli_fetch_assoc($fases)):	
													$idfase = $fase['id'];
													$sql = "SELECT * FROM grupos_fases WHERE fase_id = $idfase and grupo_id = $id";
													$faseExistentes = mysqli_query($db, $sql);						
									?>											
									<div class="box-input-checkbox ">
										<input type="checkbox" name="fases" class="fases" value="<?=$fase['id']?>" 		
											<?php foreach($faseExistentes as $faseExistente) :										
												echo $faseExistente['fase_id'] == $fase['id'] ? 'checked' : '' ?>
											<?php endforeach; ?>
										>
										<span class="label-checkbox"><?=$fase['nombre']?>	</span>
									</div>							
								<?php endwhile; endif; ?>
								<div class="w100"></div>
								<div class="w50">
									<div class="box-input">
										<label for="fecinicio">Fecha Inicio: </label>		
										<input class="w100" type="date" name="fecinicio" id="fecinicio" value="<?=date('Y-m-d');?>">
									</div>
								</div>
								<div class="w50">
									<div class="box-input">
										<label for="fecfin">Fecha Termino: </label>		
										<input class="w100" type="date" name="fecfin" id="fecfin"
										value="<?php 
											$fecha_actual = date('Y-m-d');
											echo date('Y-m-d', strtotime($fecha_actual. "+ 1 month"));
										?>">
									</div>
								</div>																	
								<div class="box-input">
									<label for="descripcion">Descripción / Observación: </label>
									<textarea class="w100" rows="3" name="descripcion" id="descripcion" ></textarea>
								</div>
								<div class="box-input ">
									<label for="acceso">Estado de la Fase: </label>
									<select name="acceso" id="acceso"> 
										<option value="3" selected>Activo</option>
										<option value="4">Bloqueado</option>
									</select>
								</div>

							</div>
							<input type="button" value="Guardar" class="btn" id="guardar-fases" >
							<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i>Ir Atras</a>
						</form>
						
						<?php if(isset($_SESSION['completado'])): ?>
							<div class="alerta-exito">
								<?=$_SESSION['completado']?>  
							</div>
						<?php elseif(isset($_SESSION['fallo'])): ?>
							<div class="alerta-error">
								<?=$_SESSION['fallo']?>
							</div>
						<?php endif; ?> 
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

	$(document).ready(function(){

		$("#guardar-fases").click(function(){
			var ids_array = [];
			var idGrupo = $("#grupo").val();
			var fechaInicio = $("#fecinicio").val();
			var fechaFin = $("#fecfin").val();
			var descripcion = $("#descripcion").val();
			var idAcceso = $("#acceso").val();
			$("input:checkbox[class=fases]:checked").each(function () {
				ids_array.push($(this).val());
			});

			if (ids_array.length>0) {
				console.log(ids_array, idGrupo, fechaInicio, fechaFin, descripcion, idAcceso);
				url = "models/add/grupos-fase-add.php";			
				$.ajax({
					type: "POST",
					url: url,
					data: {ids_array : ids_array, idGrupo : idGrupo, fechaInicio : fechaInicio, fechaFin : fechaFin, descripcion : descripcion, idAcceso : idAcceso},
					success: function(respuesta){
						console.log(respuesta);
						var info = $("#info");
						if(respuesta == "true"){
							info.html("<div class='alerta-exito'>El registro se creo de forma exitosa</div>");
						}else{
							info.html("<div class='alerta-error'>Error al registrar; por favor volver a intentar</div>");
						}
						//refresh();
					}			
				}); 
			}else{
				var info = $("#info");
				info.html("<div class='alerta-error'>Debe seleccionar una fase</div>");
			}
		});
	});

	function refresh() {
    setTimeout(function () {
			location.reload();
    }, 2000);
	}

</script>