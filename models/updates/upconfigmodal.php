<?php 

  require_once	'../../config/db.php';  

  if(!isset($_SESSION)){
    session_start();
  }
  
  $usuario_id = isset($_POST['usuario']) ? $_POST['usuario'] : false; 
  
  $sql = "UPDATE config_global set estado_id = 2 WHERE usuario_id = $usuario_id";
  $resultado = mysqli_query($db, $sql);

  if($resultado){
    $_SESSION['completado'] = '<i class="fas fa-check"></i>  Hecho.';	    
  } else{
    $_SESSION['fallo'] = '<i class="far fa-times-circle"></i> Por favor volver a intentar.';    
  }
?>
