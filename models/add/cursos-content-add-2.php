<?php 

if(isset($_POST)){
  session_start();
  require_once	('../../config/db.php');
  
  $id = isset($_POST['id']) ? $_POST['id'] : false;
  $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;	
  $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;	
  $orden = isset($_POST['orden']) ? $_POST['orden'] : false;  
  $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];
 
  $sql="INSERT INTO cursos_contenido (curso_id, nombre, descripcion, orden, fechacreacion, usuario, estado_id) VALUES ('$id','$nombre', '$descripcion', $orden, CURDATE(), '$usuario', 1);";
      
  $resultado = mysqli_query($db,$sql);
        
  if($resultado){
    echo json_encode(array('error' => false));
  }else{
    echo json_encode(array('error' => true));
  }
}

?>