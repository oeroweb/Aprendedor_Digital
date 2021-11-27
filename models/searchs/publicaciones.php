<?php

  require_once '../../config/db.php';
  $sql = "SELECT * FROM publicacion p INNER JOIN usuarios u on p.usuario_id = u.id WHERE fase_id = 1 AND p.estado_id = 1";
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