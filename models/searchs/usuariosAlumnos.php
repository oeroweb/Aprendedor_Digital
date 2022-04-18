<?php

  require_once '../../config/db.php';
  $sql = "SELECT u.*, p.nombre as nombreperfil, i.nombre as nombreInstitucion, g.nombre as nombreGrupo FROM usuarios u 
  INNER JOIN perfil p 
  on u.perfil_id = p.id
  INNER JOIN instituciones i
  on u.institucion_id = i.id
  INNER JOIN grupos_usuarios gu
  on u.id = gu.usuario_id
  INNER JOIN grupos g
  on gu.grupo_id = g.id
  WHERE u.estado_id = 1 ";

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