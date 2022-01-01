
<?php
require_once '../../config/db.php';
$nickname    = $_REQUEST['nickname'];

$jsonData = array();
$sql   = ("SELECT nickname FROM usuarios WHERE nickname='".$nickname."' ");
$query         = mysqli_query($db, $sql);
$totalUsuarios  = mysqli_num_rows($query);

  
  if( $totalUsuarios <= 0 ){
    $jsonData['success'] = 0;
    //$jsonData['message'] = '<p class="alerta-exito"><i class="ico icon ion-alert"></i>El usuario <strong>(' .$nickname.')<strong> está disponible</p>;
    $jsonData['message'] = '';
  } else {
    //Si hay datos entonces retornas algo
    $jsonData['success'] = 1;
    $jsonData['message'] = '<p class="alerta-error" style="font-size:14px"><i class="ico icon ion-alert"></i>El usuario <strong>"'.$nickname.'"</strong> no está disponible, probar con otro.</p>';    
  }


header('Content-type: application/json; charset=utf-8');
echo json_encode( $jsonData );
?>