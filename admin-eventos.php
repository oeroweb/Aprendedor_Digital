<?php 
  include 'layout/header.php';

	$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
	$usuario_perfil = $_SESSION['sesion_aprenDigital']['perfil_id'];

	if($usuario_perfil >= 3){
		header("Location:dashboard.php");
	}

	$hoy = getdate();
	$t = time(); 
	//print_r($hoy); echo $t;
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
					<h1 class="title">Administración Eventos</h1>
					<div class="box-botones">
						<a class="btn" href="javascript:history.back()" title="Atras"><i 	class="fa fa-undo"></i> Regresar</a>	
					</div>				
				</div>
				<div class="box-info">
					<p class="text"> <i class="fas fa-info-circle"></i> Se lista los eventos creados.</p>
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

				<div class="admin-eventos-content">					
					<div class="box-botones">						
						<a href="eventos-add.php" class="btn nuevo"> Añadir nuevo Evento</a>
					</div>					
					
					<div class="box-tabla mg-bt50 w100">													
						<table id="dt_listaEventos" class="w100">
							<thead>
								<tr>						
									<th class="">Items</th>
									<th class="">Titulo del Evento</th>	
									<th class="">Descripción / Texto</th>					
									<th class="">Fecha del Evento</th>					
									<th class="">Imagen</th>											
									<th class="">Estados</th>											
									<th class="w10">Opciones</th>												
								</tr>	
							</thead>
							<tbody>										
								<?php 
								$datos = selectalldatos($db,'eventos');
								if (!empty($datos) && mysqli_num_rows($datos) >= 1) :
									$cantidad = mysqli_num_rows($datos);
									$contador = 0;
									// $cantidad = mysqli_num_rows($datos); echo $cantidad;
									while ($dato = mysqli_fetch_assoc($datos)) :	
										$contador = $contador + 1;																	
								?> 										
									<tr>						
										<td ><?=$contador?>	</td>
										<td><?=$dato['titulo'] ?></td>
										<td>
											<?php if(strlen($dato['texto']) < 80): ?>
												<?=$dato['texto']?>
											<?php else :?>
												<?=substr($dato['texto'],0,120).'...'?>
											<?php endif;?>
										</td>
										<td><?=$dato['fechaevento']?></td>										
										<td class="w20">										
											<?php if($dato['imagen'] != null) :?>
												<img src="assets/eventos/<?php echo $dato['carpeta'].'/'.$dato['imagen'] ?>">
											<?php else : ?>
												<img src="assets/img/clases/curso.PNG" alt="">
											<?php endif; ?>
										</td>
										<td class="al-ct">								
										<?php if($dato['estado_id'] == 2) :?>
											<a href="models/updates/eventos-public.php?id=<?=$dato['id']?>" class="btn-3" title="No publicado">							
											<img src="assets/fonts/toggle-of.svg" alt="Inactivo">		
											Inactivo</a>												
										<?php else : ?>
											<a href="models/updates/eventos-private.php?id=<?=$dato['id']?>" class="btn-3" title="Activo">			
											<img src="assets/fonts/toggle-on.svg" alt="activo">	
											Activo</a>												
										<?php endif; ?>	
									</td>	
										<td class="">	
											<a href="eventos-edit.php?id=<?=$dato['id']?>" class="btn-2 btn-azul" title="Editar curso"><i class="fas fa-pen"></i></a>
											<a href="models/deletes/eventos-delete.php?id=<?=$dato['id']?>" class=" btn-2" title="Borrar curso" onclick="return confirmDelete()"> <i class="fas fa-trash-alt"></i></a>		
									</td>										
									</tr>										
								<?php 								
									endwhile; 									 
								else :  
								?>
									<tr><td colspan="5">No hay eventos añadidos.</td></tr>
								<?php endif;  ?>
							</tbody>
						</table>					
													
						<div id="info2"></div>
						
						<!-- FIN TABLA -->					
					</div>				
					
				</div>
				<!-- fin eventos content  -->
			
			</div>
			<!--fin center  -->
			<?php borrarErrores(); ?>		
		</div>
	
	</section>
	<span class="ir-arriba hidden" id="btnArriba" title="Subir"><i class="fa fa-chevron-up"></i></span>
	<?php include 'layout/footer.php'; ?>
</main>

<!-- ----- MODAL 1 ----- -->
<!-- ----- EDITAR  ----- -->
<div class="modal" id="modal1">
	<div class="body-modal">
		<form action="models/add/eventos-add.php" class="frmbody" method="post">
			<div class="w100 container-wrap mg-bt10" >
				<div class="box-input w50">
					<label for="archivo">Publicar para: </label>
					<select name="grupo_id" id="grupo_id">						
						<option value="">Seleccionar Grupo</option>
						<option value="0">Todos</option>
						<?php 
							$grupos = selectalldatos($db, 'grupos');
							if(!empty($grupos) && mysqli_num_rows($grupos) >= 1):
								while($grupo = mysqli_fetch_assoc($grupos)):
						?>
							<option value="<?=$grupo['id']?>" >
								<?=$grupo['nombre']?>								
							</option>
						<?php 
							endwhile;
						endif;
						?>	
					</select>
				</div>
				<div class="box-input w50">
					<label for="fecha">Fecha del Evento: </label>					
					<input type="datetime-local" name="fechaevento" id="fechaevento" required>
				</div>	
				<div class="box-input w100">										
					<label for="titulo">Titulo del Evento: </label>		
					<input class="w100 inputnombre" type="text" name="titulo" id="titulo" maxlength="200">
					<span class="counter counterNombre">250</span>
				</div>
				<div class="box-input w100">
					<label for="descripcion">Descripcion / Mensaje: </label>
					<textarea name="descripcion" class="textdescripcion" rows="5" id="descripcion" maxlength="500"></textarea>
					<span class="counter-2 counterDescripcion">250</span>
				</div>										
				<div class="box-input w100">
					<label for="link">Link o Iframe: </label>
					<textarea name="link" class="textdescripcion" id="link" rows="3" maxlength=""></textarea>
				</div>													
				<div class="box-input w50">
					<label for="imagen">Imagen: </label>
					<input type="file" name="imagen" id="imagen">
				</div>													
				<div class="box-input w50">
					<label for="archivo">Archivo: </label>
					<input type="file" name="archivo" id="archivo">
				</div>													
					
															
			</div>	
			<hr>
			<!-- <button id="btnagregar" type="button" class="btn">Añadir y Guardar</button> -->
			<!-- <button id="btncancelar" type="button" class="btn" onclick="cerrarmodal();">Cancelar</button> -->
			<input type="submit" value="Añadir y Guardar" class="btn" >
			<input type="reset" value="Cancelar" class="btn" onclick="cerrarmodal();">				
			
		</form>	
	</div>
</div>

<script>
	const input = document.querySelector("form .inputnombre"), 
	maxlength = input.getAttribute("maxlength"),
	counter = document.querySelector("form .counterNombre"), 
	textarea = document.querySelector("form .textdescripcion"), 
  maxlengtharea = textarea.getAttribute("maxlength"),
	counterarea = document.querySelector("form .counterDescripcion"); 

  input.onkeyup = () =>{
    counter.innerText = maxlength - input.value.length;
  }
  textarea.onkeyup = () =>{
    counterarea.innerText = maxlengtharea - textarea.value.length;
  }
</script>

<script>
	// $(document).ready(function(){
	// 	$(".nuevo").click(function(e){
	// 		e.preventDefault();	
	// 		$("#modal1").fadeIn();
	// 		$("#titulo").focus();		
	// 	});
		
	// });
	
	// function cerrarmodal(){
	// 	$("#modal1").fadeOut();
	// 	$("#modal1").reset();			
	// 	$("#modal2").fadeOut();		
	// };

	// $('#btnagregar').click(function(){
	// 	insert();
	// });

	// function insert(){
	// 	var datos = new FormData();
	// 	datos.append('grupoId', $("#grupo_id").val());
	// 	datos.append('fechaevento', $("#fechaevento").val());
	// 	datos.append('titulo', $("#titulo").val());
	// 	datos.append('descripcion', $("#descripcion").val());
	// 	datos.append('link', $("#link").val());
	// 	datos.append('imagen', $("#imagen").val());
	// 	datos.append('archivo', $("#archivo").val());

	// 	console.log(datos.get('grupoId'));
	// 	console.log(datos.get('fechaevento'));
	// 	console.log(datos.get('titulo'));
	// 	console.log(datos.get('descripcion'));
	// 	console.log(datos.get('link'));
	// 	console.log(datos.get('imagen'));
	// 	console.log(datos.get('archivo'));

	// 	$.ajax({
	// 		type: "post",
	// 		url : "models/add/eventos-add.php?action=insertar",
	// 		data : datos,
	// 		processData:false,
	// 		contentType:false,
	// 		success: function(response){
	// 			console.log(response);
	// 		}
	// 	});
	// }	

</script>