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
					$datos = obtenerdatos($db, 'grupos', $id);
					if (!empty($datos) && mysqli_num_rows($datos) >= 1) :
						while ($dato = mysqli_fetch_assoc($datos)) :
					?>
						<h2 class="title">Grupo <?= $dato['nombre'] ?></h2>
					<?php
						endwhile;
					endif;
					?>
					<div class="box-botones">
						<a class="btn" href="admin-grupos.php" title="Ver lista de Grupos">Ir a Grupos</a>
						<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>
					</div>
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
				
				<div class="grupos-content-grupos">	
					<div class="box-info">
						<p class="text"> <i class="fas fa-info-circle"></i> Presione añadir todos los cursos para enlazar los cursos y usuarios.</p>
						<p class="text"> <i class="fas fa-info-circle"></i> También puede añadir los cursos por fase, presionando en añadir los cursos de la fase para enlazar los cursos y usuarios.</p>
						<p class="text"> <i class="fas fa-info-circle"></i> Caso contrario los usuarios no podrán acceder a los cursos asignados anteriormente.</p>
					</div>

					<div class="box-info">
							<p class="text"> <i class="fas fa-info-circle"></i> Presione añadir todos los cursos para enlazar los cursos y usuarios.</p>						
					</div>
					<div class="box-title mg-tp40">
						<h2 class="title mg-bt20">Solo estarán visibles las fases añadidas al grupo.</h2>			
					</div>

					<div class="box-botones mg-tp20">
						<?php
							$datos = selecttogrupoId($db, 'grupos_fases', $id);
								if (!empty($datos) && mysqli_num_rows($datos) >= 1) :
									while ($dato = mysqli_fetch_assoc($datos)) :
						?>												
							<a href="listado-cursos-add.php?id=<?=$dato['grupo_id']?>&fase=<?=$dato['fase_id']?>" class="btn" id="btnfase1"><i class="fas fa-link"></i> Añadir los cursos de la fase <?=$dato['fase_id']?></a>						
						<?php endwhile; else: ?>
							<p class="parrafo">No hay cursos añadidos al grupo.</p>
						<?php endif; ?>
					</div>
					<hr>
					<div class="box-title mg-tp40">
						<h2 class="title mg-bt20">Enlazar las clases maestras añadidas al grupo con los Usuarios.</h2>						
					</div>
					<div class="box-botones mg-tp20">
						<?php
							$datos = selecttogrupoId($db, 'grupos_fases', $id);
								if (!empty($datos) && mysqli_num_rows($datos) >= 1) :
									while ($dato = mysqli_fetch_assoc($datos)) :
						?>												
							<a href="listado-clases-add.php?id=<?=$dato['grupo_id']?>&fase=<?=$dato['fase_id']?>" class="btn" id="btnfase1"><i class="fas fa-link"></i> Añadir las clases maestras de la fase <?=$dato['fase_id']?></a>						
						<?php endwhile; else: ?>
							<p class="parrafo">No hay clases maestras añadidos al grupo.</p>
						<?php endif; ?>
					</div>
					
					<!-- CURSOS -->
					<hr>
					<div class="box-titles mg-tp40">
						<h1 class="title">Listado de usuarios y sus cursos asignados:</h1>		
					</div>
					<div class="box-tabla mg-tp40 w100">						
						<table id="dt_grupoCursos" class="w100">
							<thead>
								<tr>						
									<th class="w10">Items</th>
									<th class="w10">Fase</th>												
									<th class="">Nombres y Apellidos</th>
									<th class="">Nombre del Curso</th>
									<th class="">Estado</th>
									<th class="w10">Opciones</th>								
								</tr>	
							</thead>
							<tbody>		
								<!-- <input type="text" name="grupo_id" value="<?//php echo $id; ?>" id="grupo_user">			-->
								<?php 
								$contador = 0;
								$datos = listarallusuariosycursosporgrupo($db, $id);
								if (!empty($datos) && mysqli_num_rows($datos) >= 1) :
									while ($dato = mysqli_fetch_assoc($datos)) :
										$contador = $contador + 1;
								?> 
									<tr>						
										<td ><?=$contador?></td>										
										<td>Fase #<?=$dato['fase_id']?> </td>
										<td><?=$dato['nombre'] .' '.$dato['ape_paterno'].' '.$dato['ape_materno']?> </td>
										<td><?=$dato['Curso']?></td>
										<td>
											<?php if($dato['acceso_id'] == 4) :?>
												<p class="btn-3" title="No publicado">
												<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Bloqueado</p>													
											<?php else : ?>
												<p class="btn-3" title="Activo">			
												<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</p>																				
											<?php endif; ?>	
										</td>										
										<td>											
											<a href="models/deletes/grupo-cursos-delete.php?id=<?=$dato['id']?>" class=" btn-2" title="Quitar curso" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
										</td>			
									</tr>
									<?php 
									endwhile;
								else : ?>
									<tr>
										<td colspan="6">No hay cursos añadidos para mostrar.</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
						<!-- FIN TABLA -->					
					</div>
					
					<!-- CLASES -->
					<hr>
					<div class="box-titles mg-tp40">
						<h1 class="title">Listado de usuarios y sus clases maestras asignadas:</h1>		
					</div>
					<div class="box-tabla mg-tp40 w100">						
						<table id="dt_grupoCursos" class="w100">
							<thead>
								<tr>						
									<th class="w10">Items</th>
									<th class="w10">Fase</th>												
									<th class="">Nombres y Apellidos</th>
									<th class="">Nombre del Curso</th>
									<th class="">Estado</th>
									<th class="w10">Opciones</th>								
								</tr>	
							</thead>
							<tbody>		
								<!-- <input type="text" name="grupo_id" value="<?//php echo $id; ?>" id="grupo_user">			-->
								<?php 
								$contador = 0;
								$datos = listarallusuariosyclasesporgrupo($db, $id);
								if (!empty($datos) && mysqli_num_rows($datos) >= 1) :
									while ($dato = mysqli_fetch_assoc($datos)) :
										$contador = $contador + 1;
								?> 
									<tr>						
										<td ><?=$contador?></td>										
										<td>Fase #<?=$dato['fase_id']?> </td>
										<td><?=$dato['nombre'] .' '.$dato['ape_paterno'].' '.$dato['ape_materno']?> </td>
										<td><?=$dato['Clases']?></td>
										<td>
											<?php if($dato['acceso_id'] == 4) :?>

												<p class="btn-3" title="No publicado">
												<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Bloqueado</p>													
											<?php else : ?>
												<p class="btn-3" title="Activo">			
												<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</p>																				
											<?php endif; ?>	
										</td>										
										<td>											
											<a href="models/deletes/grupo-cursos-delete.php?id=<?=$dato['id']?>" class=" btn-2" title="Quitar curso" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
										</td>			
									</tr>
									<?php 
									endwhile;
								else : ?>
									<tr>
										<td colspan="6">No hay clases maestras añadidas para mostrar.</td>
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
	<span class="ir-arriba hidden" id="btnArriba" title="Subir"><i class="fa fa-chevron-up"></i></span>
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
			info.html("<div class='alerta-error'>Debe seleccionar un usuario</div>");
			info2.html("<div class='alerta-error'>Debe seleccionar un usuario</div>");
		}

	}); 

	function refresh() {
    setTimeout(function () {
			location.reload();
    }, 500);
	}

	
</script>