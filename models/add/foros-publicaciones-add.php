<?php 

if(isset($_POST)){
  session_start();
  require_once	('../../config/db.php');
  
  $fase_id = isset($_POST['faseID']) ? $_POST['faseID'] : false;
  $usuario_id = isset($_POST['usuarioID']) ? $_POST['usuarioID'] : false;
  $publicacion = isset($_POST['publicacion']) ? mysqli_real_escape_string($db,$_POST['publicacion']) : false;	 
  $usuario = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

  $carpeta = $fase_id;

  //$ruta = $_SERVER['DOCUMENT_ROOT'] . '/escuela/assets/publicaciones/';
  $ruta = $_SERVER['DOCUMENT_ROOT'] . '/PAGaprendedor/escuela/assets/publicaciones/';

  if(!is_dir($carpeta)){
    mkdir($ruta.$carpeta, 0777);
  }
 
  $sql="INSERT INTO publicacion (fase_id, usuario_id, publicacion,  carpeta, fechacreacion, usuario, estado_id) VALUES ($fase_id, $usuario_id, '$publicacion', $carpeta, CURDATE(), '$usuario', 1);";
  
  //var_dump($sql); die();
  $resultado = mysqli_query($db,$sql);
        
  if($resultado){
    echo "true";
  }else{
    echo "Error";
  }
}
?>