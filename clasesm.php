<?php
	include 'layout/header.php';

	if($_GET['cl'] == "" or $_GET['t'] == ""){
		$textoerror = '<h2 class="title">La Clase que buscas no exite, oh no se encontro.</h2>';
		header("Refresh:3; url=clasesm.php");
	}
	$textoerror = '<h2 class="title">La Clase que buscas no exite, oh no se encontro.</h2>';
	
	$clase_id = isset($_GET['cl']) ? $_GET['cl'] : '';
	$token = trim($_GET['t']);
	$curso_contenido = (isset($_GET['cc']) ? $_GET['cc'] : '');
	$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
	//echo 'clase_id ' .$clase_id . ' usuario ' . $usuario_id;
	
?>

<body>
	<?php include 'layout/aside.php'; ?>
	<section class="home-section">
		<?php include 'layout/perfil.php'; ?>

		<div class="portal-clases">			
			<div class="box-titles">
				<?php
					$cursos = mostarclasescompletasytoken($db, 'grupos_usuarios_clases','clases', $clase_id, $usuario_id, $token);
					if (!empty($cursos) && mysqli_num_rows($cursos) >= 1) :
						$cant = mysqli_num_rows($cursos);					
						while ($curso = mysqli_fetch_assoc($cursos)) :
				?>
					<h2 class="title">Clase Maestra : <?= $curso['nombre'] ?> </h2>
				<?php endwhile; else:				
					echo $textoerror;					
				endif; ?>				
			</div>				
			
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
				$clasesactivo = obtenerdatosusuariosyclasesenproceso($db, 'grupos_usuarios_clases',  $usuario_id, $clase_id);
				if (!empty($clasesactivo) && mysqli_num_rows($clasesactivo) >= 1) :	
					$cant = mysqli_num_rows($clasesactivo);
					//echo 'cantidad ' .$cant;		
						while ($claseEstado = mysqli_fetch_assoc($clasesactivo)) :						
			?>
				
				<?php if($claseEstado['proceso_id'] >= 7 && $claseEstado['proceso_id'] <= 9 ): ?>
					
					<div class="inner-portal-clases-maestras">
						<div class="content-media">								
							<?php
								$cursos = obtenerListaClasesPorUsuarioId($db, 'lista_clases_usuario', $usuario_id, $clase_id);
								if (!empty($cursos) && mysqli_num_rows($cursos) >= 1) :
									$cant = mysqli_num_rows($cursos);							
									while ($curso = mysqli_fetch_assoc($cursos)) :
							?>
										
								<div class="box-video" id="player"> 
									<?=$curso['url_video'];?>									
								</div>
								
								<div class="box-progreso">
									<div class="barra">
										<div class="inner-barra" ></div>
									</div>
									<div id="progreso"> 0% </div>
								</div>

								<!-- INPUTS DATA -->
								<input type="hidden" id="progreso_text">
								<input type="hidden" value="<?=$curso['id']?>" id="clase_id">

								<div class="box-text">
									<p class="parrafo">Tema : 
										<span class="font-light"> <?= $curso['nombreclase'] ?> </span>
									</p>			
								</div>

								<!-- REVISAR -->
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
								
								//if($cantDataVideos == $cantDataVideosProceso):									
								?>
								<div class="box-botones">
									<p class="mg-bt20">Escuesta de Satisfacción</p> 
										<?php foreach($dataNextVideos as $video): ?>	
											<input type="hidden" id="video_id" value="<?=$video['id']?>">
											<input type="hidden" id="token_id" value="<?=$video['token']?>">
											<input type="hidden" id="idCurso" value="<?=$clase_id?>">
											<input type="hidden" id="usuario_id" value="<?=$usuario_id?>">
										<?php endforeach; ?>
									<a href="" class="btn" id="btnNextVideo" >Pasar al siguiente Curso <i class="fas fa-redo-alt"></i></a>
								</div>
								<?php //endif; ?>

							<?php endwhile;
									endif; ?>
						
						</div>
						
					</div>
				<?php else: ?>
					
					<?php
						$cursos = mostarclasescompletasytoken($db, 'grupos_usuarios_clases','clases', $clase_id, $usuario_id, $token);
							if (!empty($cursos) && mysqli_num_rows($cursos) >= 1) :
								$cant = mysqli_num_rows($cursos);							
								while ($curso = mysqli_fetch_assoc($cursos)) :
					?>			
						<div class="w40 mg-auto">
							<?php  if($curso['imagen'] != ""): ?>
								<img src="assets/img/clases/<?=$curso['carpeta'].'/'.$curso['imagen']?>" alt="">
							<?php  else: ?>
								<img src="assets/img/example_clases.jpg" alt="">
							<?php  endif; ?>							
						</div>
					<?php endwhile; else:				
						echo $textoerror;					
					endif; ?>

					<form action="models/add/clases-usuarios-add.php" method="POST">
						<div class="box-input">
							<input type="hidden" name="usuarioId" value="<?=$usuario_id?>">	
							<input type="hidden" name="cursoId" value="<?=$clase_id?>">			
							<input type="hidden" name="token" value="<?=$token?>">					
						</div>
						<?php							
							$clases = mostarclasescompleto($db, 'grupos_usuarios_clases','clases', $usuario_id );
							if (!empty($clases) && mysqli_num_rows($clases) >= 1) :
								$cant = mysqli_num_rows($clases);							
								while ($claseproceso = mysqli_fetch_assoc($clases)) :		
						?>	
							<div class="box-input">
								<span class="hidden" >Grupo usuario clases id</span>
								<input type="hidden" name="grupousuarioclase_id[]" value="<?=$claseproceso['gruposusuariosclases_id']?>">
								<span class="hidden" >Usuario id</span>
								<input type="hidden" name="usuario_id[]" value="<?=$claseproceso['usuario_id']?>">
								<span class="hidden" >Clase id</span>
								<input type="hidden" name="clase_id[]" value="<?=$claseproceso['clase_id']?>">
								<span class="hidden" >Fase id</span>
								<input type="hidden" name="fase_id[]" value="<?=$claseproceso['fase_id']?>">
								<span class="hidden" >Nombre del Curso</span>
								<input type="hidden" name="nombreclase[]" value="<?=$claseproceso['nombre']?>">								
								<span class="hidden" >Video</span>
								<input type="hidden" name="video[]" value="<?=$claseproceso['video']?>">
								<span class="hidden" >Url Video</span>
								<textarea class="hidden" name="url_video[]" id="" ><?=$claseproceso['url']?></textarea>								
							</div>
						<?php endwhile; endif; ?>
						<div class="w100 al-ct">
							<input type="submit" name="anadirclase" class="btn btn-submit2" value="Iniciar Clase Maestra">
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

		/**
			<iframe width="560" height="315" src="https://www.youtube.com/embed/wL8gCda3pG4?enablejsapi=1&rel=0&showinfo=0&modestbranding=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

			<iframe width="560" height="315" src="https://www.youtube.com/embed/UcIxotbHKqQ?enablejsapi=1&rel=0&showinfo=0&modestbranding=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

			<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/HR4mfQ6CVSE?rel=0&amp;start=10&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

			?enablejsapi=1&rel=0&showinfo=0&modestbranding=1
		 */

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
		var progress_field = document.getElementById("progreso"),
		 progress_text = document.getElementById("progreso_text"),
		 progress_level = document.querySelector(".inner-barra");

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
				id = document.getElementById("clase_id").value;			
			
			$.ajax({
				type: "POST",
				url: "models/updates/upprogresoclasecompletado.php",
				data: {progreso : progresoData, id : id},
				success: function(respuesta){ 					
					
				}			
			}); 
		}

		function getUpdate(){
			var progresoData = document.getElementById("progreso_text").value,
				id = document.getElementById("clase_id").value;			
			
			$.ajax({
				type: "POST",
				url: "models/updates/upprogresoclase.php",
				data: {progreso : progresoData, id : id},
				success: function(respuesta){ 					
					
				}			
			});			
		}

  </script>	