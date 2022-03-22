<?php 

  require_once	'../../config/db.php';  

  if(!isset($_SESSION)){
    session_start();
  }
  
  $id = isset($_POST['videoId']) ? $_POST['videoId'] : false; 
  $cursoid = isset($_POST['cursoId']) ? $_POST['cursoId'] : false; 
  $usuarioid = isset($_POST['usuarioId']) ? $_POST['usuarioId'] : false; 
  
  echo $id . ' '. $cursoid .' ' . $usuarioid;  

  $sql = "UPDATE grupos_usuarios_cursos set acceso_id = 3 WHERE id = $id";
  $resultado = mysqli_query($db, $sql);
  
  $sql2 = "UPDATE grupos_usuarios_cursos set proceso_id = 9 WHERE curso_id = $cursoid and usuario_id = $usuarioid";  
  $resultado2 = mysqli_query($db, $sql2);

  if($resultado){
    $_SESSION['completado'] = '<i class="fas fa-check"></i>  Hecho.';    
  } else{
    $_SESSION['fallo'] = '<i class="far fa-times-circle"></i> Ups! algo salio mal...';    
  }
?>
