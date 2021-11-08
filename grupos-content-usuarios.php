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
					$datos = obtenerdatos($db, 'grupos', $id);
					if (!empty($datos) && mysqli_num_rows($datos) >= 1) :
						while ($dato = mysqli_fetch_assoc($datos)) :
					?>
						<h2 class="title">Grupo <?= $dato['nombre'] ?></h2>
					<?php
						endwhile;
					endif;
					?>
					<div class="box-botones">
						<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>
					</div>
				</div>
				
				<?php if (isset($_SESSION['completado'])) : ?>
					<div class="alerta-exito">
						<?= $_SESSION['completado'] ?>
					</div>
				<?php elseif (isset($_SESSION['fallo'])) : ?>
					<div class="alerta-error">
						<?= $_SESSION['fallo'] ?>
					</div>
				<?php endif; ?>

				<div id="info"></div>
				
				<div class="inner-grupos-content ">					
					<div class="box-tabla mg-bt50 w100">
						<div class="box-titles">
							<h1 class="title">Lista de Alumnos/Usuarios agregados al grupo</h1>		
						</div>
						
						<div class="box-botones">
							<button type="button" class="btn-1" id="btnseleccionar" ><i class="fas fa-check-square"></i> Seleccionar Todos</button>
							<button type="button" class="btn-1" id="btndeseleccionar" ><i class="far fa-square"></i> Deseleccionar Todos</button>
							<a class="btn" id="eliminar-usuarios"><i class="fas fa-trash-alt"></i> Eliminar Usuarios</a>
						</div>								
														
						<table id="dt_usuariosGrupo" class="w100">
							<thead>
								<tr>						
									<th class="">Selecionar</th>									
									<th class="">Nombre</th>							
									<th class="">Apellidos</th>											
									<th class="">Correo</th>													
									<th class="">Opciones</th>								
								</tr>	
							</thead>
							<tbody>		
								<!-- <input type="text" name="grupo_id" value="<?//php echo $id; ?>" id="grupo_user">			-->
								<?php 
								$grupos = selectallusergrupo($db, 'grupos_usuarios','usuarios',  $id);
								if (!empty($grupos) && mysqli_num_rows($grupos) >= 1) :
									while ($grupo = mysqli_fetch_assoc($grupos)) :
								?> 
									<tr id="<?=$grupo['myid']?>">						
										<td >													
											<input type="checkbox" name="ids[]" value="<?=$grupo['myid']?>" class="users"> 
										</td>
										<td><?=$grupo['nombre']?> </td>
										<td><?=$grupo['ape_paterno'] . ' ' .$grupo['ape_materno']?></td>
										<td><?=$grupo['email']?></td>										
										<td>
											<!-- <a href="curso-details-edit.php?id=<?//=$grupo['id']?>" class="btn-2 btn-azul" title="Editar"><i class="fas fa-pen"></i></a> -->
											<a href="models/deletes/grupo-usuarios-delete-2.php?id=<?=$grupo['myid']?>" class=" btn-2" title="Borrar" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>
										</td>			
									</tr>
									<?php 
									endwhile;
								else : ?>
									<tr>
										<td colspan="5">No hay alumnos para mostrar.</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
						<!-- FIN TABLA -->					
					</div>
					<!-- box tabla -->
					
				</div>
				<div id="info2"></div>
				</div>
				<!-- center -->


				<?php borrarErrores(); ?>
			</div>
	</section>
	<?php include 'layout/footer.php'; ?>
	</div>
	</main>


	<script>
	
	$(document).ready(function(){
		
		$("#btnseleccionar").click(function(){			
				$("#dt_usuariosGrupo input[type=checkbox]").attr("checked", true);
			});		
  
		$("#btndeseleccionar").click(function(){
			$("#dt_usuariosGrupo input[type=checkbox]").attr("checked", false);
		});

	});


	$( "#eliminar-usuarios" ).click(function() {		
		var ids_array = [];		
		$("input:checkbox[class=users]:checked").each(function () {
			ids_array.push($(this).val());
		});

		if (ids_array.length>0) {
			console.log(ids_array);
			url = "models/deletes/grupo-usuarios-delete.php";			
			$.ajax({
				type: "POST",
				url: url,
				data: {ids_array : ids_array},
				success: function(respuesta){
					//console.log(respuesta);
					$.each(ids_array,function(indice,id) {
           // console.log('Indice es ' + indice + ' y id es: ' + id);
            var fila = $("#id" + id).remove(); //Oculto las filas eliminadas
					});
					refresh();
					var info = $("#info"), 
						info2 = $("#info2");
					info.html("<div class='alerta-exito'>El registro se elimino de forma exitosa</div>");
					info2.html("<div class='alerta-exito'>El registro se elimino de forma exitosa</div>");		
				}	
			}); 
		}else{
			var info = $("#info"), 
						info2 = $("#info2");
			info.html("<div class='alerta-error'>Debe seleccionar un usuario</div>");
			info2.html("<div class='alerta-error'>Debe seleccionar un usuario</div>");
		}

	}); 

	function refresh() {
    setTimeout(function () {
			location.reload();
    }, 500);
	}

	
</script>