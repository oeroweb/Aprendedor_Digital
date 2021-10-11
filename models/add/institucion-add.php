<?php 

if(isset($_POST)){
  session_start();
  require_once	('../../config/db.php');
      
  $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;	
  $pais = isset($_POST['pais']) ? $_POST['pais'] : false;	
  $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;	
  $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
  $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];
 
  $sql="INSERT INTO instituciones (nombre, pais, localidad, direccion, fechacreacion, usuario, estado_id) VALUES ('$nombre', '$pais','$localidad','$direccion', CURDATE(), '$usuario',1);";
      
  $resultado = mysqli_query($db,$sql);
        
  if($resultado){
    $_SESSION['completado'] = "El registro se creo de forma exitosa";	
    header("Location: ../../admin-instituciones.php");
  } else{
    $_SESSION['fallo'] = "Error al eliminar el registro; por favor volver a intentar";		
    header("Location: ../../admin-instituciones.php");
  }
}

?>