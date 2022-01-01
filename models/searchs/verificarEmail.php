
<?php
require_once '../../config/db.php';
$email    = $_REQUEST['email'];

$jsonData = array();
$sql   = ("SELECT email FROM usuarios WHERE email='".$email."' ");
$query         = mysqli_query($db, $sql);
$totalUsuarios  = mysqli_num_rows($query);

  
  if( $totalUsuarios <= 0 ){
    $jsonData['success'] = 0;
    //$jsonData['message'] = '<p class="alerta-exito"><i class="ico icon ion-alert"></i>El correo <strong>(' .$email.')<strong> está disponible</p>';
    $jsonData['message'] = '';
  } else {    
    $jsonData['success'] = 1;
    $jsonData['message'] = '<p class="alerta-error"><i class="ico icon ion-alert"></i>El correo <strong>"'.$email.'"</strong> no está disponible, ingresa otro correo.</p>';    
  }

header('Content-type: application/json; charset=utf-8');
echo json_encode( $jsonData );
?>