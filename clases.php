<?php
	include 'layout/header.php';
	if($_GET['cu'] == "" or $_GET['t'] == ""){
		$textoerror = '<h2 class="title">El curso que buscas no exite, oh no se encontro. </h2>';
		header("Refresh:3; url=cursos.php");
	}
	$curso_id = $_GET['cu'];
	$token = trim($_GET['t']);
	$curso_contenido = (isset($_GET['cc']) ? $_GET['cc'] : '');
	$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
	//echo $curso_id .' '. $token .' '.$usuario_id;
	//$usuario_perfil = $_SESSION['sesion_aprenDigital']['perfil_id'];
?>

<body>
	<?php include 'layout/aside.php'; ?>
	<section class="home-section">
		<?php include 'layout/perfil.php'; ?>

		<div class="portal-clases">			
			<div class="box-titles">
				<?php
					$cursos = mostarcursosytoken($db, 'grupos_usuarios_cursos','cursos', $curso_id, $usuario_id, $token);
					if (!empty($cursos) && mysqli_num_rows($cursos) >= 1) :
						$cant = mysqli_num_rows($cursos);
						//echo $cant;
						while ($curso = mysqli_fetch_assoc($cursos)) :
				?>
					<h2 class="title">Curso : <?= $curso['nombrecurso'] ?> </h2>
				<?php endwhile; else:				
					echo $textoerror;					
				endif; ?>				
			</div>				

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

			<div class="inner-portal-clases">
				<div class="list-cursos">
					<div class="accordion">
						<?php
						$contenidos = obtenerContenidoCurso($db, 'cursos_contenido', $curso_id);
						if (!empty($contenidos) && mysqli_num_rows($contenidos) >= 1) :
							$cant_capitulos = mysqli_num_rows($contenidos); 
							//echo $cant_capitulos;
							while ($contenido = mysqli_fetch_assoc($contenidos)) :
								$contenidoid =	$contenido['id']
						?>
						<div class="content-accordion-clases">
							<div class="box-label" data-label=<?= $contenido['id'] ?>>
								<h2 class="title"><i class="far fa-folder-open"></i> <?= $contenido['orden'].'. '.$contenido['nombre'] ?></h2>
							</div>
							<?php
							$detalles = obtenerdetalleContenido($db, 'cursos_contenido_detalle', $contenidoid);
							if (!empty($detalles) && mysqli_num_rows($detalles) >= 1) :
								$cant_videos = mysqli_num_rows($detalles); 
								//echo $cant_videos;
								while ($detalle = mysqli_fetch_assoc($detalles)) :
							?>
								<div class="inner-content-accordion" data-video="<?=$detalle['id']?>">
									<a href="clases.php?cu=<?=$curso_id?>&t=<?=$token?>&cc=<?=$detalle['id']?>">	
										<input type="checkbox" name="" value="<?=$detalle['id']?>">					
										<span class=""><?=$detalle['nombre']?> </span>				
									</a>
								</div>
							<?php endwhile;
							endif; ?>
						</div>						
							<?php endwhile;	 endif; ?>
					</div>		
				</div>

				<div class="content-media">	
					<?php if($curso_contenido) : ?>			
						<?php
							$detalles = obtenerdatos($db, 'cursos_contenido_detalle', $curso_contenido);
							if (!empty($detalles) && mysqli_num_rows($detalles) >= 1) :
								$cant_videos = mysqli_num_rows($detalles); 
								//echo $cant_videos;
								while ($detalle = mysqli_fetch_assoc($detalles)) :
						?>
						<div class="box-video" id="player"> 
							<?=$detalle['url_video'];?>
							<p class=""><?= $detalle['nombre'] ?> </p>
									
							<?//php if($detalle['video']) :?>												
								<!-- <video class="w100" src="assets/cursos/<?//=$detalle['carpeta']."/".$detalle['video']?>" controls muted preload="auto"></video> -->
							<?//php else: ?>							
								<?//=$detalle['url_video'];?>
							<?//php endif; ?>
							<!-- <div id="player"></div> -->
						</div>

						<?php endwhile;
								endif; ?>
					<?php else : ?>
						<p>Bienvenido al curso</p>
						<p>Seleccione un tema para iniciar</p>
					<?php endif; ?>
				</div>


				<div class="files-media">
					<p>Recursos y descargables</p>
					<?php
						$detalles = obtenerdatos($db, 'cursos_contenido_detalle', $curso_contenido);
						if (!empty($detalles) && mysqli_num_rows($detalles) >= 1) :
							$cant_videos = mysqli_num_rows($detalles); 
							//echo $cant_videos;
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
					<?php endwhile;
							endif; ?>
				</div>
			</div>

			<?php borrarErrores(); ?>
		</div>
	</section>
	<?php include 'layout/footer.php'; ?>
	</div>
	</main>


	<div class="modal" id="modal1">
		<div class="body-modal">
			<form action="" class="box-formulario" method="post" id="formadd">
				<div class="w100 container-wrap mg-bt10">
					<div class="box-input">
						<label for="nombre">Nombre del Capitulo: </label>
						<input type="hidden" value="<?= $id ?>" name="id" id="">
						<input class="w100" type="text" name="nombre" id="nombre">
					</div>
					<div class="box-input">
						<label for="descripcion">Breve Descripcion: </label>
						<input class="w100" type="text" name="descripcion" id="descripcion">
					</div>
					<div class="box-input">
						<label for="nombre">Orden a mostrar: </label>
						<input class="w100" type="number" name="orden" value="1" min="1" id="orden">
					</div>
				</div>
				<input type="submit" value="Añadir y Guardar" class="btn">
				<a href="#" class="btn" onclick="cerrarmodal1()"> Cancelar</a>
			</form>
		</div>
	</div>

	<div class="modal" id="modal2">
		<div class="body-modal">
			<form action="" method="post" name="form_eliminar" id="form_eliminar" onsubmit="event.preventDefault();">
				<h2>¿Estas de Seguro de Eliminar?</h2>
				<hr>
				<div class="container3">
					<span class="w100">¡No podrás revertir esto!</span>
					<input type="hidden" name="id" id="" value="">
					<div class="box-nombre w100" id="box-nombre"></div>
				</div>
				<input type="submit" class="btn" value="Borrar">
				<a href="#" class="btn" onclick="cerrarmodal2()"> Cancelar</a>
			</form>
		</div>
	</div>

	<script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player2', {	
					videoId: 'M7lc1UVf-VE',				         
          playerVars: {
            autoplay:1,
            controls:0
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }
    </script>
	<script>		
		//var video = document.getElementById("box-video");
		//console.log(video);

		

		$(document).ready(function() {
			//nuevo();
			//actualizar();
			//eliminar();		
		});

		function openmodal1() {
			$("#modal1").fadeIn();
		};
		function openmodal2() {
			$("#modal2").fadeIn();
		};
		function cerrarmodal1() {
			$("#modal1").fadeOut();
		};
		function cerrarmodal2() {
			$("#modal2").fadeOut();
		};

		function refresh() {
			setTimeout(function() {
				location.reload();
			}, 3000);
		}

		// ZONA AJAX
		var nuevo = function() {
			$(".formadd").on("submit", function(e) {
				e.preventDefault();

				var frm = $(this).serialize();
				console.log(frm);
				$.ajax({
					method: "POST",
					url: "models/add/cursos-content-add-2.php",
					dataType: 'json',
					data: frm
				}).done(function(resultado) {
					console.log(resultado);
					if (!resultado.error) {
						$("#info").html("<div class='alerta-exito'><i class='ico icon ion-android-done'></i>Se añadio el contenido con exito!</div>");
						$("#info").fadeOut(4000, function() {
							$(this).html("");
							$(this).fadeIn(3000);
						});
						//refresh();						
						cerrarmodal1();
					} else {
						$("#info").html("<div class='alerta-error'><i class='ico icon ion-alert'></i>Hubo un error en el proceso por favor volver a probar!!</div>");
						$("#info").fadeOut(4000, function() {
							$(this).html("");
							$(this).fadeIn(3000);
						});
						cerrarmodal1();
					}
				});
			});
		}

		var actualizar = function() {
			$("#formedit").on("submit", function(e) {
				e.preventDefault();
				var frm = $(this).serialize();
				//console.log(frm);
				$.ajax({
					method: "POST",
					url: "models/updates/upcursoscontent.php",
					dataType: 'json',
					data: frm
				}).done(function(resultado) {
					console.log(resultado);
					if (!resultado.error) {
						$("#info").html("<div class='alerta-exito'><i class='ico icon ion-android-done'></i>Se añadio el contenido con exito!</div>");
						$("#info").fadeOut(3000, function() {
							$(this).html("");
							$(this).fadeIn(3000);
							refresh();
						});
					} else {
						$("#info").html("<div class='alerta-error'><i class='ico icon ion-alert'></i>Hubo un error en el proceso por favor volver a probar!!</div>");
						$("#info").fadeOut(3000, function() {
							$(this).html("");
							$(this).fadeIn(3000);
						});
					}
				});
			});
		}
	</script>