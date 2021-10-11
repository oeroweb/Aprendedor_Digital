<?php 

  if(isset($_GET)){

    if(!isset($_SESSION)){
      session_start();
    }
    require_once	'../../config/db.php';	
  
    $id = $_GET['id'];
    
    $sql = "UPDATE cursos set estado_id = 1 WHERE id = $id";
    $resultado = mysqli_query($db, $sql);
  
    //var_dump($sql); die();
    if($resultado){
      $_SESSION['completado'] = "Activado forma exitosa";	
      header("Location: ../../admin-cursos.php");
    } else{
      $_SESSION['fallo'] = "Error al activar; por favor volver a intentar";
      header("Location: ../../admin-cursos.php");
    }
  }
?>
