<?php 
  include 'layout/header.php';

	$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
	$usuario_perfil = $_SESSION['sesion_aprenDigital']['perfil_id'];

	if($usuario_perfil >= 3){
		header("Location:dashboard.php");
	}
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
					<h1 class="title">ACCESOS RAPIDOS</h1>
					<div class="box-botones">
						<a class="btn" href="javascript:history.back()" title="Atras"><i class="fa fa-undo"></i> Regresar</a>	 
					</div>
				</div>
				<div class="box-info">
					<p class="text2"> <i class="fa fa-comment"></i> Aquí encontrás todos los botones del sistema para agilizar los acceso a las distintas pantallas <i class="fa fa-window-maximize" aria-hidden="true"></i>de manera más rapida.  </p>
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
				
				<div class="admin-multi-accesos container-wrap w100">
					<div class="grupos-botones mg-bt20 w100">					
						<div class="box-titles">
							<h2 class="title">ENLACES DE INSTITUCIONES</h2>							
						</div>
						<div class="inner-botones-rapidos">
							<a class="btn-display" href="admin-instituciones.php" title="Admin Instituciones">
								<i class="fas fa-hotel"></i>
								<span class="links_name"><i class="far fa-eye"></i> Administrar Instituciones</span>
							</a>
							<a class="btn-display" href="instituciones-add.php" title="Añadir Instituciones">
								<i class="fa fa-home" aria-hidden="true"></i>
								<span class="links_name"><i class="fas fa-plus"></i> Añadir Institución</span>
							</a>
						</div>
					</div>

					<div class="grupos-botones mg-bt20 w100">					
						<div class="box-titles">
							<h2 class="title">ENLACES DE USARIOS</h2>							
						</div>
						<div class="inner-botones-rapidos">
							<a class="btn-display" href="admin-usuarios.php" title="Admin Usuarios Alumnos">
								<i class="fa fa-user-graduate"></i>
								<span class="links_name"><i class="far fa-eye"></i> Administrar Usuarios (alumnos)</span>
							</a>
							<a class="btn-display" href="admin-usuarios-administradores.php" title="Admin Usuarios Administradores">
								<i class="fas fa-users-cog"></i>
								<span class="links_name"><i class="far fa-eye"></i> Administrar Usuarios (administradores)</span>
							</a>
							<a class="btn-display" href="admin-solicitudes.php" title="Admin Solicitudes">				
							<i class="fa fa-user-plus"></i>
								<span class="links_name"><i class="far fa-eye"></i> Administrar Solicitudes</span>
							</a>
						</div>
					</div>					

					<div class="grupos-botones mg-bt20 w100">					
						<div class="box-titles">
							<h2 class="title">ENLACES DE CURSOS Y CLASES MAESTRAS</h2>							
						</div>
						<div class="inner-botones-rapidos">
							<a class="btn-display" href="admin-cursos.php" title="Admin Cursos">
								<i class="fas fa-list-ol"></i> 
								<span class="links_name"><i class="far fa-eye"></i> Administrar Cursos</span>
							</a>
							<a class="btn-display" href="curso-add.php" title="Añadir curso">
								<i class="fa fa-address-book" aria-hidden="true"></i>
								<span class="links_name"><i class="fas fa-plus"></i> Añadir Curso</span>
							</a>
							<a class="btn-display" href="admin-clases-maestras.php" title="Admin Clases">
								<i class="fas fa-list-alt"></i>
								<span class="links_name"><i class="far fa-eye"></i> Administrar Clases Maestras</span>
							</a>
							<a class="btn-display" href="clases-add.php" title="Añadir Clases Maestra">
								<i class="fas fa-list-alt"></i>
								<span class="links_name"><i class="fas fa-plus"></i> Añadir Clase Maestra</span>
							</a>
						</div>
					</div>

					<div class="grupos-botones mg-bt20 w100">					
						<div class="box-titles">
							<h2 class="title">ENLACES DE GRUPOS</h2>							
						</div>
						<div class="inner-botones-rapidos">
							<a class="btn-display" href="admin-grupos.php" title="Admin Grupos">
								<i class="fas fa-boxes"></i>              
								<span class="links_name"><i class="far fa-eye"></i> Administrar Grupos</span>
							</a>
							<a class="btn-display" href="grupos-add.php" title="Añadir Grupo">
							<i class="fa fa-archive" aria-hidden="true"></i>
								<span class="links_name"><i class="fas fa-plus"></i> Añadir Grupo</span>
							</a>
						</div>
					</div>

					<div class="grupos-botones mg-bt20 w100">					
						<div class="box-titles">
							<h2 class="title">ENLACES DE EVENTOS</h2>							
						</div>
						<div class="inner-botones-rapidos">
							<a class="btn-display" href="admin-eventos.php" title="Admin Eventos">
							<i class="fas fa-video"></i> 
								<span class="links_name"><i class="far fa-eye"></i> Administrar Eventos</span>
							</a>
							<a class="btn-display" href="eventos-add.php" title="Añadir Eventos">
								<i class="fa fa-file-video" aria-hidden="true"></i>
								<span class="links_name"><i class="fas fa-plus"></i> Añadir Evento</span>
							</a>
						</div>
					</div>					
					<div class="grupos-botones mg-bt20 w100">					
						<div class="box-titles">
							<h2 class="title">ENLACES DE REPORTES</h2>							
						</div>
						<div class="inner-botones-rapidos">
							<a class="btn-display" href="#" title="Admin Eventos">
								<i class="fa fa-file-pdf"></i>
								<span class="links_name">Reporte de Usuarios</span>
							</a>
							
						</div>
					</div>					
					<div class="grupos-botones mg-bt20 w100">					
						<div class="box-titles">
							<h2 class="title">ENLACES DE AJUSTES</h2>
						</div>
						<div class="inner-botones-rapidos">
							<a class="btn-display" href="setting.php" title="Ajustes Generales">
								<i class="fa fa-cogs" aria-hidden="true"></i>
								<span class="links_name">Ajutes Generales</span>
							</a>
							
						</div>
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
			</div>
			<!--fin center  -->
			<?php borrarErrores(); ?>		
		</div>
	</section>
	<span class="ir-arriba hidden" id="btnArriba" title="Subir"><i class="fa fa-chevron-up"></i></span>
	<?php include 'layout/footer.php'; ?>
  </body>
</html>