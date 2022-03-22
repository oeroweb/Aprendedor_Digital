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
				<?php 
					$grupos = obtenerdatos($db, 'grupos_fases', $id);        
						if(!empty($grupos) && mysqli_num_rows($grupos) >= 1):
							while($grupo = mysqli_fetch_assoc($grupos)):  
					?> 
				<div class="box-titles">
					<h1 class="title">Añadir Cursos y Clases Maestras </h1>
					<h2></h2>				
					<div class="box-botones">						
						<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>
					</div>
				</div>

				<div class="grupos-content-grupos">
					<div class="tabs-content-grupos">
						<input type="radio" name="grupos" id="cursos" checked>
            <input type="radio" name="grupos" id="clases">
						<div class="tabs-nav">
							<label for="cursos" class="cursos">Cursos</label>
							<label for="clases" class="clases">Clases Maestras</label>
						</div>
						<section>
							<div class="content content-1">															
								<div class="box-tabla mg-bt50 w100">
									<div class="box-titles">
										<h1 class="title">Lista de curso por fase</h1>					
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
									<div id="info"></div>
									<div class="box-info">
										<p class="text"> <i class="fas fa-info-circle"></i> Puede seleccionar todo los cursos o los que se desean para esta fase.</p>
									</div>
									<div class="box-botones">
										<input type="button" class="btn-1" id="btnseleccionar" value="Seleccionar Todos">
										<input type="button" class="btn-1" id="btndeseleccionar" value="Deseleccionar Todos">
										<a class="btn" id="anadir-cursos"><i class="fas fa-plus"></i> Añadir Cursos</a>
									</div>											
									<table id="dt_cursos" class="w100">
										<thead>
											<tr>						
												<th class="w10">SELECCIONAR</th>							
												<th class="w10">FASE #</th>							
												<th class="w30">NOMBRE DEL CURSO</th>					
												<th class="w20">DESCRIPCIÓN DEL CURSO</th>
												<th class="w20">IMAGEN</th>										
											</tr>
										</thead>
										<tbody>		
											<input type="hidden" name="grupofase_id" value="<?=$id?>" id="grupofase_id">						
											<?php 
												$datos = obtenerallcursosporgrupoyfase($db, 'grupos_fases','cursos', $grupo['fase_id'], $grupo['grupo_id']);        
												if(!empty($datos) && mysqli_num_rows($datos) >= 1):
													while($data = mysqli_fetch_assoc($datos)):									
											?> 												
												<tr id="<?php echo $data['id']; ?>">						
													<td >													
														<input type="checkbox" name="ids[]" value="<?php echo $data['id']; ?>" <?php  ?> class="users"> 
													</td>
													<td>Fase <?php echo $data['fase_id']; ?> </td>
													<td><?php echo $data['nombre']; ?> </td>
													<td>
														<?php if(strlen($data['descripcion']) > 60) : ?>
															<?=substr($data['descripcion'],0,100)."..."?>
														<?php else : ?>
															<?=$data['descripcion']?>
														<?php endif ?>
													</td>
													<td>
														<?php if($data['imagen']) : ?>
															<img src="assets/img/cursos/<?=$data['imagen']?>" alt="Imagen Curso <?=$data['nombre']?>">
															<?php else : ?>
																<img src="assets/img/example_cursos.jpg" alt="Imagen del Curso <?=$data['nombre']?>">
															<?php endif ?>
													</td>										
												</tr>
											<?php	endwhile;
											else : ?>
												<tr>
													<td colspan="4">No hay cursos para mostrar.</td>
												</tr>
											<?php endif; ?>										
										</tbody>
									</table>
									<!-- FIN TABLA -->					
								</div>										
							</div>

							<div class="content content-2">															
								<div class="box-tabla mg-bt50 w100">
									<div class="box-titles">
										<h1 class="title">Lista de clases maestras por fase</h1>				
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
									<div id="info"></div>
									<div class="box-info">
										<p class="text"> <i class="fas fa-info-circle"></i> Puede seleccionar todas las clases o los que se desean para esta fase.</p>
									</div>
									<div class="box-botones">
										<input type="button" class="btn-1" id="btnseleccionar-2" value="Seleccionar Todos">
										<input type="button" class="btn-1" id="btndeseleccionar-2" value="Deseleccionar Todos">
										<a class="btn" id="anadir-clases"><i class="fas fa-plus"></i> Añadir Clase</a>
									</div>									
									<table id="dt_clases" class="w100">
										<thead>
											<tr>						
												<th class="w10">SELECCIONAR</th>
												<th class="w10">FASE #</th>									
												<th class="w30">CLASE MAESTRA</th>							
												<th class="w30">DESCRIPCIÓN</th>
												<th class="w20">IMAGEN</th>														
											</tr>	
										</thead>
										<tbody>		
											<input type="hidden" name="grupofase_id" value="<?=$id?>" id="grupofase_id">											
											<?php 
											$clases = obtenerallcursosporgrupoyfase($db, 'grupos_fases','clases', $grupo['fase_id'], $grupo['grupo_id']);        
												if(!empty($clases) && mysqli_num_rows($clases) >= 1):
													while($clase = mysqli_fetch_assoc($clases)):								
											?> 
											
												<tr id="<?php echo $clase['id']; ?>">						
													<td >													
														<input type="checkbox" name="ids[]" value="<?php echo $clase['id']; ?>" <?php  ?> class="users"> 
													</td>
													<td>Fase <?= $clase['fase_id'] ?> </td>
													<td><?=$clase['nombre']?> </td>
													<td>
														<?php if(strlen($clase['descripcion']) > 60) : ?>
															<?=substr($clase['descripcion'],0,100)."..."?>
														<?php else : ?>
															<?=$clase['descripcion']?>
														<?php endif ?>
													</td>
													<td>
														<?php if($clase['imagen'] != null) : ?>
															<img src="assets/clases/<?=$clase['carpeta'].'/'.$clase['imagen']?>" alt="Imagen de la Clases <?=$clase['nombre']?>">
														<?php else : ?>
															<img src="assets/img/example_clases.jpg" alt="Imagen de la Clase <?=$clase['nombre']?>">
														<?php endif ?>
													</td>									
												</tr>
											<?php endwhile;
											else : ?>
												<tr>
													<td colspan="4">No hay clases maestras para mostrar.</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
									<!-- FIN TABLA -->					
								</div>										
							</div>
						</section>
					</div>
					<div id="info2"></div>
				</div>				
				<?php endwhile; endif; ?>
			</div>	
			<!-- center -->
			<?php borrarErrores(); ?>		
		</div>
		</section>
	<?php include 'layout/footer.php'; ?>
</div>
</main>



<script>
	$(document).ready(function(){
		
		$("#btnseleccionar").click(function(){			
				$("#dt_cursos input[type=checkbox]").attr("checked", true);
			});		
  
		$("#btndeseleccionar").click(function(){
			$("#dt_cursos input[type=checkbox]").attr("checked", false);
		});

		$("#btnseleccionar-2").click(function(){			
				$("#dt_clases input[type=checkbox]").attr("checked", true);
			});		
  
		$("#btndeseleccionar-2").click(function(){
			$("#dt_clases input[type=checkbox]").attr("checked", false);
		});

	});

	$( "#anadir-cursos" ).click(function() {		
		var ids_array = [];
		var id_grupodetalle = $("#grupofase_id").val();
		$("input:checkbox[class=users]:checked").each(function () {
			ids_array.push($(this).val());
		});

		if (ids_array.length>0) {
			console.log(ids_array, id_grupodetalle);
			url = "models/add/grupos-cursos-add.php";			
			$.ajax({
				type: "POST",
				url: url,
				data: {ids_array : ids_array, id_grupodetalle : id_grupodetalle},
				success: function(respuesta){
					console.log(respuesta);
					refresh();
					var info = $("#info");
					info.html("<div class='alerta-exito'>Se añadieron los curso</div>");
				}			
			});
		}else{
			var info = $("#info");
			info.html("<div class='alerta-error'>Debe seleccionar un curso</div>");
		}

	}); 

	$( "#anadir-clases" ).click(function() {		
		var ids_array = [];
		var id_grupodetalle = $("#grupofase_id").val();
		$("input:checkbox[class=users]:checked").each(function () {
			ids_array.push($(this).val());
		});

		if (ids_array.length>0) {
			console.log(ids_array, id_grupodetalle);
			url = "models/add/grupos-clases-add.php";			
			$.ajax({
				type: "POST",
				url: url,
				data: {ids_array : ids_array, id_grupodetalle : id_grupodetalle},
				success: function(resultado){
					console.log(resultado);
					refresh();
					var info = $("#info"), 
						info2 = $("#info2");
					info.html("<div class='alerta-exito'>Se añadieron las clases maestras</div>");
					info2.html("<div class='alerta-exito'>Se añadieron las clases maestras</div>");
				}			
			}); 
		}else{
			var info = $("#info"), 
						info2 = $("#info2");
			info.html("<div class='alerta-error'>Debe seleccionar una clase</div>");
			info2.html("<div class='alerta-error'>Debe seleccionar una clase</div>");
		}

	}); 

	function refresh() {
    setTimeout(function () {
			location.reload();
    }, 2000);
	}

	
</script>
