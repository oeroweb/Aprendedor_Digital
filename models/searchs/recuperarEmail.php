
<?php
require_once '../../config/db.php';
$email    = $_REQUEST['email'];

$jsonData = array();
$sql   = ("SELECT email FROM usuarios WHERE email='".$email."' ");
$query         = mysqli_query($db, $sql);
$totalUsuarios  = mysqli_num_rows($query);

  
  if( $totalUsuarios <= 0 ){
    $jsonData['success'] = 0;
    $jsonData['message'] = '<p class="alerta-error"><i class="ico icon ion-alert"></i>El correo <strong><i>"' .$email.'"</i></strong> no está registrado, por favor validar nuevamente.</p>';
    //$jsonData['message'] = '';
  } else {    
    $jsonData['success'] = 1;
    $jsonData['message'] = '<p class="alerta-exito"><i class="ico icon ion-alert"></i>Se validó el correo <strong>"'.$email.'"</strong>.</p>';
    //$jsonData['message'] = '';   
  }

header('Content-type: application/json; charset=utf-8');
echo json_encode( $jsonData );
?>