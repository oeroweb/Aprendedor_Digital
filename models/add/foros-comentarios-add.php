<?php 

if(isset($_POST)){
  session_start();
  require_once	('../../config/db.php');
  
  $publicacion_id = isset($_POST['publicacion_id']) ? $_POST['publicacion_id'] : false;
  $usuariopublicacion_id = isset($_POST['publicacionusuario_id']) ? $_POST['publicacionusuario_id'] : false;
  $email_usuarioPublicacion = isset($_POST['publicacionemail']) ? trim($_POST['publicacionemail']) : false;
  $usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : false;
  $comentario = isset($_POST['comentario']) ? mysqli_real_escape_string($db, $_POST['comentario']) : false;	 
  $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];
 
  $sql="INSERT INTO comentarios (publicacion_id, usuario_id, comentario, fechacreacion, usuario, estado_id) VALUES ($publicacion_id, $usuario_id, '$comentario', CURDATE(), '$usuario', 1);";

  if($usuario_id != $usuariopublicacion_id){
    $sql2="INSERT INTO notificaciones (publicacion_id, usuario_publicion, usuario_comentario, tipo_mensaje, leido_id, fechacreacion, usuario, estado_id) VALUES ($publicacion_id, $usuariopublicacion_id, $usuario_id, 'ha respondido tu pregunta',6, CURDATE(), '$usuario', 1 );";

    $resultado2 = mysqli_query($db,$sql2);
  }
  
  
  //var_dump($sql2); die();
  $resultado = mysqli_query($db,$sql);

        
  if(mysqli_affected_rows($db)>0){
    $_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
  }else{
    $_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";					
  }
  header("Location: ../../foros.php");
}
?>