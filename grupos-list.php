<?php 
  include 'layout/header.php'; 
?>

<?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
          <h1 class="title">Administración de Grupos / Estodos de Grupo</h1>
				</div>
				<div class="box-botones mg-bt20">						
				<a href="admin-instituciones.php" class="btn" title="Añadir Curso"><i class="fas fa-plus"></i> Administrar Grupo</a>
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
							<input type="file" class="" value="Añadir Usuarios">							
						</div>
						<input type="submit" class="btn" value="Añadir Usuarios">
					</form>
					
					<hr class="w100">
					<div class="box-tabla mg-bt50 w100">
						<div class="box-titles">
							<h1 class="title">Lista de Usuarios</h1>
							<!-- <div class="box-botones">						
								<a href="#" class="btn-2 btn-azul " title="Editar Perfil"><i class="fas fa-pen"></i></a>						 
							</div> -->
						</div>									
						<table id="dt_usuarios" class="w100">
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

<!-- ----- MODAL 1 ----- -->
<!-- ----- EDITAR  ----- -->
<div class="modal" id="modal1">
	<div class="body-modal">
		<form action="" method="post" name="frm_actualizar" id="frm_actualizar" onsubmit="event.preventDefault(); ">			
			<h2 class="mg-bt10">Modificar datos</h2>
			<div class="w100 container mg-bt20">
				<label class="w35" for="nombre">ID<span class="obligatorio">*</span></label>
				<input class="w65" type="hidden" name="id" id="id">				
				<input class="w65" type="text" name="id" id="id2" disabled>		
			</div>					
			<div class="w100 container mg-bt20">
				<label class="w35" for="nombre">Nombres Completos<span class="obligatorio">*</span></label>	
				<input class="w65" type="text" name="nombre" id="nombre" required>	
			</div>
			<div class="w100 container mg-bt20">
				<label class="w35" for="">Apellido Paterno<span class="obligatorio">*</span></label>		
				<input class="w65" type="text" name="apepaterno" id="apepaterno" required>	
			</div>
			<div class="w100 container mg-bt20">
				<label class="w35 al-rg" for="">Apellido Materno:</label><br>
				<input class="w65" type="text" name="apematerno" id="apematerno" required>		
			</div>			
			<div class="w100 container mg-bt20">
				<label class="w35 al-rg" for="email">Correo:</label>
				<input class="w65" type="email" name="email" id="email" required>		
			</div>			
			<div class="w100 container mg-bt20">
				<label class="w35 al-rg" for="password">Contraseña:</label>
				<input class="w65" type="password" name="password" id="password" placeholder="Ingrese nueva contraseña">	
			</div>					
			<div class="w100 container mg-bt20">
				<label class="w35" for="">Cambiar de Perfil<span class="obligatorio">*</span></label>
				<select class="w65" name="rol" id="perfil" required>					
					<option value="0" disabled selected>Seleccion Perfil</option>
					<option value="admin">Administrador</option>					
					<option value="editor">Editor</option>					
					<option value="soporte">Soporte</option>	
					<option value="user">Usuario</option>
					<option value="tesoreria">Tesoreria</option>					
					<option value="demo">Visitante</option>
				</select>	
			</div>				
			<!-- <div class="w100 container mg-bt20">
				<label class="w35" for="">Cambiar de Perfil<span class="obligatorio">*</span></label>
				<select class="w65" name="tipoalmacen" id="tipoalmacen" required>
					<option value="">Seleccionar perfil</option>
					<?php 
						// $almacentipo = tipoAlmacen($db);
						// if(!empty($almacentipo) && mysqli_num_rows($almacentipo) >= 1):
						// 	while($dato = mysqli_fetch_assoc($almacentipo)):
					?>
					<option value="<?//=$dato['id']?>"><?//=$dato['nombre']?></option>
					<?php 
					// 	endwhile;
					// endif;
					?>
				</select>	
			</div>	-->
			<input type="submit" class="btn" value="Modificar">
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
			<h2>¿Estas de Seguro de Eliminar?</h2><hr>
			<div class="container3">					
				<span class="w100">¡No podrás revertir esto!</span>	
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
    }, 500);
	}

	// ZONA AJAX
	var actualizar = function(){
	$("#frm_actualizar").on("submit", function(e){		
		e.preventDefault();
		var frm = $(this).serialize();
			//console.log(frm);
			$.ajax({
				method: "POST",
				url: "usu_updates/upusuarios.php",
				dataType: 'json',
				data: frm
			}).done( function (resultado ){			
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
			url: "usu_deletes/deleteusuarios.php",
			dataType:"json",
			data: $(this).serialize()
		}).done(function(resultado){
			console.log(resultado);
			refresh();
			if(!resultado.error){						
				$("#info").html("<div class='alerta-exito'><i class='ico icon ion-android-done'></i> Se elimino con exito!</div>");	
				$("#info").fadeOut(5000, function(){
					$(this).html("");
					$(this).fadeIn(3000);
				});						
				cerrarmodal();				
			}else{
			$("#info").html("<div class='alerta-error'><i class='ico icon ion-alert'></i>Hubo un error en el proceso por favor volver a intentar!!</div>");
				$("#info").fadeOut(5000, function(){
					$(this).html("");
					$(this).fadeIn(3000);
					});
				}
			});
		});
	}
	
	var listar = function(){
		var table = $("#dt_usuarios").DataTable({
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
		obtener_data_editar("dt_usuarios tbody", table);
		obtener_data_eliminar("dt_usuarios tbody", table);
	}

	var obtener_data_editar = function(tbody, table){
	$(document).on("click",".editar",function(){	
		var data = table.row( $(this).parents("tr")).data();
			$("#modal1").fadeIn();
			$("#frm_actualizar #nombre").focus();				
			console.log(data);
			 var id= $("#frm_actualizar #id").val(data.id); 
			  id2= $("#frm_actualizar #id2").val(data.id); 
					nombre = $("#frm_actualizar #nombre").val(data.nombre);
					apepaterno = $("#frm_actualizar #apepaterno").val(data.apepaterno);
					apematerno = $("#frm_actualizar #apematerno").val(data.apematerno);
					correo = $("#frm_actualizar #email").val(data.email);			
					perfil = $("#frm_actualizar #perfil").val(data.rol)		
		});
	}

	var obtener_data_eliminar = function(tbody, table){
	$(document).on("click",".eliminar",function(){	
		var data = table.row( $(this).parents("tr")).data();
			$("#modal2").fadeIn();
			console.log(data);
			 var id = $("#form_eliminar #id").val(data.id);
			 	nombre = $("#form_eliminar #box-nombre").html(data.nombre + ' ' + data.apepaterno + ' ' + data.apematerno);
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
<?php include 'layout/footer.php'; ?>