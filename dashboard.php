<?php 
  include 'layout/header.php';
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
      <div class="center">
        <?php 
          date_default_timezone_set('America/Lima');
          $ahora = date('d-m-Y h:i:s a');                    
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
      <h2 class="title">Bienvenido a nuestra Escuela Aprendedor Digital</h2>
      <p class="text">Te dejamos un video tutorial que te puede servir sobre cómo usar la plataforma.</p>   
      <div class="box-video">
        <!-- <video src="assets/videos/TUTORIAL_APRENDEDOR_DIGITAL.mp4" controls></video> -->
        <iframe src="https://www.youtube.com/embed/HTSoPTpoJ-U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
    <h2 class="title">Bienvenido a nuestra Escuela Aprendedor Digital</h2>
    <p class="text">Te dejamos un video tutorial que te puede servir sobre cómo usar la plataforma.</p>
    <div class="box-video">
      <iframe src="https://www.youtube.com/embed/HTSoPTpoJ-U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
