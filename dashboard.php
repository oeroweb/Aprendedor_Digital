<?php 
  include 'layout/header.php';
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
      <div class="center">
        <?php $fecha = date('d-m-Y'); 
          //$tiempo =  timestamp(); 
          echo $fecha;
          echo '<br>';
          //echo $tiempo;

        ?>
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
      <img src="assets/img/hoja_de_ruta.jpg" alt="">
    </div>

  </section>
  <?php borrarErrores(); ?>	
  <?php include 'layout/footer.php'; ?>
  </body>
</html>

<script>

function refresh() {
  setTimeout(function () {
    location.reload();					
  }, 1000);
}

function cerrarmodal(){
  console.log("cerrar");
  $("#modalBienvenida").fadeOut();		
};

function validar(){
  var modal = document.getElementById("modalBienvenida"),
   usuario = document.getElementById("usuarioId").value,
   inputModal = document.getElementById("inputModal").checked;
  
  if(inputModal == true){
    url = "models/add/configmodal-add.php";	
    $.ajax({
    type: "POST",
    url: url,
    data: {usuario : usuario},
    success: function(respuesta){      
      cerrarmodal();
      refresh();
      }			
    }); 
  }else{
    cerrarmodal();
  }
}

function actualizar(){
  var modal = document.getElementById("modalBienvenida"),
   usuario = document.getElementById("usuarioId").value,
   inputModal = document.getElementById("inputModal").checked;
  
  if(inputModal == true){
    url = "models/updates/upconfigmodal.php";	
    $.ajax({
    type: "POST",
    url: url,
    data: {usuario : usuario},
    success: function(respuesta){      
      cerrarmodal();
      refresh();
      }			
    }); 
  }else{
    cerrarmodal();
  }
}

</script>

<?php
$usuario_id = $_SESSION['sesion_aprenDigital']['id'];
$configs = obtenerConfigGlobal($db, 'config_global', $usuario_id);
  if (!empty($configs) && mysqli_num_rows($configs) >= 1) :						
    while ($config = mysqli_fetch_assoc($configs)) :
?>
<?php if($config['estado_id'] == 1) : ?>
  <div class="modalBienvenida" id="modalBienvenida">
    <span class="closed-modal"><i class="fas fa-times"></i></span>
    <div class="box-modal">
      <h2 class="title">Mensaje de Bienvenida</h2>      
      <div class="box-video">
        <video src="assets/videos/TUTORIAL_APRENDEDOR_DIGITAL.mp4"></video>
      </div>
      <div class="box-input">				
        <input type="hidden" name="usuarioId" id="usuarioId" value="<?=$usuario_id;?>">	
        <input type="checkbox" name="inputmodal" class="inputmodal" id="inputModal">No volver a mostrar
      </div>
      <hr>
      <div class="box-input">
        <input type="button" class="btn" value="Guardar y cerrar" onclick="actualizar();">
      </div>
    </div>
  </div>
<?php endif; ?>	
<?php endwhile;	else: ?>
<div class="modalBienvenida" id="modalBienvenida">
  <span class="closed-modal"><i class="fas fa-times"></i></span>
  <div class="box-modal">
    <h2 class="title">Mensaje de Bienvenida</h2>
    <div class="box-video">
      <video src="assets/videos/TUTORIAL_APRENDEDOR_DIGITAL.mp4"></video>
    </div>
    
    <div class="box-input">				
      <input type="hidden" name="usuarioId" id="usuarioId" value="<?=$usuario_id;?>">	
      <input type="checkbox" name="inputmodal" class="inputmodal" id="inputModal">No volver a mostrar
    </div>
    <hr>
    <div class="box-input">
      <input type="button" class="btn" value="Guardar y cerrar" onclick="validar();">
    </div>
  </div>
</div>	
<?php endif; ?>		
