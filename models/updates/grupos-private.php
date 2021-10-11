<?php 

  if(isset($_GET)){

    if(!isset($_SESSION)){
      session_start();
    }
    require_once	'../../config/db.php';	
  
    $id = $_GET['id'];
    
    $sql = "UPDATE grupos set estado_id = 2 WHERE id = $id";
    $resultado = mysqli_query($db, $sql);
  
    if($resultado){
      $_SESSION['completado'] = "Inactivado forma exitosa";	
      header("Location: ../../admin-grupos.php");
    } else{
      $_SESSION['fallo'] = "Error al inactivar; por favor volver a intentar";
      header("Location: ../../admin-grupos.php");
    }
  }
?>
