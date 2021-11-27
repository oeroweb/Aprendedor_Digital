<?php
include 'layout/header.php';
$id = $_GET['id'];
?>

<body>
	<?php include 'layout/aside.php'; ?>
	<section class="home-section">
		<?php include 'layout/perfil.php'; ?>

		<div class="home-content">
			<div class="center ">
				<div class="box-titles">				
					<?php 
						$grupos = obtenerdatos($db, 'grupos_fases', $id);
						if (!empty($grupos) && mysqli_num_rows($grupos) >= 1) :
							while ($grupo = mysqli_fetch_assoc($grupos)) :
						?> 						
							<h1 class="title">Lista de cursos y clases añadidos a está fase # <?=$grupo['fase_id']?></h1>
							<div class="box-botones">
								<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>
							</div>
					<?php 
						endwhile;	endif; 
					?>				
				</div>							

				<?php if (isset($_SESSION['completado'])) : ?>
					<div class="alerta-exito">
						<?= $_SESSION['completado'] ?>
					</div>
				<?php elseif (isset($_SESSION['fallo'])) : ?>
					<div class="alerta-error">
						<?= $_SESSION['fallo'] ?>
					</div>
				<?php endif; ?>

				<div id="info"></div>
				<div class="inner-grupos-content ">					
					<div class="box-info">
						<p class="text"> <i class="fas fa-info-circle"></i> Los cursos se agregarón a la fase.</p>
						<p class="text"> <i class="fas fa-info-circle"></i> Los cursos se agregarón de forma inactiva, solo activar el <strong>1er curso, </strong> los demás cursos se activarán automáticamente.</p>
						<p class="text"> <i class="fas fa-undo"></i> Retorne a la adminstración de grupo para enlazar los cursos añadidos con los usuarios del grupo.</p>
					</div>
					<div class="box-tabla mg-bt50 w100">						
						
						<!-- TABLA DE CURSOS -->
						<table id="dt_grupoCursos" class="w100">
							<h2 class="title">Cursos Añadidos</h2>
							<thead>
								<tr>						
									<th class="w10">Items</th>
									<th class="w20">Imagen</th>												
									<th class="">Nombre del Curso</th>
									<th class="">Descripción</th>
									<th class="">Estado</th>
									<th class="w10">Opciones</th>								
								</tr>	
							</thead>
							<tbody>		
								<!-- <input type="text" name="grupo_id" value="<?//php echo $id; ?>" id="grupo_user">			-->
								<?php 
								$contador = 0;
								$datos = listarcursosxfasedeporgrupo($db, 'grupos_cursos','cursos', $id);
								if (!empty($datos) && mysqli_num_rows($datos) >= 1) :
									while ($dato = mysqli_fetch_assoc($datos)) :
										$contador = $contador + 1;
								?> 
									<tr>						
										<td ><?=$contador?></td>
										<td><img src="assets/img/cursos/<?=$dato['imagen']?>" alt="imagen del curso <?=$dato['imagen']?>"> </td>
										<td><?=$dato['nombre']?> </td>
										<td><?=$dato['descripcion']?></td>
										<td>
											<?php if($dato['acceso_id'] == 4) :?>
												<a href="models/updates/grupos-curso-public.php?id=<?=$dato['myid']?>" class="btn-3" title="No publicado">
												<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Bloqueado</a>													
											<?php else : ?>
												<a href="models/updates/grupos-curso-private.php?id=<?=$dato['myid']?>" class="btn-3" title="Activo">			
												<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</a>																				
											<?php endif; ?>	
										</td>										
										<td>											
											<a href="models/deletes/grupo-cursos-delete.php?id=<?=$dato['myid']?>" class=" btn-2" title="Quitar curso" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
										</td>			
									</tr>
									<?php 
									endwhile;
								else : ?>
									<tr>
										<td colspan="5">No hay cursos para mostrar.</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
						<!-- FIN TABLA -->
					</div>

					<div class="box-tabla mg-bt50 w100">
						<!-- TABLA DE CLASES -->
						<table id="dt_grupoCursos" class="w100">
							<h2 class="title">Clases Maestras Añadidas</h2>
							<thead>
								<tr>						
									<th class="w10">Items</th>
									<th class="w20">Imagen</th>												
									<th class="">Nombre del Curso</th>
									<th class="">Descripción</th>
									<th class="">Estado</th>
									<th class="w10">Opciones</th>								
								</tr>	
							</thead>
							<tbody>		
								<!-- <input type="text" name="grupo_id" value="<?//php echo $id; ?>" id="grupo_user">			-->
								<?php 
								$contador = 0;
								$datos = listarclasesxfasedeporgrupo($db, 'grupos_clases','clases', $id);
								if (!empty($datos) && mysqli_num_rows($datos) >= 1) :
									while ($dato = mysqli_fetch_assoc($datos)) :
										$contador = $contador + 1;
								?> 
									<tr>						
										<td ><?=$contador?></td>
										<td>
										<?php if($dato['imagen'] != null) : ?>
												<img src="assets/clases/<?=$dato['carpeta'].'/'.$dato['imagen']?>" alt="Imagen de la Clases <?=$dato['nombre']?>">
											<?php else : ?>
												<img src="assets/img/example_clases.jpg" alt="Imagen de la Clase <?=$dato['nombre']?>">
											<?php endif ?>											
										</td>
										<td><?=$dato['nombre']?> </td>
										<td><?=substr($dato['descripcion'],0,80)?></td>
										<td>
											<?php if($dato['acceso_id'] == 4) :?>
												<a href="models/updates/grupos-clases-public.php?id=<?=$dato['myid']?>" class="btn-3" title="No publicado">
												<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Bloqueado</a>													
											<?php else : ?>
												<a href="models/updates/grupos-clases-private.php?id=<?=$dato['myid']?>" class="btn-3" title="Activo">			
												<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</a>																				
											<?php endif; ?>	
										</td>										
										<td>											
											<a href="models/deletes/grupo-clases-delete.php?id=<?=$dato['myid']?>" class=" btn-2" title="Quitar curso" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
										</td>			
									</tr>
									<?php 
									endwhile;
								else : ?>
									<tr>
										<td colspan="5">No hay clases añadidas para mostrar.</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
						<!-- FIN TABLA -->					
										
					</div>
					
				</div>
				<div id="info2"></div>
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
				$("#dt_usuariosGrupo input[type=checkbox]").attr("checked", true);
			});		
  
		$("#btndeseleccionar").click(function(){
			$("#dt_usuariosGrupo input[type=checkbox]").attr("checked", false);
		});

	});


	$( "#eliminar-usuarios" ).click(function() {		
		var ids_array = [];		
		$("input:checkbox[class=users]:checked").each(function () {
			ids_array.push($(this).val());
		});

		if (ids_array.length>0) {
			console.log(ids_array);
			url = "models/deletes/grupo-usuarios-delete.php";			
			$.ajax({
				type: "POST",
				url: url,
				data: {ids_array : ids_array},
				success: function(respuesta){
					//console.log(respuesta);
					$.each(ids_array,function(indice,id) {
           // console.log('Indice es ' + indice + ' y id es: ' + id);
            var fila = $("#id" + id).remove(); //Oculto las filas eliminadas
					});
					refresh();
					var info = $("#info"), 
						info2 = $("#info2");
					info.html("<div class='alerta-exito'>El registro se elimino de forma exitosa</div>");		
					info2.html("<div class='alerta-exito'>El registro se elimino de forma exitosa</div>");		
				}	
			}); 
		}else{
			var info = $("#info"), 
						info2 = $("#info2");
			info2.html("<div class='alerta-error'>Debe seleccionar un usuario</div>");
		}

	}); 

	function refresh() {
    setTimeout(function () {
			location.reload();
    }, 500);
	}

	
</script>