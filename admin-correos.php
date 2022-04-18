<?php 
  include 'layout/header.php';	
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				
				<div class="box-titles">
					<h1 class="title">Administrador de Correos </h1>
					<h2></h2>				
					<div class="box-botones">
						<!-- <a class="btn" href="admin-grupos.php" title="Ver lista de Grupos">Ir a Grupos</a> -->
						<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>
					</div>
				</div>

				<div class="grupos-content-grupos">
					<div class="tabs-content-grupos">
						<input type="radio" name="grupos" id="cursos" checked>
            <input type="radio" name="grupos" id="clases">
						<div class="tabs-nav">
							<label for="cursos" class="cursos">Correos Masivos</label>
							<label for="clases" class="clases">Correos</label>
						</div>
						<section>
							<!-- CORREOS MASIVOS -->
							<div class="content content-1">															
								<div class="box-tabla mg-bt50 w100">
									<div class="box-titles">
										<h1 class="title">Envíos de correo masivos</h1>					
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
										<p class="text"> <i class="fa fa-circle-envelope"></i> Mensaje....</p>			
									</div>
									<div class="box-botones">										
										<!-- <button type="button" class="btn-1" id="btnseleccionar" ><i class="fas fa-check-square"></i> Seleccionar Todos</button> -->
										<!-- <button type="button" class="btn-1" id="btndeseleccionar" ><i class="far fa-square"></i> Deseleccionar Todos</button>	-->
										<a class="btn" id="anadir-cursos">  <i class="fa fa-pen"></i> Redactar</a>
									</div>
																
									<div class="box-envio-correos">
										<div class="box-listado-usuarios">										
											<p class="title">Lista de Alumnos: </p>
											<ul class="container-wrap">																		
												<?php 
													$datos = selectalldatos($db, 'usuarios');
													if(!empty($datos) && mysqli_num_rows($datos) >= 1):
														while($dato = mysqli_fetch_assoc($datos)):
												?>
													<li>
														<input type="checkbox" name="ids[]" value="<?=$dato['id']?>" class="users"><span class="fullname"><?=$dato['nombre'].' '.$dato['ape_paterno'].' '.$dato['ape_materno']?></span>

													</li>
												<?php endwhile;	endif; ?>
											</ul>
									
										</div>
									</div>
									
													
								</div>										
							</div>
							
							<!-- CORREOS INDIVIDUALES -->
							<div class="content content-2">															
								<div class="box-tabla mg-bt50 w100">
									<div class="box-titles">
										<h1 class="title">Envíos de correos</h1>				
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
									
									<div class="box-info">
										<p class="text"> <i class="fa fa-circle-envelope"></i> Mensaje....</p>				
									</div>
									<div id="info2"></div>
									<!--<div class="box-botones">
										 <button type="button" class="btn-1" id="btnseleccionar" ><i class="fas fa-check-square"></i> Seleccionar Todos</button> 
											<button type="button" class="btn-1" id="btndeseleccionar" ><i class="far fa-square"></i> Deseleccionar Todos</button>
										<a class="btn" id="anadir-cursos"> <i class="fa fa-pen"></i> Redactar</a>
									</div>-->
																
									<div class="box-envio-correos">
										<div class="item-col">
											<div class="box-listado-usuarios">
												<div class="box-input">
													<label>Selecionar destinatario: </lab>								
													<select class="" name="usuario" id="usuario">
														<?php 
															$datos = selectalldatos($db, 'usuarios');
															if(!empty($datos) && mysqli_num_rows($datos) >= 1):
																while($dato = mysqli_fetch_assoc($datos)):
														?>											
															<option value="<?=$dato['id']?>">
																<?=$dato['nombre'].' '.$dato['ape_paterno'].' '.$dato['ape_materno']?>
															</option>
														<?php endwhile; endif;?>																
													</select>
												</div>
												<div class="box-input">
													<label for="asunto">Asunto:</label>
													<input type="text" placeholder="Ingresa un Asunto al correo"> 
												</div>
												<div class="box-input">
													<label for="mensaje">Mensaje:</label>
													<textarea name="mensaje" id="" cols="" rows=""></textarea>
												</div>				
												<!--<input type="submit" class="btn" value="Enviar"> -->
												<button class="btn">Enviar <i class="fa fa-paper-plane" aria-hidden="true"></i></button>										
											</div>
										</div>
										
										<div class="item-col">
											<div class="box-model-email">

											</div>
										</div>
									</div>

								</div>										
							</div>
							
						</section>
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
		CKEDITOR.replace( 'mensaje' ); 
</script>

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
					info.html("<div class='alerta-exito box-message'>Se añadieron los curso</div>");
				}			
			});
		}else{
			var info = $("#info");
			info.html("<div class='alerta-error box-message'>Debe seleccionar un curso</div>");
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
					var info2 = $("#info2");					
					info2.html("<div class='alerta-exito box-message'>Se añadieron las clases maestras</div>");
				}			
			}); 
		}else{
			var info2 = $("#info2");			
			info2.html("<div class='alerta-error box-message'>Debe seleccionar una clase</div>");
		}

	}); 

	function refresh() {
    setTimeout(function () {
			location.reload();
    }, 2000);
	}

	
</script>
