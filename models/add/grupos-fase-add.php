<?php 

  require_once	('../../config/db.php');
  if(isset($_POST)){
    session_start();
  }

  $grupo = $_POST['idGrupo'];	
  $fases = $_POST['ids_array'];
  $fecinicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : false;	
  $fecfin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : false;	
  $acceso = isset($_POST['idAcceso']) ? $_POST['idAcceso'] : false;	
  $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
    
  $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

  foreach($fases as $fase){
    $sql="INSERT INTO grupos_fases (grupo_id, fase_id, fec_inicio, fec_fin, descripcion, acceso_id, fechacreacion, usuario, estado_id) VALUES ($grupo, $fase, '$fecinicio', '$fecfin','$descripcion', $acceso, CURDATE(), '$usuario',1);";
    
    $resultado = mysqli_query($db,$sql);
  }   

  if($resultado){
    echo "true";
  }else{
    echo "Error";
  }

?>