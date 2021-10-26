<?php 

  require_once	('../../config/db.php');
  
  if(!isset($_SESSION)){
    session_start();
  }
        
  $clases = $_POST['ids_array'];
  $grupodetalle = $_POST['id_grupodetalle'];
  
  $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

  foreach($clases as $clase){
    $sql="INSERT INTO grupos_clases (grupofase_id, clase_id, acceso_id, fechacreacion, usuario, estado_id) VALUES ($grupodetalle, $clase, 4, CURDATE(), '$usuario',1);";

    $resultado = mysqli_query($db,$sql);
          
    if($resultado){
      $_SESSION['completado'] = "El registro se creo de forma exitosa";	
      header("Location: ../../admin-grupos.php");
    } else{
      $_SESSION['fallo'] = "Error al registrar; por favor volver a intentar";		
      header("Location: ../../admin-grupos.php");
    }
  }

?>