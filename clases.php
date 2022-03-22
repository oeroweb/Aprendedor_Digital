<?php
	include 'layout/header.php';
	
	if($_GET['cu'] == "" or $_GET['t'] == "" ){
		$textoerror = '<h2 class="title">El curso que buscas no exite, oh no se encontro. </h2>';
		header("Refresh:3; url=cursos.php");
	}
	
	$textoerror = '<h2 class="title">El curso que buscas no exite, oh no se encontro. </h2>';	
	$curso_id = isset($_GET['cu']) ? $_GET['cu'] : '';
	$token = trim($_GET['t']);
	$fase = isset($_GET['f']) ? $_GET['f'] : '';
	$curso_contenido = (isset($_GET['cc']) ? $_GET['cc'] : '');
	$usuario_id = $_SESSION['sesion_aprenDigital']['id'];

	if(!$_GET['pag'] || $_GET['pag'] <= 0 ){
		header("Location:clases.php?cu=$curso_id&t=$token&f=$fase&pag=1");
	}	
	
?>

<body>
	<?php include 'layout/aside.php'; ?>
	<section class="home-section">
		<?php include 'layout/perfil.php'; ?>

		<div class="portal-clases overflowh">
			<div class="loader" id="loader">
				<div class="preloader"></div>
			</div>	
			<?php
				$cursos = mostarcursosytoken($db, 'grupos_usuarios_cursos','cursos', $curso_id, $usuario_id, $token);
				if (!empty($cursos) && mysqli_num_rows($cursos) >= 1) :
					$cant = mysqli_num_rows($cursos);					
					while ($curso = mysqli_fetch_assoc($cursos)) :
			?>
				<div class="box-titles">
					<h2 class="title">Curso : <?= $curso['nombrecurso'] ?> </h2>
				</div>				
			<?php endwhile; else:				
				echo $textoerror;					
			endif; ?>

			<div class="center">
				<div id="info"></div>
				<?php if (isset($_SESSION['completado'])) : ?>
					<div class="alerta-exito">
						<?= $_SESSION['completado'] ?>
					</div>
				<?php elseif (isset($_SESSION['fallo'])) : ?>
					<div class="alerta-error">
						<?= $_SESSION['fallo'] ?>
					</div>
				<?php endif; ?>
			</div>

			<?php
				$cursosactivo = obtenerdatosusuariosycurosenproceso($db, 'grupos_usuarios_cursos',  $usuario_id, $curso_id);
					if (!empty($cursosactivo) && mysqli_num_rows($cursosactivo) >= 1) :						
						while ($cursoEstado = mysqli_fetch_assoc($cursosactivo)) :															
			?>
				<?php if($cursoEstado['proceso_id'] >= 7 && $cursoEstado['proceso_id'] <= 9): ?>

					<div class="inner-portal-clases ">
						<div class="list-cursos">
							<div class="accordion" id="accordion">
								<?php
									$contador = 0;
									$contenidos = obtenerListaContenidoCursoPorUsuarioId($db, 'lista_cursos_usuario', $usuario_id, $curso_id);							
									if (!empty($contenidos) && mysqli_num_rows($contenidos) >= 1) :
										$cant_capitulos = mysqli_num_rows($contenidos);																	
										while ($contenido = mysqli_fetch_assoc($contenidos)) :											
											$contador = $contador + 1;
											$contenidoID = $contenido['cursocontendido_id']
								?>
									<div class="content-accordion-clases">
										<div class="box-label">
											<h2 class="title"><?=$contador .' . '?> <i class="mg-rg5 far fa-folder-open"> </i> 
												<?php  
													$sql_capitulos = "SELECT * FROM lista_cursos_usuario where usuario_id = $usuario_id and curso_id = $curso_id and cursocontendido_id = $contenidoID ORDER BY id";
													$capitulos = mysqli_query($db, $sql_capitulos);
													$capitulo = mysqli_fetch_array($capitulos);
													echo $capitulo['nombrecapitulo'];	
												?>
											</h2>
										</div>
										<?php											
											$detalles = obtenerListaDetalleContenidoCursoPorUsuarioId($db, 'lista_cursos_usuario', $usuario_id, $curso_id, $contenido['cursocontendido_id']);
											if (!empty($detalles) && mysqli_num_rows($detalles) >= 1) :
												$cant_videos = mysqli_num_rows($detalles);
												//echo 'videos -> ' .$cant_videos;										
												while ($detalle = mysqli_fetch_assoc($detalles)) :													
										?>
											<div class="inner-content-accordion <?php echo $detalle['proceso_id'] == 9 ? 'concluido' : '' ?>" data-video="<?=$detalle['id']?>">
												<a href="clases.php?cu=<?=$curso_id?>&t=<?=$token?>&cc=<?=$detalle['id']?>&<?=$detalle['pagina']?>">
												<div class="container-wrap align-items-center">
													<input type="checkbox" value="<?=$detalle['id']?>" <?php echo $detalle['proceso_id'] >= 8 && $detalle['proceso_id'] <= 9 ? 'checked' : ''  ?>>
													<div class="box-text">
														<span class=""><?=$detalle['nombrecursodetalle']?> </span><br>
														<?php if($detalle['proceso_id'] != ''): ?>
															<?php if($detalle['proceso_id'] == 8): ?>
																<span class="">En Proceso : <?=$detalle['porcentaje'] . '%'?> </span><br>
															<?php else : ?>
																<span class="">Concluido : <?=$detalle['porcentaje'] . '%'?> </span><br>
															<?php endif; ?>
														<?php endif; ?>
													</div>
												</div>
												</a>
											</div>
										<?php endwhile; endif; ?>
									</div>
								<?php endwhile;	else: ?>
									<div class="content-accordion-clases">
										<div class="box-label" data-label="">
											<h2 class="title"><i class="fas fa-folder"></i> No hay Capitulos añadidos</h2>
										</div>						
									</div>
								<?php endif; ?>
							</div>		
						</div>
								
						<div class="content-media" id="contentMedia">							
							<?php
								$cantreg_pag=1;
								$iniciar_pag=($_GET['pag'] - 1)*$cantreg_pag;							

								$alldetalles = obtenerallDetalleContenidoCursoPorUsuarioId($db, 'lista_cursos_usuario',$usuario_id, $curso_id);
								if (!empty($alldetalles) && mysqli_num_rows($alldetalles) >= 1) :
									$cant_videos = mysqli_num_rows($alldetalles); 
									$total_pag=ceil($cant_videos/$cantreg_pag);
									
									if($_GET['pag'] > $total_pag ){
										header("Location:clases.php?cu=$curso_id&t=$token&pag=1");
									}									

									$sql2 = "SELECT * FROM lista_cursos_usuario where usuario_id = $usuario_id and curso_id = $curso_id Limit $iniciar_pag,$cantreg_pag";
									$resultado = mysqli_query($db, $sql2);

									while ($detalle = mysqli_fetch_assoc($resultado)) :
							?>
													
								<div class="box-video">
									<input type="hidden" value="<?=$curso_contenido?>">									
									<?//=var_dump($detalle['url_video'])?>
									<?=$detalle['url_video'];?>								
								</div>
								<div class="box-progreso">
									<div class="barra">
										<div class="inner-barra" ></div>
									</div>
									<div id="progreso"> 0% </div>
								</div>

								<div class="box-botones container-wrap space-between">
									<a href="clases.php?cu=<?=$curso_id?>&t=<?=$token?>&pag=<?php echo $_GET['pag'] - 1 ?>" 
									class="btn <?php echo $_GET['pag'] <= 1 ? 'isDisabled' : '' ?>" id="prev_video"> 
										<i class="fas fa-angle-left"></i> Anterior
									</a>
									<a href="clases.php?cu=<?=$curso_id?>&t=<?=$token?>&pag=<?php echo $_GET['pag'] + 1 ?>" 
									class="btn <?php echo $_GET['pag'] >= $total_pag ? 'isDisabled' : '' ?>" id="next_video">
										Siguiente <i class="fas fa-angle-right"></i>
									</a>
								</div>
								
								<!-- INPUTS DATA -->
								<input type="hidden" id="progreso_text">
								<input type="hidden" value="<?=$detalle['id']?>" id="curso_id">

								<div class="box-text">
									<p class="parrafo">Tema : 
										<span class="font-light"> <?= $detalle['nombrecursodetalle'] ?> </span>
									</p>			
								</div>

								<?php 
                $sql = "SELECT nombrecursodetalle FROM lista_cursos_usuario WHERE porcentaje >= 90 and usuario_id = $usuario_id";
                $dataVideosProceso = mysqli_query($db, $sql);
                $cantDataVideosProceso = mysqli_num_rows($dataVideosProceso);
                
								$sql2 = "SELECT nombrecursodetalle FROM lista_cursos_usuario WHERE usuario_id = $usuario_id";
                $dataVideos = mysqli_query($db, $sql2);
                $cantDataVideos = mysqli_num_rows($dataVideos);
								
								$sql3 = "SELECT * FROM grupos_usuarios_cursos WHERE usuario_id = $usuario_id and proceso_id IS NULL ORDER by fase_id LIMIT 1";
                $dataNextVideos = mysqli_query($db, $sql3);
                $cantDataNextVideos = mysqli_num_rows($dataNextVideos);
								
								if($cantDataVideos == $cantDataVideosProceso):
								?>
								<div class="box-botones">
									<p class="mg-bt20">Presiona el boton para ir al siguiente curso.. </p> 
										<?php foreach($dataNextVideos as $video): ?>	
											<input type="hidden" id="video_id" value="<?=$video['id']?>">
											<input type="hidden" id="token_id" value="<?=$video['token']?>">
											<input type="hidden" id="idCurso" value="<?=$curso_id?>">
											<input type="hidden" id="usuario_id" value="<?=$usuario_id?>">
										<?php endforeach; ?>
									<a href="" class="btn" id="btnNextVideo" >Pasar al siguiente Curso <i class="fas fa-redo-alt"></i></a>
								</div>
								<?php endif; ?>


							<?php endwhile;
								endif; ?>						
							
						</div>

						<div class="files-media" id="filesMedia">
							<p>Recursos y descargables</p>
							<?php
								$detalles = obtenerdatos($db, 'cursos_contenido_detalle', $curso_contenido);
								if (!empty($detalles) && mysqli_num_rows($detalles) >= 1) :
									$cant_videos = mysqli_num_rows($detalles);									
									while ($detalle = mysqli_fetch_assoc($detalles)) :
							?>
								<div class="mg-tp20">
									<?php if($detalle['archivos']) :
										$misarchivos = $detalle['archivos'];																			
										$array_misarchivos = explode(', ', $misarchivos); 
										foreach( $array_misarchivos as $archivo) : ?>															
											<a href="assets/cursos/<?=$detalle['carpeta']."/".$archivo?>" class="btn-file" title="descargar <?=$archivo?>" download><i class="fas fa-download"></i> <?=$archivo?></a>
									<?php endforeach;	 endif; ?>									
								</div>
							<?php endwhile; endif; ?>			
						</div>

					</div>			
				
				<?php else: ?>
					<?php
						$cursos = mostarcursosytoken($db, 'grupos_usuarios_cursos','cursos', $curso_id, $usuario_id, $token);
						if (!empty($cursos) && mysqli_num_rows($cursos) >= 1) :
							$cant = mysqli_num_rows($cursos);							
							while ($curso = mysqli_fetch_assoc($cursos)) :
					?>				
						<div class="w40 mg-auto">
							<?php  if($curso['imagencurso'] != ""): ?>
								<img src="assets/img/cursos/<?=$curso['imagencurso']?>" alt="">
							<?php  else: ?>
								<img src="assets/img/example_cursos.jpg" alt="">
							<?php  endif; ?>							
						</div>	
					<?php endwhile; else:				
						echo $textoerror;					
					endif; ?>

					<form action="models/add/cursos-usuarios-add.php" class="" method="POST">
						<div class="box-input">
							<input type="hidden" name="usuarioId" value="<?=$usuario_id?>">		
							<input type="hidden" name="cursoId" value="<?=$curso_id?>">
							<input type="hidden" name="token" value="<?=$token?>">
						</div>
						<?php
							$contador3 = 0;
							$cursosProgresos = mostarcursoscompleto($db, 'grupos_usuarios_cursos', 'cursos', 'cursos_contenido', 'cursos_contenido_detalle', $usuario_id, $curso_id);
								if (!empty($cursosProgresos) && mysqli_num_rows($cursosProgresos) >= 1) :	
									$cant = mysqli_num_rows($cursosProgresos);		
									while ($cursoproceso = mysqli_fetch_assoc($cursosProgresos)) :
									$contador3 = $contador3 + 1;			
						?>	
							<div class="box-input">
								<span class="hidden" >Grupo usuario curso id</span>
								<input type="hidden" name="grupousuariocurso_id[]" value="<?=$cursoproceso['grupousuarioscurso_id']?>">
								<span class="hidden" >Usuario id</span>
								<input type="hidden" name="usuario_id[]" value="<?=$cursoproceso['usuario_id']?>">
								<span class="hidden" >Curso id</span>
								<input type="hidden" name="curso_id[]" value="<?=$cursoproceso['curso_id']?>">
								<span class="hidden" >Nombre del Curso</span>
								<input type="hidden" name="nombrecurso[]" value="<?=$cursoproceso['nombrecurso']?>">
								<span class="hidden" >Id curso contenido</span>
								<input type="hidden" name="cursoContenido_id[]" value="<?=$cursoproceso['cursoContenido_id']?>">
								<span class="hidden" >Nombre del Capitulo</span>
								<input type="hidden" name="nombrecapitulo[]" value="<?=$cursoproceso['nombrecapitulo']?>">
								<span class="hidden" >Id curso contenido detalle</span>
								<input type="hidden" name="cursoContenidoDetale_id[]" value="<?=$cursoproceso['cursoContenidoDetale_id']?>">
								<span class="hidden" >Nombre del curso</span>
								<input type="hidden" name="nombre[]" value="<?=$cursoproceso['nombre']?>">
								<span class="hidden" >Video</span>
								<input type="hidden" name="video[]" value="<?=$cursoproceso['video']?>">
								<span class="hidden" >Url Video</span>
								<textarea class="hidden" name="url_video[]" id="" ><?=$cursoproceso['url_video']?></textarea>
								<span class="hidden" >Pagina - Paginación</span>
								<input type="hidden" name="pagina[]" value="pag=<?=$contador3?>">
							</div>
						<?php endwhile; endif; ?>
						<div class="w100 al-ct">
							<input type="submit" name="anadircurso" class="btn btn-submit2" value="Iniciar Curso">
						</div>
					</form>

				<?php endif; ?>

			<?php endwhile; endif; ?>

			<?php borrarErrores(); ?>
		</div>
	</section>

	<?php include 'layout/footer.php'; ?>
	</div>
	</main>

	<script>

		window.onload = function(){			
			$('#loader').fadeOut();
			$('.portal-clases').removeClass('overflowh');			
		}
		var iframeplayer = document.querySelector("iframe");
		iframeplayer.setAttribute("id", "player");
									
		//This code loads the IFrame Player API code asynchronously.
		var tag = document.createElement('script');
		tag.src = "https://www.youtube.com/iframe_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

		var player;
		var progress_field = document.getElementById("progreso");
		 progress_text = document.getElementById("progreso_text"),
		 progress_level = document.querySelector(".inner-barra"),
		 prevButton = document.getElementById(".pre_video"),
		 nextButton = document.getElementById(".next_video");

		// http://localhost/pagaprendedor/escuela/curso-details-edit.php?id=2
		// <iframe width="560" height="315" src="https://www.youtube.com/embed/UcIxotbHKqQ?enablejsapi=1&rel=0&showinfo=0&modestbranding=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		// ?enablejsapi=1&rel=0&showinfo=0&modestbranding=1

		function onYouTubeIframeAPIReady() {			
			player = new YT.Player('player');
			player.addEventListener('onReady', 'onPlayerReady');
			player.addEventListener('onStateChange', 'onPlayerStateChange');			
		}

		function onPlayerReady(event){
			event.target.playVideo();
		}
		
		function onPlayerStateChange(event) {
			if(event.data === YT.PlayerState.PLAYING) { 
				//console.log(player.getDuration());
				setInterval(getProgress,1500);
			}

			if (event.data == YT.PlayerState.ENDED) {
				clearInterval(getProgress);
				setTimeout(getUpdate_complete, 2000);
			}
		}

		function getProgress(){
    	progress = Math.round(player.getCurrentTime() / player.getDuration() * 100);
    	progress_field.innerHTML = progress + "%";
    	progress_text.value = progress;
			progress_level.style.width = progress +'%';			
			if(progress_text.value == 30 || progress_text.value == 60 || progress_text.value == 90 ){
				setTimeout(getUpdate, 2000);
			}			
		}
	
		function getUpdate_complete(){			
			var progresoData = document.getElementById("progreso_text").value,
				id = document.getElementById("curso_id").value;			
			
			$.ajax({
				type: "POST",
				url: "models/updates/upprogresocursoscompletado.php",
				data: {progreso : progresoData, id : id},
				success: function(respuesta){ 					
					
				}			
			}); 
		}

		function getUpdate(){			
			var progresoData = document.getElementById("progreso_text").value,
				id = document.getElementById("curso_id").value;			
			
			$.ajax({
				type: "POST",
				url: "models/updates/upprogresocursos.php",
				data: {progreso : progresoData, id : id},
				success: function(respuesta){ 					
					
				}			
			});			
		}

		var btnNextVideo = document.getElementById("btnNextVideo");

		btnNextVideo.addEventListener("click", function(e){
			e.preventDefault();
			console.log("next video");

			var videoId = document.getElementById("video_id").value, 
				cursoId = document.getElementById("idCurso").value,			
				usuarioId = document.getElementById("usuario_id").value;			
				
			$.ajax({
				type: "POST",
				url: "models/updates/upestadonextcurso.php",
				data: {videoId : videoId, cursoId : cursoId, usuarioId : usuarioId },
				success: function(respuesta){ 					
					window.location.href = "cursos.php";
				}			
			});		
		});

  </script>