<?php 
  include 'layout/header.php'; 
?>

<?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
          <h1 class="title">Administración de Usuarios / Docentes / Alumnos</h1>
				</div>
				<div class="box-botones mg-bt20">						
				<a href="admin-instituciones.php" class="btn" title="Añadir Curso"><i class="fas fa-plus"></i> Administrar Instituciones</a>
				</div>
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
					<form action="usuarios-add.php" class="box-formulario-container w100" method="post">
						<div class="box-input-container">
							<label for="number">Cantidad de usuarios:</label>
							<input type="number" name="number" value="1" >
						</div>
						<input type="submit" class="btn" value="Añadir Usuarios">
					</form>
					<form action="usuarios-file-add.php" class="box-formulario-container w100" method="post">
						<div class="box-input-container">
							<label for="number">Subir Excel:</label>
							<input type="file" class="" name="excel" accept="application/vnd.ms-excel" required>							
						</div>
						<input type="submit" class="btn" value="Añadir Usuarios por Archivos">
					</form>
					
					<hr class="w100">
					<div class="box-tabla mg-bt50 w100">
						<div class="box-titles">
							<h1 class="title">Lista de Usuarios</h1>
							<!-- <div class="box-botones">						
								<a href="#" class="btn-2 btn-azul " title="Editar Perfil"><i class="fas fa-pen"></i></a>						 
							</div> -->
						</div>									
						<table id="dt_listaUsuarios" class="w100">
							<thead>
								<tr>						
                  <th class="">ID</th>
									<th class="">NOMBRES</th>							
									<th class="">APE. PATERNO</th>							
									<th class="">APE. MATERNO</th>							
									<th class="">EMAIL</th>							
									<th class="">CELULAR</th>							
									<th class="">PAÍS</th>							
									<th class="">PERFIL</th>									
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
					<label class="" for="email">Correo:</label>
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
<!-- FIN EDITAR -->
<!-- FIN MODAL -->

<!-- ----- MODAL 2 ----- -->
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
<!-- FIN ELIMINAR -->
<!-- FIN MODAL -->

<script>

	$(document).ready(function(){
		listar();
		actualizar();
		eliminar();		
	});

	function cerrarmodal(){
		$("#modal1").fadeOut();		
		$("#modal2").fadeOut();		
	};

	function refresh() {
    setTimeout(function () {
			location.reload();
			listar();
    }, 3000);
	}

	// ZONA AJAX
	var actualizar = function(){
		$("#frm_actualizar").on("submit", function(){		
			//e.preventDefault();
			var frm = $(this).serialize();
			//console.log(frm);
			$.ajax({
				method: "POST",
				url: "models/updates/upusuario.php",
				dataType: 'json',
				data: frm
			}).done(function(resultado){			
					console.log(resultado);																		
					if(!resultado.error){						
						$("#info").html("<div class='alerta-exito'><i class='ico icon ion-android-done'></i>Se actualizarón los datos con exito!</div>");		
						$("#info").fadeOut(5000, function(){
							$(this).html("");
							$(this).fadeIn(3000);
						});						
						cerrarmodal();
						refresh();										
					}else{
					$("#info").html("<div class='alerta-error'><i class='ico icon ion-alert'></i>Hubo un error en el proceso por favor volver a probar!!</div>");
					$("#info").fadeOut(5000, function(){
						$(this).html("");
						$(this).fadeIn(3000);
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
			url: "models/deletes/usuario-delete.php",
			dataType:"json",
			data: $(this).serialize()
		}).done(function(resultado){
			console.log(resultado);			
			//listar();
			if(!resultado.error){						
				$("#info").html("<div class='alerta-exito'><i class='ico icon ion-android-done'></i> Se elimino con exito!</div>");	
				$("#info").fadeOut(5000, function(){
					$(this).html("");
					$(this).fadeIn(3000);
				});						
				cerrarmodal();
				refresh();				
			}else{
				$("#info").html("<div class='alerta-error'><i class='ico icon ion-alert'></i>Hubo un error en el proceso por favor volver a intentar!!</div>");
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
			"destroy":true,
			"ajax":{
				'method':'POST',
				'url':'models/searchs/usuarios.php'
			},
			"columns":[
				{"data":"id"},
				{"data":"nombre"},
				{"data":"ape_paterno"},
				{"data":"ape_materno"},
				{"data":"email"},	
				{"data":"celular"},
				{"data":"pais"},					
				{"data":"nombreperfil"}		
				// {"data":"fecha"}			
				<?php if($_SESSION['sesion_aprenDigital']['perfil_id'] <= '2'): ?>
				,
				{"defaultContent": "<a class='editar btn-2 btn-azul' title='Editar'><i class='fas fa-pen'></i></a><a class='eliminar btn-2 btn-rojo' title='Borrar'><i class='fas fa-trash-alt'></i></a>"}	
				<?php endif; ?>		
			],
			"language": idioma_espanol,
			"pageLength":25
		});
		obtener_data_editar("dt_listaUsuarios tbody", table);
		obtener_data_eliminar("dt_listaUsuarios tbody", table);
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
			 	nombre = $("#form_eliminar #box-nombre").html('Borrar al usuario : ' +data.nombre + ' ' + data.ape_paterno + ' ' + data.ape_materno);
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
