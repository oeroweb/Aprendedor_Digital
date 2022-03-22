<?php 

  if(isset($_GET)){

    if(!isset($_SESSION)){
      session_start();
    }
    require_once	'../../config/db.php';	
  
    $id = $_GET['id'];
    $idgroup = $_GET['idgroup'];
    
    $sql = "UPDATE grupos_clases set acceso_id = 3 WHERE id = $id";
    $resultado = mysqli_query($db, $sql);
  
    //var_dump($sql); die();
    if($resultado){
      $_SESSION['completado'] = "Activado forma exitosa";	
      header("Location: ../../grupos-content-fase.php?id=$idgroup");
    } else{
      $_SESSION['fallo'] = "Error al activar; por favor volver a intentar";
      header("Location: ../../grupos-content-fase.php?id=$idgroup");
    }
  }
?>
