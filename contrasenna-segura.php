<?php 
  include 'layout/header.php';
  $usuario_id = $_SESSION['sesion_aprenDigital']['id'];
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
      <div class="center">
        <div class="box-titles">
					<h1 class="title">Cambio de Clave Inicial</h1>
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
        
        <div class="inner-content mg-bt20 w40">
          <form action="models/updates/upusuario-clave.php" method="post" class="box-formulario">
              <input type="hidden" name="id" value="<?=$usuario_id?>">
              <div class="box-input">
                <label for="clave">Crear nueva Clave</label>                
                <input type='text' placeholder="Clave nueva" name="clave" minlength="6" id="clave" required><br>
					      <a class="btn" onclick="getPassword();">Generar Clave</a>
              </div>
              <hr>
              <input type="submit" value="Cambiar y guardar" class="btn"> 
          </form>

        </div>

      </div>
    </div>

  </section>

  
  <?php include 'layout/footer.php'; ?>
  </body>
</html>
