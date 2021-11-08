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
					$cursos = obtenerdatos($db, 'cursos', $id);
					if (!empty($cursos) && mysqli_num_rows($cursos) >= 1) :
						while ($curso = mysqli_fetch_assoc($cursos)) :
					?>
							<h2 class="title">Curso <?= $curso['nombre'] ?> </h2>
					<?php
						endwhile;
					endif;
					?>
					<div class="box-botones">
						<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>
					</div>
				</div>
				<div class="box-botones">				
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
				<div class="inner-cursos-content ">
					<div class="accordion">
						<?php
						$contenidos = obtenerContenidoCurso($db, 'cursos_contenido', $id);
						if (!empty($contenidos) && mysqli_num_rows($contenidos) >= 1) :
							while ($contenido = mysqli_fetch_assoc($contenidos)) :
								$contenidoid =	$contenido['id']
						?>
						<div class="content-accordion">
						<div class="btn-accordion"><i class="fas fa-chevron-up"></i></div>
							<div class="box-label">
								<h2 class="title"><?= $contenido['nombre'] ?> </h2>
							</div>
							<div class="inner-content-accordion">
								<div class="container-wrap">
									<div class="w20 bold al-ct">Video / HTML</div>
									<div class="w20 bold al-ct">Tema</div>
									<div class="w20 bold al-ct">Orden a Mostrar</div>
									<div class="w20 bold al-ct">Archivos</div>
									<div class="w20 bold al-ct">Opciones</div>
								</div>
								<hr>
								<?php
								$detalles = obtenerdetalleContenido($db, 'cursos_contenido_detalle', $contenidoid);
								if (!empty($detalles) && mysqli_num_rows($detalles) >= 1) :
									while ($detalle = mysqli_fetch_assoc($detalles)) :
								?>
									<div class="box-content-details">
										<div class="box-video w20">
											<?php if($detalle['video']) :?>												
												<video class="w100" src="assets/cursos/<?=$detalle['carpeta']."/".$detalle['video']?>" controls muted preload="auto"></video>
											<?php else: ?>
												<?=$detalle['url_video'];?>
											<?php endif; ?>
										</div>
										<h3 class="w20 al-ct"><?= $detalle['nombre'] ?> </h3>
										<p class="w20 al-ct"><?= $detalle['orden'] ?> </p>
										<p class="w20 al-ct">
											<?php if($detalle['archivos']) :
												$misarchivos = $detalle['archivos'];																			
												$array_misarchivos = explode(', ', $misarchivos); 
												foreach( $array_misarchivos as $archivo) : ?>															
													<a href="assets/cursos/<?=$detalle['carpeta']."/".$archivo?>" class="btn" download><?=$archivo?></a>
											<?php endforeach;
												else : ?>									
												<span>No tiene archivos</span>
											<?php endif; ?>									
										</p>
										
										<div class="box-botones al-ct w20">												
											<a href="curso-details-edit.php?id=<?=$detalle['id']?>" class="btn-2 btn-azul" title="Editar"><i class="fas fa-pen"></i></a>
											<a href="models/deletes/contenido-detalle-delete.php?id=<?=$detalle['id']?>" class=" btn-2" title="Borrar" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
										</div>
									</div>
								<?php endwhile;
								endif; ?>
							</div>
						</div>
							<?php endwhile;
						else :
							?>
							<div class="content-accordion">
								<div class="box-label">
									<h2 class="title">No hay contenido para mostrar.</h2>
								</div>

							<?php endif; ?>

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

	<div class="modal" id="modal3">
		<div class="body-modal">
			<form action="" class="box-formulario formedit" method="post" id="formedit">
				<div class="w100 container-wrap mg-bt10">
					<div class="box-input">
						<label for="nombre">Nombre del Capitulo: </label>
						<input type="hidden" value="<?= $idcurso ?>" name="id" id="idcurso">
						<input class="w100" type="text" name="nombre" value="<?= $nombre ?>" id="nombre">
					</div>
					<div class="box-input">
						<label for="descripcion">Breve Descripcion: </label>
						<input class="w100" type="text" name="descripcion" value="<?= $descripcion ?>" id="descripcion">
					</div>
					<div class="box-input">
						<label for="Orden">Orden a mostrar: </label>
						<input class="w100" type="number" name="orden" value="<?= $orden ?>" min="1" id="orden">
					</div>
				</div>
				<input type="submit" value="Editar" class="btn">
				<a href="#" class="btn" onclick="cerrarmodal3()"> Cancelar</a>
			</form>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			nuevo();
			actualizar();
			//eliminar();		
		});

		function openmodal1() {
			$("#modal1").fadeIn();
		};

		function openmodal2() {
			$("#modal2").fadeIn();
		};

		function openmodal3() {
			$("#modal3").fadeIn();
		};


		function cerrarmodal1() {
			$("#modal1").fadeOut();
		};

		function cerrarmodal2() {
			$("#modal2").fadeOut();
		};

		function cerrarmodal3() {
			$("#modal3").fadeOut();
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