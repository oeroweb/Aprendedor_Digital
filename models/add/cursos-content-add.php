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
        
  if(mysqli_affected_rows($db)>0){
    $_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa";
    header("Location: ../../admin-cursos.php");					
  }else{
    $_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";
    header("Location: ../../admin-cursos.php");	
  }
}

?>