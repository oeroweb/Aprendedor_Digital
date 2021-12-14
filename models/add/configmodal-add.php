<?php 
  
  require_once	('../../config/db.php');  
  
  if(!isset($_SESSION)){
    session_start();
  }
  
  $usuario_id = isset($_POST['usuario']) ? $_POST['usuario'] : false; 
  
  $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];
  
  $sql="INSERT INTO config_global (usuario_id, nombre, descripcion, fechacreacion, usuario, estado_id) VALUES ($usuario_id,'No mostrar Modal', 'El usuario no desea ver nuevamente el modal de bienvenida', CURDATE(), '$usuario', 2);";
 
  $resultado = mysqli_query($db,$sql);
        
  if($resultado){
    $_SESSION['completado'] = '<i class="fas fa-check"></i>  Hecho.';	    
  } else{
    $_SESSION['fallo'] = '<i class="far fa-times-circle"></i> Por favor volver a intentar.';    
  }
  

?>