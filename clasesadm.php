<?php
	include 'layout/header.php';
	if($_GET['cl'] == ""){
		$textoerror = '<h2 class="title">La Clase que buscas no exite, oh no se encontro.</h2>';
		header("Refresh:3; url=cursos.php");
	}
	
	$clase_id = isset($_GET['cl']) ? $_GET['cl'] : '';
	$curso_contenido = (isset($_GET['cc']) ? $_GET['cc'] : '');
	$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
	//$usuario_perfil = $_SESSION['sesion_aprenDigital']['perfil_id'];
?>

<body>
	<?php include 'layout/aside.php'; ?>
	<section class="home-section">
		<?php include 'layout/perfil.php'; ?>

		<div class="portal-clases">			
			<div class="box-titles">
				<?php
					$cursos = obtenerdatosactivo($db, 'clases', $clase_id);
					if (!empty($cursos) && mysqli_num_rows($cursos) >= 1) :
						$cant = mysqli_num_rows($cursos);
						//echo $cant;
						while ($curso = mysqli_fetch_assoc($cursos)) :
				?>
					<h2 class="title">Clase Maestra : <?= $curso['nombre'] ?> </h2>
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

			<div class="inner-portal-clases-maestras">				

				<div class="content-media">								
					<?php
						$cursos = obtenerdatosactivo($db, 'clases', $clase_id);
						if (!empty($cursos) && mysqli_num_rows($cursos) >= 1) :
							$cant = mysqli_num_rows($cursos);
							//echo $cant;
							while ($curso = mysqli_fetch_assoc($cursos)) :
					?>
								
						<div class="box-video" id="player"> 
							<?=$curso['url'];?>												
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