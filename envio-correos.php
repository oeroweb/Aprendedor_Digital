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
						<a class="btn" href="admin-multi-accesos.php" title="Ver lista de Grupos">Ir a Multi-accesos</a>
						<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>
					</div>
				</div>

				<div class="grupos-content-grupos">
					<div class="tabs-content-grupos">
						<input type="radio" name="grupos" id="cursos" checked>
            <input type="radio" name="grupos" id="clases">
						<div class="tabs-nav">
							<label for="cursos" class="cursos">Correos para Alumnos</label>
							<label for="clases" class="clases">Correos para Todos</label>
						</div>
						<section>
							<!-- CORREOS ALUMNOS -->
							<div class="content content-1">															
								<div class="box-tabla mg-bt50 w100">
									<div class="box-titles">
										<h1 class="title">Envíar correo para alumnos:</h1>					
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
																
									<div class="box-envio-correos">
										<div class="box-filtros">
											<h3 class="title">Filtrar Alumnos: </h3>
											<form id="form-multi-filters-alumnos">
												<ul class="container-wrap">

													<li class="list-filtro">
														<h3>Tipo de Acceso</h3>														
														<div class="item-list">
															<label ><input type="checkbox" class="form-check-input-alumnos" name="perfil_id[]" value="4" ><span>Alumnos</span></label>
														</div>
														
													</li>
													<li class="list-filtro">
														<h3>Grupos</h3>
														<?php 
															$datos = selectalldatos($db, 'grupos');
															if(!empty($datos) && mysqli_num_rows($datos) >= 1):
																while($dato = mysqli_fetch_assoc($datos)):
														?>
															<div class="item-list">
																<label><input type="checkbox" class="form-check-input-alumnos" name="grupo_id[]" value="<?=$dato['id']?>" ><?=$dato['nombre']?></label>
															</div>
														<?php endwhile;	endif; ?>
													</li>											
													<li class="list-filtro">
														<h3>Instituciones</h3>
														<?php 
															$datos = selectalldatos($db, 'instituciones');
															if(!empty($datos) && mysqli_num_rows($datos) >= 1):
																while($dato = mysqli_fetch_assoc($datos)):
														?>
														<div class="item-list">
															<label><input type="checkbox" class="form-check-input-alumnos" name="institucion_id[]" value="<?=$dato['id']?>" ><?=$dato['nombre']?></label>
														</div>
														<?php endwhile;	endif; ?>
													</li>																								
													<li class="list-filtro">
														<h3>Estados</h3>														
															<div class="item-list">
																<label><input type="checkbox" class="form-check-input-alumnos" name="estado_login[]" value="conectado" >Conectado</label>
																<label><input type="checkbox" class="form-check-input-alumnos" name="estado_login[]" value="desconectado" >Desconectado</label>
																<label><input type="checkbox" class="form-check-input-alumnos" name="estado_login[]" value="No accedio" >No accedío</label>
															</div>													
													</li>

												</ul>
											</form>
										</div>
										<div class="box-listado-usuarios">
											<div class="box-title">
												<h3 class="title">Para: </h3>
												<div class="box-botones">										
													<button type="button" class="btn-1" id="btnseleccionar" ><i class="fas fa-check-square"></i> Seleccionar Todos</button>
													<button type="button" class="btn-1" id="btndeseleccionar" ><i class="far fa-square"></i> Deseleccionar Todos</button>												
												</div>
											</div>
											<table class="box-tabla w100" id="dt_alumnos">
												<thead>
													<tr>
														<th>#</th>
														<th>Nombre</th>
														<th>Correo</th>
														<th>Grupo</th>
														<th>Institución</th>
														<th>Estado</th>
														<th>Pa&iacute;s</th>
													</tr>
												</thead>
												<tbody id="filters-result-alumnos" class="">
												</tbody>
											</table>
											<div class="box-mensaje">
												<div class="box-input">
													<label for="asunto">Asunto:</label>
													<input type="text" id="asunto" placeholder="Ingresa asunto del correo"> 
												</div>
												<div class="box-input">
													<label for="mensaje">Mensaje:</label>
													<textarea name="mensaje" id="mensaje"></textarea>
												</div>				
												<!--<input type="submit" class="btn" value="Enviar"> -->
												<button class="btn" id="enviar-correo">Enviar Correos<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
											</div>
										</div>
									</div>
									
													
								</div>										
							</div>
							
							<!-- CORREOS USUARIOS -->
							<div class="content content-2">															
								<div class="box-tabla mg-bt50 w100">
									<div class="box-titles">
										<h1 class="title">Envíos de correo:</h1>					
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
									<div id="info2"></div>
									<div class="box-info">
										<p class="text"> <i class="fa fa-circle-envelope"></i> Mensaje....</p>			
									</div>									
																
									<div class="box-envio-correos">
										<div class="box-filtros">
											<h3 class="title">Filtrar Usuarios: </h3>
											<form id="form-multi-filters-usuarios">
												<ul class="container-wrap">
													<li class="list-filtro">
														<h3>Tipo de Acceso</h3>
														<?php 
															$datos = selectalldatos($db, 'perfil');
															if(!empty($datos) && mysqli_num_rows($datos) >= 1):
																while($dato = mysqli_fetch_assoc($datos)):
														?>
														<div class="item-list">
															<label ><input type="checkbox" class="form-check-input-usuarios" name="perfil_id[]" value="<?=$dato['id']?>" ><span><?=$dato['nombre']?></span></label>
														</div>
														<?php endwhile;	endif; ?>
													</li>																							
													<li class="list-filtro">
														<h3>Instituciones</h3>
														<?php 
															$datos = selectalldatos($db, 'instituciones');
															if(!empty($datos) && mysqli_num_rows($datos) >= 1):
																while($dato = mysqli_fetch_assoc($datos)):
														?>
														<div class="item-list">
															<label><input type="checkbox" class="form-check-input-usuarios" name="institucion_id[]" value="<?=$dato['id']?>" ><?=$dato['nombre']?></label>
														</div>
														<?php endwhile;	endif; ?>
													</li>
																								
													<li class="list-filtro">
														<h3>Estados</h3>														
															<div class="item-list">
																<label><input type="checkbox" class="form-check-input-usuarios" name="estado_login[]" value="conectado" >Conectado</label>
																<label><input type="checkbox" class="form-check-input-usuarios" name="estado_login[]" value="desconectado" >Desconectado</label>
																<label><input type="checkbox" class="form-check-input-usuarios" name="estado_login[]" value="No accedio" >No accedío</label>
															</div>													
													</li>												
												</ul>
											</form>
										</div>
										<div class="box-listado-usuarios">
											<div class="box-title">
												<h3 class="title">Para: </h3>
												<div class="box-botones">										
													<button type="button" class="btn-1" id="btnseleccionar2" ><i class="fas fa-check-square"></i> Seleccionar Todos</button>
													<button type="button" class="btn-1" id="btndeseleccionar2" ><i class="far fa-square"></i> Deseleccionar Todos</button>			
												</div>
											</div>
											<table class="box-tabla w100" id="dt_usuarios">
												<thead>
													<tr>
														<th>#</th>
														<th>Nombre</th>
														<th>Correo</th>														
														<th>Institución</th>
														<th>Estado</th>
														<th>Pa&iacute;s</th>
													</tr>
												</thead>
												<tbody id="filters-result-usuarios" class="">
												</tbody>
											</table>
											<div class="box-mensaje">
												<div class="box-input">
													<label for="asunto">Asunto:</label>
													<input type="text" id="asunto2" placeholder="Ingresa asunto del correo"> 
												</div>
												<div class="box-input">
													<label for="mensaje">Mensaje:</label>
													<textarea name="mensaje2" id="mensaje2"></textarea>
												</div>				
												<!--<input type="submit" class="btn" value="Enviar"> -->
												<button class="btn" id="enviar-correo2">Enviar Correos<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
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
		<span class="ir-arriba hidden" id="btnArriba" title="Subir"><i class="fa fa-chevron-up"></i></span>
	<?php include 'layout/footer.php'; ?>
</div>
</main>

<script>
	// CKEDITOR.editorConfig = function( config ) {
	// 	config.uiColor = '#d3e7f8';
	// 	config.height = 200;
	// 	config.removePlugins = 'elementspath,resize';
	// 	config.allowedContent = false; 
	// 	config.forcePasteAsPlainText = true; 
	// 	config.enterMode = CKEDITOR.ENTER_BR; 
	// 	config.keystrokes = [
	// 		[CKEDITOR.CTRL + 86 /* V */, 'paste']
	// 	]; 
 
	// 	config.blockedKeystrokes = [
	// 		CKEDITOR.CTRL + 86
	// 	];

	// 	config.toolbar = [
	// 		{ name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', '-', 'Templates' ] },
	// 		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	// 		{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },			
	// 		'/',
	// 		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
	// 		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },				
	// 		{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
	// 		'/',
	// 		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	// 		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
	// 		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
			
	// 	];

	// }
	
	CKEDITOR.replace( 'mensaje', {
		uiColor : '#d3e7f8',
		removePlugins : 'elementspath,resize',
		toolbar : [	 	
	 		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
			{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
			{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', , 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-',  'Language' ] },
			{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
			{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		]
	});
	
	CKEDITOR.replace( 'mensaje2', {
		uiColor : '#d3e7f8',
		removePlugins : 'elementspath,resize',
		toolbar : [	 	
	 		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
			{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
			{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', , 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-',  'Language' ] },
			{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
			{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		]
	}); 
	

</script>

<script>

	$(function ()	{
		
		get_alumnos();
		$(".form-check-input-alumnos").on("click", function (){
			get_alumnos();
		});

		get_users();
		$(".form-check-input-usuarios").on("click", function (){
			get_users();
		});

	});

	function get_alumnos(){
    let form = $("#form-multi-filters-alumnos");
    $.ajax(
        {
					type: "POST",
					url: "models/searchs/filtroAlumnos.php",
					data: form.serialize(),
					success: function (data)
					{
						if(data == 2){
							
							$("#filters-result-alumnos").html("<tr><td colspan='7'>No hay datos para mostrar, intenta nuevamente!</td></tr>");

						} else{
							$("#filters-result-alumnos").html("");
	
							$.each(JSON.parse(data), function(key, User){
								let row = ""+
										"<tr>" +
										"<td><input type='checkbox' class='alumnos' value='"+key+"'></td>" +
										"<td>"+User.nombre+" "+User.ape_paterno+"</td> " +
										"<td>"+User.email+"</td> " +
										"<td>"+User.nombreGrupo+"</td> " +
										"<td>"+User.nombreInstitucion+"</td> " +									
										"<td>"+User.estado_login+"</td> " +									
										"<td>"+User.pais+"</td> " +
										"</tr>";
	
								$("#filters-result-alumnos").append(row);
							});

						}

					}, 
        }
  	)
	}

	function get_users(){
    let form = $("#form-multi-filters-usuarios");
    $.ajax(
        {
					type: "POST",
					url: "models/searchs/filtroUsuarios.php",
					data: form.serialize(),
					success: function (data)
					{
						if(data == 2){

							$("#filters-result-usuarios").html("<tr><td colspan='7'>No hay datos para mostrar, intenta nuevamente!</td></tr>");

						} else{

							$("#filters-result-usuarios").html("");

							$.each(JSON.parse(data), function(key, User){
								let row = ""+
										"<tr>" +
										"<td><input type='checkbox' class='users' value='"+key+"'></td>" +
										"<td>"+User.nombre+" "+User.ape_paterno+"</td> " +
										"<td>"+User.email+"</td> " +									
										"<td>"+User.nombreInstitucion+"</td> " +									
										"<td>"+User.estado_login+"</td> " +									
										"<td>"+User.pais+"</td> " +
										"</tr>";

								$("#filters-result-usuarios").append(row);
							});						 
							
						 }
					}
        }
  	)
	}

	$(document).ready(function(){
		
		$("#btnseleccionar").click(function(){			
				$("#dt_alumnos input[type=checkbox]").attr("checked", true);
			});		
  
		$("#btndeseleccionar").click(function(){
			$("#dt_alumnos input[type=checkbox]").attr("checked", false);
		});

		$("#btnseleccionar2").click(function(){			
				$("#dt_usuarios input[type=checkbox]").attr("checked", true);
			});		
  
		$("#btndeseleccionar2").click(function(){
			$("#dt_usuarios input[type=checkbox]").attr("checked", false);
		});

	});

	$( "#enviar-correo" ).click(function() {		
		var ids_array = [];		
		var asunto = $("#asunto").val();
		//var mensaje = $("#cke_1_contents").getData();
		var mensaje = CKEDITOR.instances['mensaje'].getData();


		$("input:checkbox[class=alumnos]:checked").each(function () {
			ids_array.push($(this).val());
		});

		if (ids_array.length>0) {
			console.log(ids_array, asunto, mensaje);
			//url = "models/sendmail/sendEmailUsuarios.php";			
			$.ajax({
				type: "POST",
				url: url,
				data: {ids_array : ids_array, asunto : asunto, mensaje : mensaje},
				success: function(respuesta){
					console.log(respuesta);
					//refresh();
					var info = $("#info");
					info.html("<div class='alerta-exito box-message'><i class='fa fa-check-circle'></i> Correo enviado de forma exitosa</div>");
				}			
			});
		}else{
			var info = $("#info");
			info.html("<div class='alerta-error box-message'> <i class='fa fa-exclamation-triangle'></i> Debe seleccionar un alumno</div>");
		}

	}); 

	$( "#enviar-correo2" ).click(function() {		
		var ids_array = [];
		var asunto = $("#asunto2").val();
		var mensaje = $("#mensaje2").val();
		$("input:checkbox[class=users]:checked").each(function () {
			ids_array.push($(this).val());
		});

		if (ids_array.length>0) {
			console.log(ids_array, asunto, mensaje);
			url = "models/sendmail/sendEmailUsuarios.php";			
			$.ajax({
				type: "POST",
				url: url,
				data: {ids_array : ids_array, asunto : asunto, mensaje : mensaje},
				success: function(resultado){
					console.log(resultado);
					//refresh();
					var info2 = $("#info2");					
					info2.html("<div class='alerta-exito box-message'><i class='fa fa-check-circle'></i> Correo enviado de forma exitosa</div>");
				}			
			}); 
		}else{
			var info2 = $("#info2");			
			info2.html("<div class='alerta-error box-message'> <i class='fa fa-exclamation-triangle'></i> Debe seleccionar un usuario</div>");
		}

	}); 

	function refresh() {
    setTimeout(function () {
			location.reload();
    }, 2000);
	}

	
</script>
