<?php
	include 'layout/header.php';
	$id = $_GET['id'];
	$fase = $_GET['fase'];
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
				<div id="info2"></div>

				<div class="inner-grupos-content ">					
					<div class="box-tabla mg-bt50 w100">
						<div class="box-titles mg-tp20">
							<h1 class="title">Lista de Alumnos y Cursos</h1>
						</div>
						<div class="box-info">
							<p class="text"> <i class="fas fa-info-circle"></i> Se añadirá los siguientes cursos a los usuarios mencionados.</p>
						</div>

						<?php 					
							$tablaguc = listargrupousuarioscursos($db, 'grupos_usuarios_cursos', $id, $fase);			
							if (!empty($tablaguc) && mysqli_num_rows($tablaguc) >= 1) :
								$cantDataCursos = mysqli_num_rows($tablaguc);
								//echo $cantDataCursos;
								// while ($guc = mysqli_fetch_assoc($tablaguc)) :
						?>	
								<form action="models/add/grupos-usuarios-cursos-add.php" class="box-formulario"method="post">															
									<table id="dt_usuariosCursos" class="w100">
										<thead>
											<tr>												
												<th class="">Grupo #</th>	
												<th class="">Alumnos / Usuarios</th>					
												<th class="">Fase #</th>										
												<th class="">Curso</th>											
											</tr>	
										</thead>
										<tbody>										
											<?php									
											$grupos = listarallusuariosycursosporgrupoyfase($db, $id, $fase);
											if (!empty($grupos) && mysqli_num_rows($grupos) >= 1) :
												$cantidad = mysqli_num_rows($grupos);												
												// echo $cantidad;
												while ($grupo = mysqli_fetch_assoc($grupos)) :	
													$token  = generandoTokenClave()								
											?> 										
												<tr class="
													<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'hidden';
																} else{
																	echo	'';
																}
													endforeach; ?>	
												">													
													<td><?=$grupo['grupo_id']?>
														<input type="hidden" name="idgroup" value="<?=$id?>"
															<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
															endforeach; ?>	
														>
														<input type="hidden" name="grupo_id[]" value="<?=$grupo['grupo_id']?>"
															<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
															endforeach; ?>
														>
														<input type="hidden" name="grupodetalle_id[]" value="<?=$grupo['grupofase_id']?>"
															<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
															endforeach; ?>
														>
														<input type="hidden" name="grupodetallecurso_id[]" value="<?=$grupo['grupoFaseCurso_id']?>"
															<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
															endforeach; ?>
														>
													</td> 
													<td><?=$grupo['nombre'] .' '. $grupo['ape_paterno'] .' '. $grupo['ape_materno']?>
														<input type="hidden" name="usuario_id[]" value="<?=$grupo['usuario_id']?>"
															<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
															endforeach; ?>
														>
													</td>
													<td># <?=$grupo['fase_id']?>  
														<input type="hidden" name="fase_id[]" value="<?=$grupo['fase_id']?>"
															<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
															endforeach; ?>
														>				
													</td>										
													<td ><?=$grupo['curso']?>
														<input type="hidden" name="curso_id[]" value="<?=$grupo['curso_id']?>"
															<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
															endforeach; ?>
														>
														<input type="hidden" name="acceso[]" value="<?=$grupo['accesoCurso']?>"
															<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
															endforeach; ?>
														>		
														<input type="hidden" name="token[]" value="<?=$token?>" 
															<?php foreach($tablaguc as $guc) :							
																if($guc['usuario_id'] == $grupo['usuario_id'] && $guc['curso_id'] == $grupo['curso_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
															endforeach; ?>
														>
													</td>										
												</tr>
												
											<?php endwhile; endif; ?>
										</tbody>
									</table>
									<!-- FIN TABLA -->					
									<div class="box-botones">
										<input type="submit" name="usuariosycursos" class="btn" value="Guardar">
										<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i> Cancelar y regresar</a>			
									</div>										
								</form>													

						<?php else: ?>

							<!-- EN CASO NO HAYA NINGUN REGISTRO -->
							<form action="models/add/grupos-usuarios-cursos-add.php" class="box-formulario"method="post">															
								<table id="dt_usuariosCursos" class="w100">
									<thead>
										<tr>						
											<th class="w10">Cantidad</th>
											<th class="">Grupo #</th>	
											<th class="">Alumnos / Usuarios</th>					
											<th class="">Fase #</th>										
											<th class="">Curso</th>											
										</tr>	
									</thead>
									<tbody>										
										<?php									
										$grupos = listarallusuariosycursosporgrupoyfase($db, $id, $fase);
										if (!empty($grupos) && mysqli_num_rows($grupos) >= 1) :
											$cantidad = mysqli_num_rows($grupos);
											$contador = 0;											
											// echo $cantidad;
											while ($grupo = mysqli_fetch_assoc($grupos)) :	
												$contador = $contador + 1;
												$token  = generandoTokenClave();									
										?> 										
											<tr>						
												<td ><?=$contador?>
													<input type="text" name="idgroup" value="<?=$id?>">
												</td>
												<td><?=$grupo['grupo_id']?> 
													<input type="text" name="grupo_id[]" value="<?=$grupo['grupo_id']?>">
													<input type="text" name="grupodetalle_id[]" value="<?=$grupo['grupofase_id']?>">
													<input type="text" name="grupodetallecurso_id[]" value="<?=$grupo['grupoFaseCurso_id']?>">
												</td> 
												<td><?=$grupo['nombre'] .' '. $grupo['ape_paterno'] .' '. $grupo['ape_materno']?>
													<input type="text" name="usuario_id[]" value="<?=$grupo['usuario_id']?>">
												</td>
												<td># <?=$grupo['fase_id']?>  
													<input type="text" name="fase_id[]" value="<?=$grupo['fase_id']?>">				
												</td>										
												<td><?=$grupo['curso']?>
													<input type="text" name="curso_id[]" value="<?=$grupo['curso_id']?>">
													<input type="text" name="acceso[]" value="<?=$grupo['accesoCurso']?>">		
													<input type="text" name="token[]" value="<?=$token?>">
												</td>										
											</tr>
											
										<?php 								
											endwhile; 
											echo '<p class="parrafo mg-bt20">Se van añadir '.$cantidad . ' registros.</p>'; 
										else :  
										?>
											<tr><td colspan="5">No hay cursos añadidos en esta fase.</td></tr>
										<?php endif;  ?>
									</tbody>
								</table>
								<!-- FIN TABLA -->					
								<div class="box-botones">
									<input type="submit" name="usuariosycursos" class="btn" value="Guardar">					
								</div>									
																
							</form>

						<?php endif;  ?>	
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
	/*
	$( "#btnguardar" ).click(function() {	
		$("#dt_usuariosCursos input[type=checkbox]").attr("checked", true);
		var ids_array = [];		
		$("input:checkbox[class=users]:checked").each(function () {
			ids_array.push($(this).val());
		});

		if (ids_array.length>0) {
			console.log(ids_array);
			url = "models/add/grupos-usuarios-cursos-add.php";			
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
					//refresh();
					var info = $("#info"), 
						info2 = $("#info2");
					info.html("<div class='alerta-exito'>El registro se actualizo de forma exitosa</div>");		
					info2.html("<div class='alerta-exito'>El registro se actualizo de forma exitosa</div>");		
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
 */
	
</script>