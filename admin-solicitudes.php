<?php 
  include 'layout/header.php';

	$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
	$usuario_perfil = $_SESSION['sesion_aprenDigital']['perfil_id'];

	if($usuario_perfil >= 3){
		header("Location:dashboard.php");
	}
?>

<?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
          <h1 class="title">Administración de Solicitudes de Usuarios</h1>
				</div>
				<!-- <div class="box-botones mg-bt20">						
					<a href="admin-instituciones.php" class="btn" title="Añadir Curso"><i class="fas fa-plus"></i> Administrar Instituciones</a>
				</div> -->
				<!---------------- REGISTROS ---------------->
				<div id="info"></div>
				<?php if(isset($_SESSION['completado'])): ?>
					<div class="alerta-exito">
						<?=$_SESSION['completado']?>  
					</div>
				<?php elseif(isset($_SESSION['fallo'])): ?>
					<div class="alerta-error">
						<?=$_SESSION['fallo']?>
					</div>
				<?php endif; ?> 
				<div class="container-wrap w100">					
					<hr class="w100">
					<div class="box-tabla mg-bt50 w100">
						<div class="box-titles">
							<h1 class="title">Solicitudes Recibidas</h1>							
						</div>		
						<table id="dt_listaUsuarios" class="hover w100">
							<thead>
								<tr>						
                  <th class="">ID</th>
									<th class="">NOMBRES Y APELLIDOS</th>															
									<th class="">EMAIL</th>														
									<th class=""># WHATSAPP</th>														
									<th class="">FECHA NACIMIENTO</th>							
									<th class="">FECHA SOLICITUD</th>							
									<th class="">SOLICITUD LEIDA</th>							
									<?php if($_SESSION['sesion_aprenDigital']['perfil_id'] <= '2'): ?>	
                    <th class="">Opciones</th>	
									<?php endif; ?>
								</tr>	
							</thead>
						</table>
            <!-- FIN TABLA -->					
					</div>
				</div>
			</div>
			<!---- FIN CENTER  ---->	
		</div>
		<!---- FIN DEL CONTENIDO ---->	
	
  </section>
</main>

<?php borrarErrores(); ?>	
<?php include 'layout/footer.php'; ?>
<?php include 'layout/footer_datatables.php'; ?>

<!-- ----- MODAL 1 ----- -->
<!-- ----- EDITAR  ----- -->
<div class="modal" id="modal1">
	<div class="body-modal">
		<form action="" method="post" name="frm_actualizar" id="frm_actualizar" onsubmit="event.preventDefault(); ">			
			<h2 class="title mg-bt10">Modificar datos Principales</h2><hr>
			<div class="container-wrap">		
				<input class="" type="hidden" name="id" id="id" readonly>				
				<!-- <input class="" type="text" name="id" id="id2" disabled>		 -->									
				<div class="w50 box-input mg-bt20">
					<label class="" for="nombre">Nombres</label>	
					<input class="" type="text" name="nombre" id="nombre" required>	
				</div>
				<div class="w50 box-input mg-bt20">
					<label class="" for="">Apellido Paterno</label>		
					<input class="" type="text" name="apepaterno" id="apepaterno" required>	
				</div>
				<div class="w50 box-input mg-bt20">
					<label class=" " for="">Apellido Materno:</label>
					<input class="" type="text" name="apematerno" id="apematerno" required>		
				</div>			
				<div class="w50 box-input mg-bt20">
					<label class=" " for="">Documento Identidad:</label>
					<input class="" type="text" name="docidentidad" id="docidentidad" required>		
				</div>				
				<div class="w50 box-input mg-bt20">
					<label for="">Sexo: </label>
					<select class="w70" name="sexo" id="sexo">
					<?php 
						$sexos = selectalldatos($db, 'sexo');
						if(!empty($sexos) && mysqli_num_rows($sexos) >= 1):
							while($sexo = mysqli_fetch_assoc($sexos)):
					?>											
						<option value="<?=$sexo['id']?>" <?=($sexo['id']) == $perfil['sexo_id'] ? 'selected="selected"': '' ?>>
							<?=$sexo['nombre']?>
						</option>										
					<?php endwhile; endif; ?>																
					</select>									
				</div>		
				<div class="w50 box-input mg-bt20">
					<label class="" for="email">Correo: <span class="font-light">(no se permite cambiar)</span></label>
					<input class="" type="email" name="email" id="email" readonly>		
				</div>											
				<div class="w50 box-input">
					<label for="">Institución: </label>
					<select class="w70" name="institucion" id="institucion">
					<?php 
						$datos = selectalldatos($db, 'instituciones');
						if(!empty($datos) && mysqli_num_rows($datos) >= 1):
							while($dato = mysqli_fetch_assoc($datos)):
					?>
						<option value="<?=$dato['id']?>" <?=($dato['id']) == $perfil['institucion_id'] ? 'selected="selected"': '' ?>>
							<?=$dato['nombre']?>								
						</option>
					<?php 
						endwhile;
					endif;
					?>																
					</select>									
				</div>	
				<div class="w50 box-input mg-bt20">
					<label class="" for="">Cambiar de Perfil</label>
					<select class="" name="perfil" id="perfil" required>
						<option value="" disabled >Seleccionar perfil</option>
						<?php 
							$perfiles = selectalldatos($db, 'perfil');
							if(!empty($perfiles) && mysqli_num_rows($perfiles) >= 1):
								while($dato = mysqli_fetch_assoc($perfiles)):
						?>
							<?php if($dato['id'] <= '1' ): ?>
								<option value="<?=$dato['id']?>" disabled><?=$dato['nombre']?></option>
							<?php elseif($dato['id'] == '4' ): ?>
								<option value="<?=$dato['id']?>" <?=($dato['id']) == $perfil['perfil_id'] ? 'selected="selected"': '' ?>><?=$dato['nombre']?></option>				
							<?php else: ?>
									<option value="<?=$dato['id']?>"><?=$dato['nombre']?></option>
							<?php endif; ?>										
						<?php endwhile; endif; ?>
					</select>	
				</div>
				<div class="box-input w50 mg-bt20">
					<label for='clave' >Clave Nueva</label>
					<input type='hidden' name="clave-actual" id="clave-actual">
					<input type='text' placeholder="Clave nueva" name="clave" id="clave"><br><br>
					<a class="btn" onclick="getPassword();">Generar Clave</a>
				</div>
				<div class="box-input w50 mg-bt20">
					<label for='clave' >Celular</label>					
					<input type='text' name="celular" id="celular"><br><br>				
				</div>
			</div>
			<hr>
			<input type="submit" class="btn" value="Actualizar Datos">
			<a href="#" class="btn" onclick="cerrarmodal()"> Cancelar</a>
		</form>
	</div>
</div>

<!-- ----- ELIMINAR  ----- -->
<div class="modal" id="modal2">
	<div class="body-modal">
		<form action="" method="post" name="form_eliminar" id="form_eliminar" onsubmit="event.preventDefault();">			
			<h2 class="title">¿Estas de Seguro de Eliminar?</h2><hr>
			<div class="container3">					
				<p class="mensaje">¡No podrás revertir esto!</p>	
				<input type="hidden" name="id" id="id" >				
				<div class="box-nombre w100" id="box-nombre"></div>
			</div>
			<input type="submit" class="btn" value="Borrar">
			<a href="#" class="btn" onclick="cerrarmodal()"> Cancelar</a>
		</form>
	</div>
</div>

<!-- ----- CAMBIAR ESTADO A SOLICITUD   ----- -->
<div class="modal" id="modal3">
	<div class="body-modal">
		<form action="" method="post" class="form_sendMail" id="form_sendMail" onsubmit="event.preventDefault();">			
			<h2 class="title">Confirmar solicitud como recibida </h2><hr>
			<p class="text">Se cambiará el estado de la solicitud como recibida y leida.</p>
			<div class="container3">					
				<input type="hidden" name="idEstado" id="id">			
				<div class="box-nombre w100" id="box-nombre"></div>
				<div class="box-correo w100" id="box-correo"></div>
			</div>
			<input type="submit" class="btn" value="Solicitud Recibida">
			<a href="#" class="btn" onclick="cerrarmodal()"> Cancelar</a>
		</form>
	</div>
</div>
<!-- FIN MODAL -->

<script>

	$(document).ready(function(){
		listar();
		actualizar();
		eliminar();
		stateReade();
	});

	function cerrarmodal(){
		$("#modal1").fadeOut();		
		$("#modal2").fadeOut();		
		$("#modal3").fadeOut();		
	};

	function refresh() {
    setTimeout(function () {
			location.reload();
			listar();			
    }, 3000);
	}

	function refresh2() {
    setTimeout(function () {
			location.reload();
			listar();
    }, 1000);
	}

	// ZONA AJAX
	var actualizar = function(){
		$("#frm_actualizar").on("submit", function(){		
			//e.preventDefault();
			var frm = $(this).serialize();
			//console.log(frm);
			$.ajax({
				method: "POST",
				url: "models/updates/upsolicitudAlumno.php",
				dataType: 'json',
				data: frm
			}).done(function(resultado){			
					console.log(resultado);																		
					if(!resultado.error){						
						$("#info").html("<div class='alerta-exito'><i class='far fa-check-circle'></i> Se actualizarón los datos con exito!</div>");
						$("#info").fadeOut(5000, function(){
							$(this).html("");
							$(this).fadeIn(2000);
						});						
						cerrarmodal();
						listar();										
					}else{
					$("#info").html("<div class='alerta-error'><i class='fas fa-times-circle'></i> Hubo un error en el proceso por favor volver a probar!!</div>");
					$("#info").fadeOut(5000, function(){
						$(this).html("");
						$(this).fadeIn(2000);
						});
					cerrarmodal();	
					}							
			});
		});	
	}

	var eliminar = function(){
		$("#form_eliminar").on("submit", function(){		
		$.ajax({
			method:"POST",
			url: "models/deletes/solicitudAlumno-delete.php",
			dataType:"json",
			data: $(this).serialize()
		}).done(function(resultado){
			console.log(resultado);			
			//listar();
			if(!resultado.error){						
				$("#info").html("<div class='alerta-exito'><i class='far fa-check-circle'></i> Se elimino con exito!</div>");	
				$("#info").fadeOut(5000, function(){
					$(this).html("");
					$(this).fadeIn(3000);
				});						
				cerrarmodal();
				listar();				
			}else{
				$("#info").html("<div class='alerta-error'><i class='fas fa-times-circle'></i>Hubo un error en el proceso por favor volver a intentar!!</div>");
					$("#info").fadeOut(5000, function(){
						$(this).html("");
						$(this).fadeIn(3000);
					});
					cerrarmodal();
			}
			});
		});
	}

	var stateReade = function(){
		$("#form_sendMail").on("submit", function(){		
			$.ajax({
				method:"POST",
				url: "models/updates/solicitud-alumnos-estado.php",
				dataType:"json",
				data: $(this).serialize()			
			}).done(function(resultado){
				console.log(resultado);					
				if(!resultado.error){						
					$("#info").html("<div class='box-message alerta-exito'><i class='far fa-check-circle'> </i> Se modificó el estado de forma con exito!</div>");	
					$("#info").fadeOut(5000, function(){
						$(this).html("");
						$(this).fadeIn(3000);
					});						
					cerrarmodal();
					refresh();				
				}else{
					$("#info").html("<div class='box-message alerta-error'><i class='fas fa-times-circle'></i> Hubo un error en el proceso por favor volver a intentar!!</div>");
						$("#info").fadeOut(5000, function(){
							$(this).html("");
							$(this).fadeIn(3000);
						});
						cerrarmodal();
				}
			});
		});
	}
	
	var listar = function(){
		var table = $("#dt_listaUsuarios").DataTable({
			"dom": 'Bfrtip',
      "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
      ],			
      // "responsive": true,
			// "scrollX": true,
			"destroy":true,
			"ajax":{
				'method':'POST',
				'url':'models/searchs/solicitudes.php'
			},
			"columns":[
				{"data":"id"},
				{"data":"nombres"},
				{"data":"email"},			
				{"data":"telefono"},			
				{"data":"fecnacimiento"},					
				{"data":"fechasolicitud"},			
				{"data":"otros"}
				//{"data":"estadocivil.toUpperCase()"},					
				<?php if($_SESSION['sesion_aprenDigital']['perfil_id'] <= '2'): ?>
				,
				{"defaultContent": "<a class='envio btn-2 btn-azul' title='Soliciud Leida'><i class='fa fa-check'></i></a><a class='editar btn-2 btn-azul' title='Editar'><i class='fas fa-pen'></i></a><a class='eliminar btn-2 btn-rojo' title='Borrar'><i class='fas fa-trash-alt'></i></a>"}	
				<?php endif; ?>		
			],
			
			"language": idioma_espanol,
			"pageLength":100
		});
		obtener_data_editar("dt_listaUsuarios tbody", table);
		obtener_data_eliminar("dt_listaUsuarios tbody", table);
		obtener_data_envio ("dt_listaUsuarios tbody", table);
	}

	var obtener_data_editar = function(tbody, table){
	$(document).on("click",".editar",function(){	
		var data = table.row( $(this).parents("tr")).data();
			$("#modal1").fadeIn();
			$("#frm_actualizar #nombre").focus();				
			console.log(data);
			 var id= $("#frm_actualizar #id").val(data.id); 			  
					nombre = $("#frm_actualizar #nombre").val(data.nombre);
					apepaterno = $("#frm_actualizar #apepaterno").val(data.ape_paterno);
					apematerno = $("#frm_actualizar #apematerno").val(data.ape_materno);
					docidentidad = $("#frm_actualizar #docidentidad").val(data.doc_identidad);
					celular = $("#frm_actualizar #celular").val(data.celular);
					correo = $("#frm_actualizar #email").val(data.email);			
					institucion = $("#frm_actualizar #institucion").val(data.institucion_id);			
					perfil = $("#frm_actualizar #perfil").val(data.perfil_id)		
					sexo = $("#frm_actualizar #sexo").val(data.sexo_id)		
					claveActual = $("#frm_actualizar #clave-actual").val(data.clave)		
		});
	}

	var obtener_data_eliminar = function(tbody, table){
	$(document).on("click",".eliminar",function(){	
		var data = table.row( $(this).parents("tr")).data();
			$("#modal2").fadeIn();
			console.log(data);
			 var id = $("#form_eliminar #id").val(data.id);
			 	nombre = $("#form_eliminar #box-nombre").html('Borrar la solicitud de ' +data.nombres + ' ' + data.apellidos);
		});
	}

	var obtener_data_envio = function(tbody, table){
	$(document).on("click",".envio",function(){	
		var data = table.row( $(this).parents("tr")).data();
		//console.log(data);
			$("#modal3").fadeIn();		
			 var id = $("#form_sendMail #id").val(data.id);			 		
			 	nombre = $("#form_sendMail #box-nombre").html('Solicitud  <br><span>' + data.nombres + ' </span>');
			 	email = $("#form_sendMail #box-correo").html('Correo  <br><span>' + data.email + '</span>');
		});
	}

	var idioma_espanol = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }	
	}
</script>
