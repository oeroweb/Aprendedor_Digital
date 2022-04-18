<?php

  require_once '../../config/db.php';
  $sql = "SELECT u.*, p.nombre as nombreperfil FROM usuarios u INNER JOIN perfil p 
  on u.perfil_id = p.id
  WHERE u.estado_id = 1 and p.id < 3";

  $result = mysqli_query($db, $sql);

  if(!$result){
    die("Error! Fallo de Comunicación");
  }else{
    while($data = mysqli_fetch_assoc($result)){
      $arreglo['data'][]= $data;
      
    }
    echo json_encode($arreglo);
  }
mysqli_free_result($result);
mysqli_close($db);

?>