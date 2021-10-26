<?php 

  if(isset($_POST)){
    session_start();
    require_once	('../../config/db.php');
        
    $grupo = isset($_POST['grupo']) ? $_POST['grupo'] : false;	
    $fase = isset($_POST['fase']) ? $_POST['fase'] : false;	
    $fecinicio = isset($_POST['fecinicio']) ? $_POST['fecinicio'] : false;	
    $fecfin = isset($_POST['fecfin']) ? $_POST['fecfin'] : false;	
    $acceso = isset($_POST['acceso']) ? $_POST['acceso'] : false;	
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
    
    $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];
   
    $sql="INSERT INTO grupos_fases (grupo_id, fase_id, fec_inicio, fec_fin, descripcion, acceso_id, fechacreacion, usuario, estado_id) VALUES ($grupo, $fase, '$fecinicio', '$fecfin','$descripcion', $acceso, CURDATE(), '$usuario',1);";
    
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