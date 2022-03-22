<?php 
  include 'layout/header.php'; 
	
	if(!isset($_POST)){
		header("Location:admin-grupos.php");
	}else{		 		
		$id = $_GET['id'];
	
	}
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
					<?php 
						$datos = obtenerdatos($db, 'grupos', $id);        
							if(!empty($datos) && mysqli_num_rows($datos) >= 1):
								while($dato = mysqli_fetch_assoc($datos)):  
						?> 
					<h1 class="title">Añadir alumno(s) al  <?=$dato['nombre']?></h1>
					<?php endwhile; endif; ?>
					<div class="box-botones">
						<a class="btn" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>
					</div>
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

				<div class="container-wrap w100">															
					<div class="box-tabla mg-bt50 w100">
						<div class="box-titles">
							<h1 class="title">Lista de usuarios sin Grupo</h1>						
						</div>
						<div class="box-botones">
							<input type="button" class="btn-1" id="btnseleccionar" value="Seleccionar Todos">
							<input type="button" class="btn-1" id="btndeseleccionar" value="Deseleccionar Todos">
							<a class="btn" id="anadir-usuarios"><i class="fas fa-plus"></i> Añadir Usuarios</a>
						</div>								
						<table id="dt_usuariosAddGrupo" class="w100">
							<thead>
								<tr>						
									<th class="">SELECCIONAR</th>									
									<th class="">NOMBRES</th>							
									<th class="">APE. PATERNO</th>							
									<th class="">APE. MATERNO</th>							
									<th class="">EMAIL</th>													
									<th class="">INSTITUCION</th>								
								</tr>	
							</thead>
							<tbody>		
								<input type="hidden" name="grupo_id" value="<?php echo $id; ?>" id="grupo_user">						
								<?php 
								$datos = selecusuariosNotGrupo($db);        
									if(!empty($datos) && mysqli_num_rows($datos) >= 1):
										while($data = mysqli_fetch_assoc($datos)):  
								?> 
									<tr id="<?php echo $data['id']; ?>">						
										<td >													
											<input type="checkbox" name="ids[]" value="<?php echo $data['id']; ?>" <?php  ?> class="users"> 
										</td>
										<td><?=$data['nombre']; ?> </td>
										<td><?=$data['ape_paterno']; ?></td>
										<td><?=$data['ape_materno']; ?></td>
										<td><?=$data['email']; ?></td>
										<td><?=$data['nombreinstitucion']; ?></td>			
									</tr>
								<?php 
									endwhile;
								else : ?>
									<tr>
										<td colspan="6">No hay alumnos para mostrar.</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
						<!-- FIN TABLA -->					
					</div>					
										
				</div>
			</div>	
			
			<?php borrarErrores(); ?>		
		</div>
		</section>
	<?php include 'layout/footer.php'; ?>
</div>
</main>

<script>
	$(document).ready(function(){
		
		$("#btnseleccionar").click(function(){			
				$("#dt_usuariosAddGrupo input[type=checkbox]").attr("checked", true);
			});		
  
		$("#btndeseleccionar").click(function(){
			$("#dt_usuariosAddGrupo input[type=checkbox]").attr("checked", false);
		});

	});

	$( "#anadir-usuarios" ).click(function() {		
		var ids_array = [];
		var id_grupo = $("#grupo_user").val();
		$("input:checkbox[class=users]:checked").each(function () {
			ids_array.push($(this).val());
		});

		if (ids_array.length>0) {
			console.log(ids_array, id_grupo);
			url = "models/add/grupos-usuarios.php";			
			$.ajax({
				type: "POST",
				url: url,
				data: {ids_array : ids_array, id_grupo : id_grupo},
				success: function(respuesta){
					console.log(respuesta);
					refresh();
				}			
			}); 
		}else{
			var info = $("#info");
			info.html("<div class='alerta-error'>Debe seleccionar un usuario</div>");
		}

	}); 

	function refresh() {
    setTimeout(function () {
			location.reload();
    }, 500);
	}

	
</script>
