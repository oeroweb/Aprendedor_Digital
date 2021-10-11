<?php
  require_once('../../config/db.php');		
    
  if(!isset($_SESSION)){
      session_start();
  }
  $usuarios = $_POST['ids_array'];
  $grupo = $_POST['id_grupo'];
  $secion = $_SESSION['sesion_aprenDigital']['nombre'].' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

  foreach ($usuarios as $usuario) {
    $sql = "INSERT INTO grupos_usuarios ( grupo_id, usuario_id, fechacreacion, usuario, estado_id ) VALUES ('$grupo', '$usuario', NOW(), '$secion', 1)";
    
    $respuesta = mysqli_query($db, $sql);

    if($respuesta){
      $_SESSION['completado'] = "<i class='icon ion-android-done'></i> Se añadieron los usuarios correctamente";
    }else{
      $_SESSION['fallo'] = "<i class='icon ion-alert'></i> Error! No se completo el registro";
    }
  } 

?>