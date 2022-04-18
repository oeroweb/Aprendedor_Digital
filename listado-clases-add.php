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
							<h1 class="title">Lista de Usuarios y Clases Maestras</h1>
						</div>
						<div class="box-info">
							<p class="text"> <i class="fas fa-info-circle"></i> Se añadirá las siguientes clases maestras a los usuarios mencionados.</p>
						</div>

						<?php 					
							$tablagucla = listargrupousuarioscursos($db, 'grupos_usuarios_clases', $id, $fase);
							
							if (!empty($tablagucla) && mysqli_num_rows($tablagucla) >= 1) :
								$cantDataCursos = mysqli_num_rows($tablagucla);
								//echo $cantDataCursos;
								// while ($guc = mysqli_fetch_assoc($tablaguc)) :
						?>	
							<form action="models/add/grupos-usuarios-clases-add.php" class="box-formulario"method="post" >						
														
								<table id="dt_usuariosCursos" class="w100">
									<thead>
										<tr>											
											<th class="">Grupo #</th>	
											<th class="">Alumnos / Usuarios</th>					
											<th class="">Fase #</th>										
											<th class="">Clase Maestra</th>											
										</tr>	
									</thead>
									<tbody>										
										<?php 
										$grupos = listarallusuariosyclasesporgrupoyfase($db, $id, $fase);
										if (!empty($grupos) && mysqli_num_rows($grupos) >= 1) :
											$cantidad = mysqli_num_rows($grupos);										
											// echo $cantidad;
											while ($grupo = mysqli_fetch_assoc($grupos)) :											
												$token  = generandoTokenClave();									
										?> 										
											<tr class="
													<?php foreach($tablagucla as $gucla) :							
														if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
															echo	'hidden';
														} else{
															echo	'';
														}
													endforeach; ?>
											">
												<td><?=$grupo['grupo_id']?> 
													<input type="hidden" name="idgroup" value="<?=$id?>"
														<?php foreach($tablagucla as $gucla) :							
																if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
														endforeach; ?>
													>
													<input type="hidden" name="grupo_id[]" value="<?=$grupo['grupo_id']?>"
														<?php foreach($tablagucla as $gucla) :							
																if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
														endforeach; ?>
													>
													<input type="hidden" name="grupofases_id[]" value="<?=$grupo['grupofase_id']?>"
														<?php foreach($tablagucla as $gucla) :							
																if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
														endforeach; ?>
													>
													<input type="hidden" name="grupoFaseClase_id[]" value="<?=$grupo['grupoFaseClase_id']?>"
														<?php foreach($tablagucla as $gucla) :							
																if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
														endforeach; ?>
													>
												</td> 
												<td><?=$grupo['nombre'] .' '. $grupo['ape_paterno'] .' '. $grupo['ape_materno']?>
													<input type="hidden" name="usuario_id[]" value="<?=$grupo['usuario_id']?>"
														<?php foreach($tablagucla as $gucla) :							
																if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
														endforeach; ?>
													>
												</td>
												<td># <?=$grupo['fase_id']?>  
													<input type="hidden" name="fase_id[]" value="<?=$grupo['fase_id']?>"
														<?php foreach($tablagucla as $gucla) :							
																if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
														endforeach; ?>
													>				
												</td>										
												<td class=""><?=$grupo['clasemaestra']?>
													<input type="hidden" name="clase_id[]" value="<?=$grupo['clase_id']?>"
														<?php foreach($tablagucla as $gucla) :							
																if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
														endforeach; ?>
													>
													<input type="hidden" name="acceso[]" value="<?=$grupo['accesoClase']?>"
														<?php foreach($tablagucla as $gucla) :							
																if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
																 echo	'disabled';
																} else{
																	echo	'';
																}
														endforeach; ?>
													>		
													<input type="hidden" name="token[]" value="<?=$token?>"
														<?php foreach($tablagucla as $gucla) :							
																if($gucla['usuario_id'] == $grupo['usuario_id'] && $gucla['clase_id'] == $grupo['clase_id']){
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
									<input type="submit" name="usuariosyclases" class="btn" value="Guardar">					<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i> Cancelar y regresar</a>			
								</div>						
								
							</form>

						<?php else: ?>

							<!-- EN CASO NO HAYA NINGUN REGISTRO -->
							<form action="models/add/grupos-usuarios-clases-add.php" class="box-formulario"method="post" >						
															
								<table id="dt_usuariosCursos" class="w100">
									<thead>
										<tr>						
											<th class="w10">Cantidad</th>
											<th class="">Grupo #</th>	
											<th class="">Alumnos / Usuarios</th>					
											<th class="">Fase #</th>										
											<th class="">Clase Maestra</th>											
										</tr>	
									</thead>
									<tbody>										
										<?php 
										$grupos = listarallusuariosyclasesporgrupoyfase($db, $id, $fase);
										if (!empty($grupos) && mysqli_num_rows($grupos) >= 1) :
											$cantidad = mysqli_num_rows($grupos);
											$contador = 0;
											// $cantidad = mysqli_num_rows($grupos);
											// echo $cantidad;
											while ($grupo = mysqli_fetch_assoc($grupos)) :	
												$contador = $contador + 1;
												$token  = generandoTokenClave();									
										?> 										
											<tr>						
												<td ><?=$contador?>	
													<input type="hidden" name="idgroup" value="<?=$id?>">
												</td>
												<td><?=$grupo['grupo_id']?> 
													<input type="hidden" name="grupo_id[]" value="<?=$grupo['grupo_id']?>">
													<input type="hidden" name="grupofases_id[]" value="<?=$grupo['grupofase_id']?>">
													<input type="hidden" name="grupoFaseClase_id[]" value="<?=$grupo['grupoFaseClase_id']?>">
												</td> 
												<td><?=$grupo['nombre'] .' '. $grupo['ape_paterno'] .' '. $grupo['ape_materno']?>
													<input type="hidden" name="usuario_id[]" value="<?=$grupo['usuario_id']?>">
												</td>
												<td># <?=$grupo['fase_id']?>  
													<input type="hidden" name="fase_id[]" value="<?=$grupo['fase_id']?>">				
												</td>										
												<td class=""><?=$grupo['clasemaestra']?>
													<input type="hidden" name="clase_id[]" value="<?=$grupo['clase_id']?>">
													<input type="hidden" name="acceso[]" value="<?=$grupo['accesoClase']?>">		
													<input type="hidden" name="token[]" value="<?=$token?>">
												</td>										
											</tr>
											
										<?php 								
											endwhile; 
											echo '<p class="parrafo mg-bt20">Se van añadir '.$cantidad . ' registros.</p>'; 
										else :  
										?>
											<tr><td colspan="5">No hay clases maestras añadidas en está fase.</td></tr>
										<?php endif;  ?>
									</tbody>
								</table>
								<!-- FIN TABLA -->					
								<div class="box-botones">
									<input type="submit" name="usuariosyclases" class="btn" value="Guardar">											
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