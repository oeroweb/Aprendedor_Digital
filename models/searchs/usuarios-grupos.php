<?php

  require_once '../../config/db.php';
  $sql = "SELECT u.*, i.nombre as nombreinstitucion FROM usuarios u INNER JOIN instituciones i 
  on u.institucion_id = i.id
  WHERE u.estado_id = 1 and u.perfil_id = 4";
  // $sql = "select *  from usuarios where estado_id=1";

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