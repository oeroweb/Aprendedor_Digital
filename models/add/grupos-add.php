<?php 

  if(isset($_POST)){
    session_start();
    require_once	('../../config/db.php');
        
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;	
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;	
    
    $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];
   
    $sql="INSERT INTO grupos (nombre, descripcion, fechacreacion, usuario, estado_id) VALUES ('$nombre', '$descripcion', CURDATE(), '$usuario',1);";
        
    $resultado = mysqli_query($db,$sql);
          
    if($resultado){
      $_SESSION['completado'] = "El registro se creo de forma exitosa";	
      header("Location: ../../admin-grupos.php");
    } else{
      $_SESSION['fallo'] = "Error al eliminar el registro; por favor volver a intentar";		
      header("Location: ../../admin-grupos.php");
    }
  }

?>