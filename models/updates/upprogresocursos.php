<?php 

  require_once	'../../config/db.php';  

  if(!isset($_SESSION)){
    session_start();
  }
  
  $id = isset($_POST['id']) ? $_POST['id'] : false; 
  $progreso = isset($_POST['progreso']) ? $_POST['progreso'] : false; 
  echo $progreso . ' ' . $id;  

  $sql = "UPDATE lista_cursos_usuario set proceso_id = 8, porcentaje = $progreso WHERE id = $id";
  $resultado = mysqli_query($db, $sql);

  // if($resultado){
  //   $_SESSION['completado'] = '<i class="fas fa-check"></i>  Hecho.';	    
  // } else{
  //   $_SESSION['fallo'] = '<i class="far fa-times-circle"></i> Por favor volver a intentar.';    
  // }
?>
