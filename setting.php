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
					<h1 class="title">Ajustes Generales</h1>
					<div class="box-botones">
						<a class="btn" href="javascript:history.back()" title="Atras"><i 	class="fa fa-undo"></i> Regresar</a>	
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

	<?php include 'layout/footer.php'; ?>
  </body>
</html>