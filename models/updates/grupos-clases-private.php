<?php 

  if(isset($_GET)){

    if(!isset($_SESSION)){
      session_start();
    }
    require_once	'../../config/db.php';	
  
    $id = $_GET['id'];
    $idgroup = $_GET['idgroup'];
    
    $sql = "UPDATE grupos_clases set acceso_id = 4 WHERE id = $id";
    $resultado = mysqli_query($db, $sql);
  
    if($resultado){
      $_SESSION['completado'] = "Inactivado forma exitosa";	
      header("Location: ../../grupos-content-fase.php?id=$idgroup");
    } else{
      $_SESSION['fallo'] = "Error al inactivar; por favor volver a intentar";
      header("Location: ../../grupos-content-fase.php?id=$idgroup");
    }
  }
?>
