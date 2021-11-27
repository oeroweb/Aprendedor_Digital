<?php 

if(isset($_POST)){
  session_start();
  require_once	('../../config/db.php');
  
  $publicacion_id = isset($_POST['publicacion_id']) ? $_POST['publicacion_id'] : false;
  $usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : false;
  $comentario = isset($_POST['comentario']) ? mysqli_real_escape_string($db, $_POST['comentario']) : false;	 
  $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];  
 
  $sql="INSERT INTO comentarios (publicacion_id, usuario_id, comentario, fechacreacion, usuario, estado_id) VALUES ($publicacion_id, $usuario_id, '$comentario', CURDATE(), '$usuario', 1);";
  
  //var_dump($sql); die();
  $resultado = mysqli_query($db,$sql);
        
  if(mysqli_affected_rows($db)>0){
    $_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
  }else{
    $_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";					
  }
  header("Location: ../../foros.php");
}
?>