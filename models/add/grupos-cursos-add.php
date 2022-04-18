<?php 
  require_once	('../../config/db.php');
  
  if(!isset($_SESSION)){
    session_start();
  }
        
  $cursos = $_POST['ids_array'];
  $grupodetalle = $_POST['id_grupodetalle'];
  
  $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

  foreach($cursos as $curso){
    $sql="INSERT INTO grupos_cursos (grupofase_id, curso_id, acceso_id, fechacreacion, usuario, estado_id) VALUES ($grupodetalle, $curso, 3, CURDATE(), '$usuario',1);";

    $respuesta = mysqli_query($db,$sql);
          
    if($respuesta){
      $_SESSION['completado'] = '<i class="fas fa-check"></i> El registro se creo de forma exitosa';	
      header("Location: ../../admin-grupos.php");
    } else{
      $_SESSION['fallo'] = '<i class="far fa-times-circle"></i> Error al registrar; por favor volver a intentar';		
      header("Location: ../../admin-grupos.php");
    }
  }

?>